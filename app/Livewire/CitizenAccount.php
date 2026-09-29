<?php

namespace App\Livewire;

use App\Models\Complaint;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Area Akun Masyarakat â€” SAPA SOSIAL')]
class CitizenAccount extends Component
{
    #[Url]
    public string $tab = 'masuk'; // 'masuk', 'daftar', 'pengajuan', 'profil'

    // Form Masuk
    public string $loginIdentifier = ''; // email or NIK
    public string $loginPassword = '';
    public bool $remember = false;

    // Form Daftar
    public string $regName = '';
    public string $regNik = '';
    public string $regPhone = '';
    public string $regEmail = '';
    public string $regPassword = '';
    public string $regPasswordConfirmation = '';

    // Filter Pengajuan
    public string $filterStatus = 'semua'; // 'semua', 'proses', 'selesai'

    public function mount()
    {
        if (Auth::check()) {
            $this->tab = 'pengajuan';
        }
    }

    public function login()
    {
        $this->validate([
            'loginIdentifier' => 'required',
            'loginPassword' => 'required',
        ], [
            'loginIdentifier.required' => 'Masukkan email atau NIK Anda.',
            'loginPassword.required' => 'Masukkan kata sandi.',
        ]);

        $identifier = trim($this->loginIdentifier);

        // Check if NIK or Email
        $user = User::where('email', $identifier)
            ->orWhere('nik', $identifier)
            ->first();

        if ($user && Hash::check($this->loginPassword, $user->password)) {
            Auth::login($user, $this->remember);
            $this->tab = 'pengajuan';
            session()->flash('success', 'Selamat datang kembali, ' . $user->name . '!');
            return;
        }

        $this->addError('loginIdentifier', 'Kombinasi email/NIK dan kata sandi tidak cocok.');
    }

    public function register()
    {
        $this->validate([
            'regName' => 'required|min:3|max:100',
            'regNik' => 'required|digits:16|unique:users,nik',
            'regPhone' => 'required|min:10|max:15',
            'regEmail' => 'required|email|unique:users,email',
            'regPassword' => 'required|min:8|same:regPasswordConfirmation',
        ], [
            'regName.required' => 'Nama lengkap wajib diisi.',
            'regNik.required' => 'NIK wajib 16 digit.',
            'regNik.digits' => 'NIK harus berupa 16 digit angka.',
            'regNik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'regEmail.required' => 'Email aktif wajib diisi.',
            'regEmail.unique' => 'Email ini sudah terdaftar.',
            'regPassword.required' => 'Kata sandi minimal 8 karakter.',
            'regPassword.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $this->regName,
            'nik' => $this->regNik,
            'phone' => $this->regPhone,
            'email' => $this->regEmail,
            'password' => Hash::make($this->regPassword),
            'is_active' => true,
        ]);

        // Assign 'masyarakat' role if Spatie exists
        try {
            $user->assignRole('masyarakat');
        } catch (\Exception $e) {
            // Role may already be default
        }

        Auth::login($user);
        $this->tab = 'pengajuan';
        session()->flash('success', 'Akun berhasil dibuat! Selamat datang di SAPA SOSIAL.');
    }

    public function logout()
    {
        Auth::logout();
        $this->tab = 'masuk';
        session()->flash('success', 'Anda telah berhasil keluar dari akun.');
    }

    public function render()
    {
        $user = Auth::user();
        $myRequests = collect();
        $myComplaints = collect();

        if ($user) {
            $reqQuery = ServiceRequest::with('serviceType')
                ->where(function ($q) use ($user) {
                    $q->where('submitter_id', $user->id)
                      ->orWhere('applicant_nik', $user->nik);
                })
                ->orderBy('created_at', 'desc');

            if ($this->filterStatus === 'proses') {
                $reqQuery->whereNotIn('status', ['completed', 'rejected']);
            } elseif ($this->filterStatus === 'selesai') {
                $reqQuery->whereIn('status', ['completed', 'rejected']);
            }

            $myRequests = $reqQuery->get();

            $myComplaints = Complaint::with('complaintCategory')
                ->where('reporter_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('livewire.citizen-account', [
            'user' => $user,
            'myRequests' => $myRequests,
            'myComplaints' => $myComplaints,
        ]);
    }
}

