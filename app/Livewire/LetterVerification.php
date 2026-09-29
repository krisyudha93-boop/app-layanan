<?php

namespace App\Livewire;

use App\Models\DtsenCertificate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Verifikasi Keaslian Surat Keterangan â€” SAPA SOSIAL')]
class LetterVerification extends Component
{
    public string $code = '';
    public bool $hasVerified = false;
    public ?DtsenCertificate $certificate = null;
    public string $verifyStatus = ''; // 'valid', 'expired', 'not_found'

    public function mount(?string $code = null)
    {
        if ($code) {
            $this->code = $code;
            $this->verify();
        }
    }

    public function verify()
    {
        $cleanCode = strtoupper(trim($this->code));
        $this->hasVerified = true;

        if (empty($cleanCode)) {
            $this->verifyStatus = 'not_found';
            $this->certificate = null;
            return;
        }

        $cert = DtsenCertificate::with(['serviceRequest.village.district', 'dtsenPurpose', 'signer'])
            ->where('verification_code', $cleanCode)
            ->first();

        if (!$cert) {
            $this->verifyStatus = 'not_found';
            $this->certificate = null;
            return;
        }

        $this->certificate = $cert;

        // Check if expired
        if ($cert->valid_until && $cert->valid_until->isPast()) {
            $this->verifyStatus = 'expired';
        } else {
            $this->verifyStatus = 'valid';
        }
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

    public function maskNik(string $nik): string
    {
        if (strlen($nik) < 8) return $nik;
        return substr($nik, 0, 4) . str_repeat('*', 8) . substr($nik, -4);
    }

    public function render()
    {
        return view('livewire.letter-verification');
    }
}

