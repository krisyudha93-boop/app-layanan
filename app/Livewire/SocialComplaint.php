<?php

namespace App\Livewire;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use App\Models\ComplaintCategory;
use App\Models\District;
use App\Models\NumberSequence;
use App\Models\StatusHistory;
use App\Models\Village;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Sampaikan Pengaduan Sosial â€” SAPA SOSIAL Kab. Blitar')]
class SocialComplaint extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1: Kategori
    public ?int $complaint_category_id = null;

    // Step 2: Lokasi & Deskripsi
    public ?int $district_id = null;
    public ?int $village_id = null;
    public string $location_detail = '';
    public string $description = '';
    public $attachment_file;

    // Step 3: Identitas Pelapor
    public string $reporter_name = '';
    public string $reporter_phone = '';
    public bool $agreement = false;

    // State
    public bool $isSubmitted = false;
    public string $submittedTicket = '';

    public function mount()
    {
        $firstCat = ComplaintCategory::where('is_active', true)->first();
        if ($firstCat) {
            $this->complaint_category_id = $firstCat->id;
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
                'complaint_category_id' => 'required|exists:complaint_categories,id',
            ], [
                'complaint_category_id.required' => 'Pilih kategori permasalahan sosial.',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'district_id' => 'required|exists:districts,id',
                'village_id' => 'required|exists:villages,id',
                'description' => 'required|min:15|max:1000',
                'attachment_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            ], [
                'district_id.required' => 'Pilih kecamatan lokasi kejadian.',
                'village_id.required' => 'Pilih desa/kelurahan lokasi kejadian.',
                'description.required' => 'Jelaskan deskripsi permasalahan secara rinci.',
                'description.min' => 'Deskripsi minimal 15 karakter agar jelas untuk ditindaklanjuti.',
            ]);
        }
    }

    public function submit()
    {
        $this->validateCurrentStep();

        $this->validate([
            'reporter_name' => 'required|min:3|max:100',
            'reporter_phone' => 'required|min:10|max:15',
            'agreement' => 'accepted',
        ], [
            'reporter_name.required' => 'Nama pelapor wajib diisi.',
            'reporter_phone.required' => 'Nomor WhatsApp / telepon wajib diisi untuk verifikasi dan tindak lanjut.',
            'agreement.accepted' => 'Anda harus menyetujui pernyataan kebenaran laporan.',
        ]);

        $ticket = DB::transaction(function () {
            $ticketNumber = NumberSequence::next('ADU');

            $complaint = Complaint::create([
                'complaint_number' => $ticketNumber,
                'complaint_category_id' => $this->complaint_category_id,
                'reporter_name' => $this->reporter_name,
                'reporter_phone' => $this->reporter_phone,
                'village_id' => $this->village_id,
                'location_detail' => $this->location_detail ?: null,
                'description' => $this->description,
                'status' => ComplaintStatus::RECEIVED,
                'reported_at' => now(),
            ]);

            if ($this->attachment_file) {
                $ext = $this->attachment_file->getClientOriginalExtension();
                $type = in_array(strtolower($ext), ['jpg', 'jpeg', 'png']) ? 'photo' : 'document';
                $path = $this->attachment_file->store('complaints', 'local');

                ComplaintAttachment::create([
                    'complaint_id' => $complaint->id,
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }

            StatusHistory::create([
                'statusable_type' => Complaint::class,
                'statusable_id' => $complaint->id,
                'from_status' => null,
                'to_status' => ComplaintStatus::RECEIVED->value,
                'notes' => 'Laporan pengaduan warga diterima melalui portal online.',
                'created_at' => now(),
            ]);

            return $ticketNumber;
        });

        $this->submittedTicket = $ticket;
        $this->isSubmitted = true;
    }

    public function render()
    {
        $categories = ComplaintCategory::where('is_active', true)->get();
        $districts = District::orderBy('name')->get();
        $villages = $this->district_id ? Village::where('district_id', $this->district_id)->orderBy('name')->get() : collect();

        $selectedCategory = $this->complaint_category_id ? ComplaintCategory::find($this->complaint_category_id) : null;

        return view('livewire.social-complaint', [
            'categories' => $categories,
            'districts' => $districts,
            'villages' => $villages,
            'selectedCategory' => $selectedCategory,
        ]);
    }
}

