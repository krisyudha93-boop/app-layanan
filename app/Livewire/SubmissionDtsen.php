<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\DtsenCertificate;
use App\Models\DtsenPurpose;
use App\Models\NumberSequence;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestDocument;
use App\Models\ServiceRequirement;
use App\Models\ServiceType;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Form Pengajuan Surat Keterangan DTSEN â€” SAPA SOSIAL')]
class SubmissionDtsen extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Tujuan Penggunaan
    public ?int $dtsen_purpose_id = null;
    public string $purpose_description = '';

    // Step 2: Data Pemohon & Data yang Diterangkan
    public string $applicant_name = '';
    public string $applicant_nik = '';
    public string $family_card_number = '';
    public string $address = '';
    public ?int $district_id = null;
    public ?int $village_id = null;
    public string $phone = '';

    public bool $is_same_as_applicant = false;
    public string $subject_name = '';
    public string $subject_nik = '';
    public string $relationship_to_applicant = 'Diri Sendiri';

    // Step 3: Unggah Berkas
    public $ktp_file;
    public $kk_file;

    // Step 4: Tinjau & Persetujuan
    public bool $agreement = false;

    // Success state
    public bool $isSubmitted = false;
    public string $submittedTicket = '';

    public function mount()
    {
        $firstPurpose = DtsenPurpose::where('is_active', true)->first();
        if ($firstPurpose) {
            $this->dtsen_purpose_id = $firstPurpose->id;
        }

        $firstDistrict = District::first();
        if ($firstDistrict) {
            $this->district_id = $firstDistrict->id;
        }
    }

    public function updatedDistrictId()
    {
        $this->village_id = null;
    }

    public function updatedIsSameAsApplicant($value)
    {
        if ($value) {
            $this->subject_name = $this->applicant_name;
            $this->subject_nik = $this->applicant_nik;
            $this->relationship_to_applicant = 'Diri Sendiri';
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
            $this->validate([
                'dtsen_purpose_id' => 'required|exists:dtsen_purposes,id',
            ], [
                'dtsen_purpose_id.required' => 'Pilih salah satu tujuan penggunaan surat.',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'applicant_name' => 'required|min:3|max:100',
                'applicant_nik' => 'required|digits:16',
                'family_card_number' => 'required|digits:16',
                'address' => 'required|min:5',
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'phone' => 'required|min:10|max:15',
                'subject_name' => 'required|min:3|max:100',
                'subject_nik' => 'required|digits:16',
                'relationship_to_applicant' => 'required',
            ], [
                'applicant_name.required' => 'Nama pemohon wajib diisi.',
                'applicant_nik.required' => 'NIK pemohon wajib 16 digit.',
                'applicant_nik.digits' => 'NIK pemohon harus terdiri dari 16 digit angka.',
                'family_card_number.required' => 'Nomor KK wajib 16 digit.',
                'family_card_number.digits' => 'Nomor KK harus terdiri dari 16 digit angka.',
                'address.required' => 'Alamat lengkap wajib diisi.',
                'district_id.required' => 'Pilih kecamatan.',
                'village_id.required' => 'Pilih desa / kelurahan.',
                'phone.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
                'subject_name.required' => 'Nama orang yang diterangkan wajib diisi.',
                'subject_nik.required' => 'NIK orang yang diterangkan wajib 16 digit.',
                'subject_nik.digits' => 'NIK orang yang diterangkan harus 16 digit angka.',
            ]);
        } elseif ($this->currentStep === 3) {
            $this->validate([
                'ktp_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'kk_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ], [
                'ktp_file.required' => 'Foto atau scan KTP wajib diunggah.',
                'ktp_file.mimes' => 'Format KTP harus JPG, PNG, atau PDF.',
                'ktp_file.max' => 'Ukuran berkas KTP maksimal 5 MB.',
                'kk_file.required' => 'Foto atau scan KK wajib diunggah.',
                'kk_file.mimes' => 'Format KK harus JPG, PNG, atau PDF.',
                'kk_file.max' => 'Ukuran berkas KK maksimal 5 MB.',
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
            $serviceType = ServiceType::where('handler', 'dtsen')->first();
            $ticketNumber = NumberSequence::next('DTSEN');

            // 1. Create Service Request
            $request = ServiceRequest::create([
                'request_number' => $ticketNumber,
                'service_type_id' => $serviceType?->id,
                'applicant_name' => $this->applicant_name,
                'applicant_nik' => $this->applicant_nik,
                'family_card_number' => $this->family_card_number,
                'address' => $this->address,
                'village_id' => $this->village_id,
                'phone' => $this->phone,
                'status' => ServiceRequestStatus::SUBMITTED,
                'submitted_at' => now(),
            ]);

            // 2. Create DTSEN Certificate Record
            $verificationCode = strtoupper(Str::random(10));
            DtsenCertificate::create([
                'service_request_id' => $request->id,
                'dtsen_purpose_id' => $this->dtsen_purpose_id,
                'purpose_description' => $this->purpose_description ?: null,
                'subject_name' => $this->subject_name,
                'subject_nik' => $this->subject_nik,
                'relationship_to_applicant' => $this->relationship_to_applicant,
                'verification_code' => $verificationCode,
            ]);

            // 3. Store uploaded documents
            $ktpPath = $this->ktp_file->store('documents/ktp', 'local');
            $kkPath = $this->kk_file->store('documents/kk', 'local');

            $ktpReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%KTP%')->first();
            $kkReq = ServiceRequirement::where('service_type_id', $serviceType?->id)->where('name', 'like', '%KK%')->first();

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

            // 4. Create initial Status History
            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $request->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::SUBMITTED->value,
                'notes' => 'Pengajuan berhasil dikirimkan oleh pemohon secara mandiri melalui portal publik.',
                'created_at' => now(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
        $this->isSubmitted = true;
    }

    public function render()
    {
        $purposes = DtsenPurpose::where('is_active', true)->get();
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id ? Village::where('district_id', $this->district_id)->orderBy('name')->get() : collect();

        $selectedPurpose = $this->dtsen_purpose_id ? DtsenPurpose::find($this->dtsen_purpose_id) : null;
        $selectedDistrict = $this->district_id ? District::find($this->district_id) : null;
        $selectedVillage = $this->village_id ? Village::find($this->village_id) : null;

        return view('livewire.submission-dtsen', [
            'purposes' => $purposes,
            'districts' => $districts,
            'villages' => $villages,
            'selectedPurpose' => $selectedPurpose,
            'selectedDistrict' => $selectedDistrict,
            'selectedVillage' => $selectedVillage,
        ]);
    }
}

