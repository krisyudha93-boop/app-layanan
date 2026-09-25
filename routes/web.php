<?php

use App\Models\DtsenCertificate;
use App\Models\PbiReactivation;
use App\Services\PdfService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

// Download SK DTSEN PDF
Route::get('/surat/dtsen/{certificate}/unduh', function (DtsenCertificate $certificate) {
    if (!$certificate->file_path || !Storage::disk('local')->exists($certificate->file_path)) {
        PdfService::generateDtsenCertificatePdf($certificate);
    }
    return Storage::disk('local')->download($certificate->file_path, 'SK_DTSEN_' . $certificate->serviceRequest->request_number . '.pdf');
})->name('surat.dtsen.unduh');

// Download Surat Rekomendasi PBI-JK PDF
Route::get('/surat/pbi/{pbi}/unduh', function (PbiReactivation $pbi) {
    $path = PdfService::generatePbiRecommendationPdf($pbi);
    return Storage::disk('local')->download($path, 'Rekomendasi_PBI_' . $pbi->serviceRequest->request_number . '.pdf');
})->name('surat.pbi.unduh');

// Halaman Verifikasi Keaslian SK DTSEN via QR Code
Route::get('/verifikasi/{code}', function (string $code) {
    $certificate = DtsenCertificate::where('verification_code', $code)->first();

    return view('verify_certificate', [
        'certificate' => $certificate,
        'code' => $code,
    ]);
})->name('surat.verifikasi');

