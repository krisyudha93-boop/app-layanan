<?php

namespace App\Livewire;

use App\Enums\DocumentVerificationStatus;
use App\Enums\ServiceRequestStatus;
use App\Models\District;
use App\Models\NumberSequence;
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
#[Title('Form Pengajuan Layanan Sosial Lainnya â€” SAPA SOSIAL')]
class SubmissionOther extends Component
{
    use WithFileUploads;

    public ?int $service_type_id = null;
    public string $applicant_name = '';
    public string $applicant_nik = '';
    public string $family_card_number = '';
    public string $address = '';
    public ?int $district_id = null;
    public ?int $village_id = null;
    public string $phone = '';

    // Uploaded files keyed by requirement ID
    public array $uploads = [];
    public bool $agreement = false;

    // State
    public bool $isSubmitted = false;
    public string $submittedTicket = '';

    public function mount()
    {
        $genericService = ServiceType::where('is_active', true)
            ->whereNotIn('handler', ['dtsen', 'pbi'])
            ->first() ?? ServiceType::first();

        if ($genericService) {
            $this->service_type_id = $genericService->id;
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

    public function submit()
    {
        $this->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'applicant_name' => 'required|min:3|max:100',
            'applicant_nik' => 'required|digits:16',
            'family_card_number' => 'required|digits:16',
            'address' => 'required|min:5',
            'district_id' => 'required|exists:districts,id',
            'village_id' => 'required|exists:villages,id',
            'phone' => 'required|min:10|max:15',
            'agreement' => 'accepted',
        ], [
            'service_type_id.required' => 'Pilih jenis layanan sosial.',
            'applicant_name.required' => 'Nama pemohon wajib diisi.',
            'applicant_nik.required' => 'NIK pemohon wajib 16 digit.',
            'applicant_nik.digits' => 'NIK pemohon harus 16 digit angka.',
            'family_card_number.required' => 'Nomor KK wajib 16 digit.',
            'family_card_number.digits' => 'Nomor KK harus 16 digit angka.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'district_id.required' => 'Pilih kecamatan.',
            'village_id.required' => 'Pilih desa/kelurahan.',
            'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'agreement.accepted' => 'Anda harus menyetujui pernyataan kebenaran berkas.',
        ]);

        $ticket = DB::transaction(function () {
            $serviceType = ServiceType::find($this->service_type_id);
            $prefix = $serviceType?->code ?: 'REQ';
            $ticketNumber = NumberSequence::next($prefix);

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

            // Save dynamic uploaded files
            foreach ($this->uploads as $reqId => $file) {
                if ($file) {
                    $path = $file->store('documents/generic', 'local');
                    ServiceRequestDocument::create([
                        'service_request_id' => $request->id,
                        'service_requirement_id' => $reqId,
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'verification_status' => DocumentVerificationStatus::PENDING,
                    ]);
                }
            }

            StatusHistory::create([
                'statusable_type' => ServiceRequest::class,
                'statusable_id' => $request->id,
                'from_status' => null,
                'to_status' => ServiceRequestStatus::SUBMITTED->value,
                'notes' => 'Pengajuan layanan sosial diterima melalui portal publik.',
                'created_at' => now(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
        $this->isSubmitted = true;
    }

    public function render()
    {
        $services = ServiceType::where('is_active', true)->get();
        $selectedService = $this->service_type_id ? ServiceType::find($this->service_type_id) : null;
        $requirements = $selectedService ? ServiceRequirement::where('service_type_id', $selectedService->id)->orderBy('sort_order')->get() : collect();

        $districts = District::orderBy('name')->get();
        $villages = $this->district_id ? Village::where('district_id', $this->district_id)->orderBy('name')->get() : collect();

        return view('livewire.submission-other', [
            'services' => $services,
            'selectedService' => $selectedService,
            'requirements' => $requirements,
            'districts' => $districts,
            'villages' => $villages,
        ]);
    }
}

