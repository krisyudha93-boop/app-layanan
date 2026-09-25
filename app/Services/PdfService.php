<?php

namespace App\Services;

use App\Models\DtsenCertificate;
use App\Models\PbiReactivation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfService
{
    /**
     * Generate and store PDF for SK DTSEN.
     */
    public static function generateDtsenCertificatePdf(DtsenCertificate $certificate): string
    {
        $request = $certificate->serviceRequest;

        // Ensure verification code exists
        if (empty($certificate->verification_code)) {
            $certificate->verification_code = 'DTSEN-' . strtoupper(Str::random(8));
            $certificate->save();
        }

        // Verification URL
        $verifyUrl = url('/verifikasi/' . $certificate->verification_code);

        // Generate QR code SVG or base64 PNG
        $qrSvg = QrCode::format('svg')->size(110)->generate($verifyUrl);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = Pdf::loadView('pdf.dtsen_certificate', [
            'certificate' => $certificate,
            'request' => $request,
            'qrCode' => $qrBase64,
            'verifyUrl' => $verifyUrl,
        ])->setPaper('a4', 'portrait');

        $fileName = 'sk_dtsen_' . Str::slug($certificate->certificate_number ?? $request->request_number) . '.pdf';
        $relativePath = 'certificates/' . $fileName;

        Storage::disk('local')->put($relativePath, $pdf->output());

        $certificate->file_path = $relativePath;
        $certificate->save();

        return $relativePath;
    }

    /**
     * Generate and store PDF for PBI Recommendation.
     */
    public static function generatePbiRecommendationPdf(PbiReactivation $pbi): string
    {
        $request = $pbi->serviceRequest;

        $verifyUrl = url('/cek-tiket/' . $request->request_number);
        $qrSvg = QrCode::format('svg')->size(100)->generate($verifyUrl);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = Pdf::loadView('pdf.pbi_recommendation', [
            'pbi' => $pbi,
            'request' => $request,
            'qrCode' => $qrBase64,
            'verifyUrl' => $verifyUrl,
        ])->setPaper('a4', 'portrait');

        $fileName = 'rekomendasi_pbi_' . Str::slug($pbi->recommendation_number ?? $request->request_number) . '.pdf';
        $relativePath = 'recommendations/' . $fileName;

        Storage::disk('local')->put($relativePath, $pdf->output());

        return $relativePath;
    }
}
