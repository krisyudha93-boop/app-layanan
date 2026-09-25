<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keaslian Surat Keterangan DTSEN — SAPA SOSIAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-teal-700 text-white shadow">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">SAPA SOSIAL</h1>
                    <p class="text-xs text-teal-100">Dinas Sosial Kabupaten Blitar</p>
                </div>
            </div>
            <a href="/" class="text-xs bg-teal-800 hover:bg-teal-900 px-3 py-1.5 rounded-md font-medium transition">
                Portal Layanan
            </a>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-xl mx-auto px-4 py-8 w-full flex-1">
        @if($certificate && $certificate->serviceRequest)
            @php
                $isExpired = $certificate->valid_until && \Carbon\Carbon::parse($certificate->valid_until)->isPast();
            @endphp

            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <!-- Status Banner -->
                @if(!$isExpired)
                <div class="bg-emerald-600 px-6 py-5 text-white flex items-center space-x-3">
                    <div class="bg-white/20 p-2.5 rounded-full flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">DOKUMEN RESMI & TERVERIFIKASI</h2>
                        <p class="text-xs text-emerald-100">Surat Keterangan ini terdaftar secara sah di Dinas Sosial Kab. Blitar</p>
                    </div>
                </div>
                @else
                <div class="bg-amber-600 px-6 py-5 text-white flex items-center space-x-3">
                    <div class="bg-white/20 p-2.5 rounded-full flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold">DOKUMEN TELAH KEDALUWARSA</h2>
                        <p class="text-xs text-amber-100">Masa berlaku surat keterangan ini telah habis per {{ \Carbon\Carbon::parse($certificate->valid_until)->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                @endif

                <!-- Detail Body -->
                <div class="p-6 space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <div class="text-xs text-slate-500 uppercase font-semibold">Nomor Surat</div>
                        <div class="font-bold text-slate-900 text-base font-mono">{{ $certificate->certificate_number ?? '-' }}</div>
                        <div class="text-xs text-slate-500 mt-1">Kode Tiket: <span class="font-mono text-teal-700 font-semibold">{{ $certificate->serviceRequest->request_number }}</span></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 border-b border-slate-100 pb-4">
                        <div>
                            <div class="text-xs text-slate-500">Nama Pemohon</div>
                            <div class="font-semibold text-slate-800">{{ $certificate->serviceRequest->applicant_name }}</div>
                            <div class="text-xs font-mono text-slate-500">NIK: {{ substr($certificate->serviceRequest->applicant_nik, 0, 6) }}******{{ substr($certificate->serviceRequest->applicant_nik, -4) }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Yang Diterangkan</div>
                            <div class="font-semibold text-slate-800">{{ $certificate->subject_name ?: $certificate->serviceRequest->applicant_name }}</div>
                            <div class="text-xs text-slate-500">Hubungan: {{ $certificate->relationship_to_applicant ?: 'Pemohon Sendiri' }}</div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/70 space-y-2.5">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Peringkat Desil:</span>
                            <span class="font-bold bg-teal-100 text-teal-800 px-3 py-0.5 rounded-full text-sm">Desil {{ $certificate->decile }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Tujuan Penggunaan:</span>
                            <span class="font-semibold text-slate-800 text-right">{{ $certificate->purpose?->name }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Tanggal Terbit:</span>
                            <span class="font-semibold text-slate-800">{{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Masa Berlaku:</span>
                            <span class="font-semibold {{ $isExpired ? 'text-amber-700' : 'text-slate-800' }}">
                                {{ $certificate->valid_until ? \Carbon\Carbon::parse($certificate->valid_until)->translatedFormat('d F Y') : 'Sesuai Ketentuan' }}
                            </span>
                        </div>
                    </div>

                    <div class="pt-2 text-center">
                        <a href="{{ route('surat.dtsen.unduh', $certificate->id) }}" class="inline-flex items-center space-x-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span>Unduh Salinan Surat (PDF)</span>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl border border-red-200 p-8 text-center">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Dokumen Tidak Ditemukan</h2>
                <p class="text-sm text-slate-600 mb-6">
                    Kode verifikasi <span class="font-mono font-bold text-red-600">{{ $code }}</span> tidak terdaftar dalam database sistem SAPA SOSIAL Dinas Sosial Kabupaten Blitar.
                </p>
                <a href="/" class="inline-flex items-center text-sm font-semibold text-teal-700 hover:underline">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200">
        &copy; 2026 Dinas Sosial Kabupaten Blitar — SAPA SOSIAL (Satu Pintu Layanan Sosial)
    </footer>

</body>
</html>
