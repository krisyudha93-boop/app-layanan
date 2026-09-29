<?php

namespace App\Livewire;

use App\Models\Complaint;
use App\Models\DtsenCertificate;
use App\Models\PbiReactivation;
use App\Models\ServiceRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Cek Status Tiket & Lacak Pengajuan â€” SAPA SOSIAL')]
class CheckStatus extends Component
{
    #[Url(as: 'tiket')]
    public string $ticketNumber = '';

    public string $verificationDigits = '';

    public bool $hasSearched = false;
    public ?string $errorMessage = null;

    // Found entity & type
    public ?string $itemType = null; // 'service' or 'complaint'
    public $item = null;
    public $certificate = null;
    public $pbi = null;
    public $statusHistories = [];

    public function mount()
    {
        if (!empty($this->ticketNumber)) {
            $this->performLookup(verify: false);
        }
    }

    public function search()
    {
        $this->validate([
            'ticketNumber' => 'required|min:4',
        ], [
            'ticketNumber.required' => 'Masukkan nomor tiket yang ingin dilacak.',
        ]);

        $this->performLookup(verify: !empty($this->verificationDigits));
    }

    protected function performLookup(bool $verify = false)
    {
        $this->hasSearched = true;
        $this->errorMessage = null;
        $this->item = null;
        $this->itemType = null;
        $this->certificate = null;
        $this->pbi = null;
        $this->statusHistories = [];

        $cleanTicket = strtoupper(trim($this->ticketNumber));

        // 1. Try Service Request
        $request = ServiceRequest::with(['serviceType', 'village.district', 'documents', 'statusHistories' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])->where('request_number', $cleanTicket)->first();

        if ($request) {
            if ($verify && !empty($this->verificationDigits)) {
                $digits = trim($this->verificationDigits);
                $lastNik = substr(preg_replace('/[^0-9]/', '', $request->applicant_nik), -4);
                $lastPhone = substr(preg_replace('/[^0-9]/', '', $request->phone), -4);

                if ($digits !== $lastNik && $digits !== $lastPhone) {
                    $this->errorMessage = 'Verifikasi 4 digit NIK atau Nomor HP tidak sesuai dengan data tiket.';
                    return;
                }
            }

            $this->item = $request;
            $this->itemType = 'service';
            $this->statusHistories = $request->statusHistories;

            if ($request->serviceType?->handler === 'dtsen') {
                $this->certificate = DtsenCertificate::where('service_request_id', $request->id)->first();
            } elseif ($request->serviceType?->handler === 'pbi') {
                $this->pbi = PbiReactivation::where('service_request_id', $request->id)->first();
            }
            return;
        }

        // 2. Try Complaint
        $complaint = Complaint::with(['complaintCategory', 'village.district', 'attachments', 'statusHistories' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }])->where('complaint_number', $cleanTicket)->first();

        if ($complaint) {
            if ($verify && !empty($this->verificationDigits)) {
                $digits = trim($this->verificationDigits);
                $lastPhone = substr(preg_replace('/[^0-9]/', '', $complaint->reporter_phone), -4);

                if ($digits !== $lastPhone) {
                    $this->errorMessage = 'Verifikasi 4 digit Nomor HP tidak sesuai dengan data pelapor.';
                    return;
                }
            }

            $this->item = $complaint;
            $this->itemType = 'complaint';
            $this->statusHistories = $complaint->statusHistories;
            return;
        }

        $this->errorMessage = 'Nomor tiket "' . $cleanTicket . '" tidak ditemukan. Mohon periksa kembali nomor registrasi Anda.';
    }

    public function resetSearch()
    {
        $this->ticketNumber = '';
        $this->verificationDigits = '';
        $this->hasSearched = false;
        $this->errorMessage = null;
        $this->item = null;
        $this->itemType = null;
    }

    public function maskString(string $string, int $start = 3, int $end = 3): string
    {
        $len = strlen($string);
        if ($len <= ($start + $end)) {
            return $string;
        }
        return substr($string, 0, $start) . str_repeat('*', min(6, $len - $start - $end)) . substr($string, -$end);
    }

    public function maskName(string $name): string
    {
        $parts = explode(' ', trim($name));
        $masked = [];
        foreach ($parts as $p) {
            if (strlen($p) <= 2) {
                $masked[] = $p;
            } else {
                $masked[] = substr($p, 0, 1) . str_repeat('*', strlen($p) - 2) . substr($p, -1);
            }
        }
        return implode(' ', $masked);
    }

    public function render()
    {
        return view('livewire.check-status');
    }
}

