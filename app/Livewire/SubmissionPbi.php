<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\PbiReason;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\NumberSequence;
use App\Models\PbiReactivation;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Form Reaktivasi KIS / PBI-JK â€” SAPA SOSIAL')]
class SubmissionPbi extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Data Peserta & Pemohon
    public string $participant_name = '';
    public string $participant_nik = '';
    public string $family_card_number = '';
    public string $bpjs_card_number = '';
    public string $deactivated_date = '';
    public string $address = '';
    public ?int $district_id = null;
    public ?int $village_id = null;

    public bool $is_same_as_participant = true;
    public string $applicant_name = '';
    public string $applicant_phone = '';

    // Step 2: Alasan Reaktivasi
    public string $reason = 'emergency';
    public string $health_facility_name = '';
    public string $health_letter_number = '';

    // Step 3: Unggah Berkas
    public $ktp_file;
    public $kk_file;
    public $bpjs_file;
    public $health_letter_file;

    // Step 4: Tinjau & Persetujuan
    public bool $agreement = false;

    // Success state
    public bool $isSubmitted = false;
    public string $submittedTicket = '';

    public function mount()
    {
        $firstDistrict = District::first();
        if ($firstDistrict) {
            $this->district_id = $firstDistrict->id;
        }
    }

    public function updatedDistrictId()
    {
        $this->village_id = null;
    }

    public function updatedIsSameAsParticipant($value)
    {
        if ($value) {
            $this->applicant_name = $this->participant_name;
        }
    }

    public function goToStep(int $step)
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
            return;
        }

        $this->validateCurrentStep();
        $this->currentStep = $step;
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function validateCurrentStep()
    {
        if ($this->currentStep === 1) {
            if ($this->is_same_as_participant) {
                $this->applicant_name = $this->participant_name;
            }

            $this->validate([
                'participant_name' => 'required|min:3|max:100',
                'participant_nik' => 'required|digits:16',
                'family_card_number' => 'required|digits:16',
                'bpjs_card_number' => 'required|min:10|max:20',
                'address' => 'required|min:5',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'applicant_name' => 'required|min:3',
                'applicant_phone' => 'required|min:10|max:15',
            ], [
                'participant_name.required' => 'Nama lengkap peserta wajib diisi.',
                'participant_nik.required' => 'NIK peserta wajib 16 digit.',
                'participant_nik.digits' => 'NIK peserta harus 16 digit angka.',
                'family_card_number.required' => 'Nomor KK wajib 16 digit.',
                'family_card_number.digits' => 'Nomor KK harus 16 digit angka.',
                'bpjs_card_number.required' => 'Nomor kartu BPJS/KIS wajib diisi.',
                'address.required' => 'Alamat lengkap wajib diisi.',
                'district_id.required' => 'Pilih kecamatan.',
                'village_id.required' => 'Pilih desa / kelurahan.',
                'applicant_phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
            ]);
        } elseif ($this->currentStep === 2) {
            $rules = [
                'reason' => 'required|in:chronic,catastrophic,emergency,newborn,other',
            ];

            if (in_array($this->reason, ['emergency', 'chronic', 'catastrophic'])) {
                $rules['health_facility_name'] = 'required|min:3';
            }

            $this->validate($rules, [
                'reason.required' => 'Pilih alasan reaktivasi.',
                'health_facility_name.required' => 'Nama fasilitas kesehatan (RSUD / Puskesmas) wajib diisi untuk alasan medis.',
            ]);
        } elseif ($this->currentStep === 3) {
            $rules = [
                'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'bpjs_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ];

            if (in_array($this->reason, ['emergency', 'chronic', 'catastrophic'])) {
                $rules['health_letter_file'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
            }

            $this->validate($rules, [
                'ktp_file.required' => 'Foto / Scan KTP wajib diunggah.',
                'kk_file.required' => 'Foto / Scan KK wajib diunggah.',
                'bpjs_file.required' => 'Foto / Scan Kartu BPJS/KIS wajib diunggah.',
                'health_letter_file.required' => 'Surat keterangan dari fasilitas kesehatan wajib diunggah untuk alasan medis.',
            ]);
        }
    }

    public function submit()
    {
        $this->validateCurrentStep();

        $this->validate([
            'agreement' => 'accepted',
        ], [
            'agreement.accepted' => 'Anda harus menyetujui pernyataan kebenaran data sebelum mengirim.',
        ]);

        $ticket = DB::transaction(function () {
            $serviceType = ServiceType::where('handler', 'pbi')->first();
            $ticketNumber = NumberSequence::next('PBI');
            $isPriority = in_array($this->reason, ['emergency', 'catastrophic']);

            // 1. Create Service Request
            $request = ServiceRequest::create([
                'request_number' => $ticketNumber,
                'service_type_id' => $serviceType?->id,
                'applicant_name' => $this->applicant_name ?: $this->participant_name,
                'applicant_nik' => $this->participant_nik,
                'family_card_number' => $this->family_card_number,
                'address' => $this->address,
                'village_id' => $this->village_id,
                'phone' => $this->applicant_phone,
                'status' => ServiceRequestStatus::SUBMITTED,
                'is_priority' => $isPriority,
                'submitted_at' => now(),
            ]);

            // 2. Create PBI Reactivation Record
            PbiReactivation::create([
                'service_request_id' => $request->id,
                'participant_name' => $this->participant_name,
                'participant_nik' => $this->participant_nik,
                'bpjs_card_number' => $this->bpjs_card_number,
                'deactivated_date' => $this->deactivated_date ?: null,
                'reason' => PbiReason::from($this->reason),
                'health_facility_name' => $this->health_facility_name ?: null,
                'health_letter_number' => $this->health_letter_number ?: null,
            ]);

            // 3. Store uploaded documents
            $ktpPath = $this->ktp_file->store('documents/pbi/ktp', 'local');
            $kkPath = $this->kk_file->store('documents/pbi/kk', 'local');
            $bpjsPath = $this->bpjs_file->store('documents/pbi/bpjs', 'local');

            $ktpReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%KTP%')->first();
            $kkReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%KK%')->first();
            $bpjsReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%BPJS%')->first();

            ServiceRequestDocument::create([
                'service_request_id' => $request->id,
                'service_requirement_id' => $ktpReq?->id,
                'file_path' => $ktpPath,
                'original_name' => $this->ktp_file->getClientOriginalName(),
                'verification_status' => DocumentVerificationStatus::PENDING,
            ]);

            ServiceRequestDocument::create([
                'service_request_id' => $request->id,
                'service_requirement_id' => $kkReq?->id,
                'file_path' => $kkPath,
                'original_name' => $this->kk_file->getClientOriginalName(),
                'verification_status' => DocumentVerificationStatus::PENDING,
            ]);

            ServiceRequestDocument::create([
                'service_request_id' => $request->id,
                'service_requirement_id' => $bpjsReq?->id,
                'file_path' => $bpjsPath,
                'original_name' => $this->bpjs_file->getClientOriginalName(),
                'verification_status' => DocumentVerificationStatus::PENDING,
            ]);

            if ($this->health_letter_file) {
                $healthPath = $this->health_letter_file->store('documents/pbi/health', 'local');
                $healthReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%Fasilitas%')->first();
                ServiceRequestDocument::create([
                    'service_request_id' => $request->id,
                    'service_requirement_id' => $healthReq?->id,
                    'file_path' => $healthPath,
                    'original_name' => $this->health_letter_file->getClientOriginalName(),
                    'verification_status' => DocumentVerificationStatus::PENDING,
                ]);
            }

            // 4. Initial Status History
            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $request->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::SUBMITTED->value,
                'notes' => 'Pengajuan reaktivasi KIS/PBI-JK berhasil dikirimkan.' . ($isPriority ? ' [PRIORITAS: Darurat Medis]' : ''),
                'created_at' => now(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
        $this->isSubmitted = true;
    }

    public function render()
    {
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id ? Village::where('district_id', $this->district_id)->orderBy('name')->get() : collect();

        $selectedDistrict = $this->district_id ? District::find($this->district_id) : null;
        $selectedVillage = $this->village_id ? Village::find($this->village_id) : null;

        return view('livewire.submission-pbi', [
            'districts' => $districts,
            'villages' => $villages,
            'selectedDistrict' => $selectedDistrict,
            'selectedVillage' => $selectedVillage,
        ]);
    }
}

