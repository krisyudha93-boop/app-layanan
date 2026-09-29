<?php

use App\Livewire\CitizenAccount;
use App\Livewire\CheckStatus;
use App\Livewire\Home;
use App\Livewire\InformationFaq;
use App\Livewire\ServiceDetail;
use App\Livewire\ServiceIndex;
use App\Livewire\SocialComplaint;
use App\Livewire\SubmissionDtsen;
use App\Livewire\SubmissionOther;
use App\Livewire\SubmissionPbi;
use App\Livewire\SocialRehabilitation;
use App\Livewire\LetterVerification;
use App\Models\DtsenCertificate;
use App\Models\PbiReactivation;
use App\Services\PdfService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes - Portal Publik SAPA SOSIAL Kab. Blitar
|--------------------------------------------------------------------------
*/

// 1. Beranda Portal Publik
Route::get('/', Home::class)->name('home');

// 2. Service Directory & Detail
Route::get('/layanan', ServiceIndex::class)->name('layanan.index');
Route::get('/layanan/{slug}', ServiceDetail::class)->name('layanan.detail');

// 3. Service Submission Forms
Route::get('/pengajuan/dtsen', SubmissionDtsen::class)->name('pengajuan.dtsen');
Route::get('/pengajuan/pbi', SubmissionPbi::class)->name('pengajuan.pbi');
Route::get('/pengajuan/lainnya', SubmissionOther::class)->name('pengajuan.lainnya');

// 4. Social Complaint Form
Route::get('/pengaduan', SocialComplaint::class)->name('pengaduan');

// 5. Ticket Status Tracker
Route::get('/lacak', CheckStatus::class)->name('lacak');
Route::get('/cek-status', CheckStatus::class);

// 6. Letter Authenticity Verification (QR / Unique Code)
Route::get('/verifikasi/{code?}', LetterVerification::class)->name('surat.verifikasi');

// 7. Social Rehabilitation Services
Route::get('/rehabilitasi', SocialRehabilitation::class)->name('rehabilitasi');

// 8. Information, FAQ & Form Downloads
Route::get('/informasi-faq', InformationFaq::class)->name('informasi.faq');

// 9. Citizen Account Portal
Route::get('/akun', CitizenAccount::class)->name('akun');

// 10. Unduh File PDF Resmi
Route::get('/surat/dtsen/{certificate}/unduh', function (DtsenCertificate $certificate) {
    if (!$certificate->file_path || !Storage::disk('local')->exists($certificate->file_path)) {
        PdfService::generateDtsenCertificatePdf($certificate);
    }
    return Storage::disk('local')->download($certificate->file_path, 'SK_DTSEN_' . $certificate->serviceRequest->request_number . '.pdf');
})->name('surat.dtsen.unduh');

Route::get('/surat/pbi/{pbi}/unduh', function (PbiReactivation $pbi) {
    $path = PdfService::generatePbiRecommendationPdf($pbi);
    return Storage::disk('local')->download($path, 'Rekomendasi_PBI_' . $pbi->serviceRequest->request_number . '.pdf');
})->name('surat.pbi.unduh');
