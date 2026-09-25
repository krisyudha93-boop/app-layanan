<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\DtsenCertificate;
use App\Models\PbiReactivation;
use App\Services\PdfService;

$cert = DtsenCertificate::first();
if ($cert) {
    echo "Testing SK DTSEN PDF for Certificate ID: {$cert->id}...\n";
    $path = PdfService::generateDtsenCertificatePdf($cert);
    echo "SK DTSEN PDF generated successfully at: {$path}\n";
} else {
    echo "No DtsenCertificate found.\n";
}

$pbi = PbiReactivation::first();
if ($pbi) {
    echo "Testing PBI Recommendation PDF for PBI ID: {$pbi->id}...\n";
    $path = PdfService::generatePbiRecommendationPdf($pbi);
    echo "PBI PDF generated successfully at: {$path}\n";
} else {
    echo "No PbiReactivation found.\n";
}

echo "PDF tests completed!\n";
