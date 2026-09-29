<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Cek Status Tiket</span>
    </nav>

    <!-- SEARCH STATE (TOP CARD) -->
    <section class="max-w-2xl mx-auto">
        <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-xl space-y-6">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-surface-container text-primary mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">manage_search</span>
                </div>
                <h1 class="font-headline text-2xl font-extrabold text-primary">Lacak Status Berkas &amp; Pengaduan</h1>
                <p class="text-xs sm:text-sm text-on-surface-variant">
                    Ketahui perkembangan verifikasi berkas permohonan atau laporan sosial Anda.
                </p>
            </div>

            <form wire:submit="search" class="space-y-4">
                <div>
                    <label for="ticket_no" class="block text-xs font-bold text-on-surface mb-1">
                        Nomor Tiket / Registrasi *
                    </label>
                    <div class="relative">
                        <input 
                            id="ticket_no"
                            wire:model="ticketNumber"
                            type="text" 
                            placeholder="Contoh: DTSEN-202609-00001 atau ADU-..."
                            class="w-full h-12 pl-11 pr-4 rounded-xl border-2 border-outline-variant focus:border-primary text-sm font-mono uppercase"
                        />
                        <span class="material-symbols-outlined absolute left-3.5 top-3 text-outline">tag</span>
                    </div>
                    @error('ticketNumber') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="verify_digits" class="block text-xs font-bold text-on-surface mb-1">
                        4 Digit Terakhir NIK atau No. WhatsApp (Verifikasi Privasi)
                    </label>
                    <div class="relative">
                        <input 
                            id="verify_digits"
                            wire:model="verificationDigits"
                            type="text" 
                            maxlength="4"
                            placeholder="Contoh: 1234 (Opsional)"
                            class="w-full h-11 pl-11 pr-4 rounded-xl border border-outline-variant focus:border-primary text-sm font-mono"
                        />
                        <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-outline">lock</span>
                    </div>
                    <span class="text-[11px] text-outline mt-1 block">
                        Masukkan 4 digit terakhir NIK atau WhatsApp pemohon untuk membuka detail identitas lengkap.
                    </span>
                </div>

                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transition-all active:scale-95"
                >
                    <span wire:loading.remove wire:target="search">Lacak Status Berkas</span>
                    <span wire:loading wire:target="search" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base animate-spin">refresh</span>
                        <span>Mencari data...</span>
                    </span>
                    <span class="material-symbols-outlined text-lg" wire:loading.remove wire:target="search">search</span>
                </button>
            </form>

            @if ($errorMessage)
                <div class="p-4 rounded-2xl bg-error/10 border border-error/20 text-error flex items-start gap-3 text-xs leading-relaxed">
                    <span class="material-symbols-outlined text-lg shrink-0 mt-0.5">error</span>
                    <span>{{ $errorMessage }}</span>
                </div>
            @endif
        </div>
    </section>

    <!-- RESULT STATE -->
    @if ($item)
        <section class="max-w-4xl mx-auto space-y-6">
            
            <!-- RESULT SUMMARY CARD -->
            <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-xl space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-surface-variant pb-6">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-outline font-bold uppercase tracking-wider">Tiket Pelayanan</span>
                            @if ($itemType === 'service' && $item->is_priority)
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">emergency</span>
                                    <span>Prioritas Darurat Medis</span>
                                </span>
                            @endif
                        </div>
                        <div class="font-mono text-2xl font-extrabold text-primary flex items-center gap-2">
                            <span>{{ $itemType === 'service' ? $item->request_number : $item->complaint_number }}</span>
                            <button 
                                type="button" 
                                onclick="navigator.clipboard.writeText('{{ $itemType === 'service' ? $item->request_number : $item->complaint_number }}'); alert('Nomor tiket berhasil disalin!');"
                                title="Salin Nomor Tiket"
                                class="text-outline hover:text-primary transition-colors"
                            >
                                <span class="material-symbols-outlined text-base">content_copy</span>
                            </button>
                        </div>
                        <div class="font-headline font-bold text-sm text-on-surface">
                            @if ($itemType === 'service')
                                {{ $item->serviceType?->name ?? 'Pengajuan Layanan Sosial' }}
                            @else
                                Pengaduan: {{ $item->complaintCategory?->name ?? 'Laporan Sosial' }}
                            @endif
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="flex flex-col items-start sm:items-end gap-1">
                        @php
                            $statusVal = $item->status instanceof \BackedEnum ? $item->status->value : $item->status;
                            $statusLabel = method_exists($item->status, 'label') ? $item->status->label() : ucfirst($statusVal);
                            
                            $badgeColor = match($statusVal) {
                                'issued', 'completed', 'resolved' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'revision_requested', 'clarification_requested' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'rejected', 'duplicate', 'invalid' => 'bg-rose-100 text-rose-800 border-rose-300',
                                default => 'bg-primary-fixed text-primary border-primary/20',
                            };
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-xs font-extrabold border {{ $badgeColor }} flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full {{ in_array($statusVal, ['issued', 'completed', 'resolved']) ? 'bg-emerald-600' : 'bg-current' }}"></span>
                            <span>{{ $statusLabel }}</span>
                        </span>
                        <span class="text-[11px] text-outline">
                            Diajukan: {{ ($item->submitted_at ?? $item->reported_at)?->translatedFormat('d F Y, H:i') ?? '-' }} WIB
                        </span>
                    </div>
                </div>

                <!-- MASKED APPLICANT INFO -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs bg-surface-container-low p-4 rounded-2xl border border-surface-container-high">
                    <div>
                        <span class="text-outline block mb-0.5">Nama Pemohon / Pelapor</span>
                        <strong class="font-bold text-on-surface text-sm">
                            {{ $this->maskName($item->applicant_name ?? $item->reporter_name ?? 'Warga') }}
                        </strong>
                    </div>
                    <div>
                        <span class="text-outline block mb-0.5">NIK (KTP)</span>
                        <strong class="font-bold text-on-surface font-mono text-sm">
                            @if (!empty($item->applicant_nik))
                                {{ $this->maskString($item->applicant_nik, 4, 4) }}
                            @else
                                Terlindungi
                            @endif
                        </strong>
                    </div>
                    <div>
                        <span class="text-outline block mb-0.5">Wilayah Domisili</span>
                        <strong class="font-bold text-on-surface text-sm">
                            {{ $item->village?->name ?? 'Kabupaten' }}, Kec. {{ $item->village?->district?->name ?? 'Blitar' }}
                        </strong>
                    </div>
                </div>

                <!-- SPECIAL BANNER: SURAT TERBIT (DOWNLOADABLE) -->
                @if ($certificate && in_array($statusVal, ['issued', 'completed']))
                    <div class="p-6 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-900 space-y-4">
                        <div class="flex items-start justify-between">
                            <div class="space-y-1">
                                <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-base">verified</span>
                                    <span>Surat Keterangan DTSEN Telah Terbit</span>
                                </div>
                                <h3 class="font-headline text-lg font-extrabold text-emerald-950">
                                    Nomor Surat: {{ $certificate->certificate_number ?? '400.9/DINSOS/2026' }}
                                </h3>
                                <p class="text-xs text-emerald-800">
                                    Dokumen resmi ber-TTE siap diunduh dan dicetak mandiri untuk keperluan administrasi Anda.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a 
                                href="{{ route('surat.dtsen.unduh', ['certificate' => $certificate->id]) }}" 
                                class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-extrabold flex items-center gap-2 shadow-sm transition-all"
                            >
                                <span class="material-symbols-outlined text-base">download</span>
                                <span>Unduh Surat Keterangan (PDF)</span>
                            </a>
                            @if ($certificate->verification_code)
                                <a 
                                    href="{{ route('surat.verifikasi', ['code' => $certificate->verification_code]) }}" 
                                    class="px-4 py-2.5 bg-white border border-emerald-300 text-emerald-800 hover:bg-emerald-100 rounded-xl text-xs font-bold flex items-center gap-1.5 transition-colors"
                                >
                                    <span class="material-symbols-outlined text-base">qr_code_scanner</span>
                                    <span>Cek Keaslian Dokumen</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($pbi && in_array($statusVal, ['recommendation_issued', 'proposed_to_ministry', 'ministry_approved', 'reactivated', 'completed']))
                    <div class="p-6 rounded-2xl bg-emerald-50 border-2 border-emerald-300 text-emerald-900 space-y-4">
                        <div class="space-y-1">
                            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 uppercase tracking-wider">
                                <span class="material-symbols-outlined text-base">health_and_safety</span>
                                <span>Surat Rekomendasi Reaktivasi Diterbitkan</span>
                            </div>
                            <h3 class="font-headline text-lg font-extrabold text-emerald-950">
                                No. Rekomendasi: {{ $pbi->recommendation_number ?? '440/REK-PBI/2026' }}
                            </h3>
                            <p class="text-xs text-emerald-800">
                                Berkas telah diusulkan ke Kementerian Sosial RI. Pantau status hingga aktif kembali di BPJS Kesehatan.
                            </p>
                        </div>
                        <div class="pt-2">
                            <a 
                                href="{{ route('surat.pbi.unduh', ['pbi' => $pbi->id]) }}" 
                                class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-extrabold inline-flex items-center gap-2 shadow-sm transition-all"
                            >
                                <span class="material-symbols-outlined text-base">download</span>
                                <span>Unduh Surat Rekomendasi (PDF)</span>
                            </a>
                        </div>
                    </div>
                @endif

                <!-- SPECIAL BANNER: REVISION NEEDED -->
                @if ($statusVal === 'revision_requested' || $statusVal === 'clarification_requested')
                    <div class="p-6 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-900 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-amber-800 uppercase">
                            <span class="material-symbols-outlined text-lg">warning</span>
                            <span>Perlu Perbaikan Berkas / Klarifikasi</span>
                        </div>
                        <p class="text-xs sm:text-sm font-medium leading-relaxed">
                            Catatan Petugas: <em>"{{ $item->officer_notes ?? 'Mohon periksa kembali kelengkapan foto dokumen Anda yang kurang jelas.' }}"</em>
                        </p>
                        <p class="text-xs text-amber-800">
                            Silakan hubungi kantor Dinsos atau operator desa Anda untuk melengkapi berkas yang diminta.
                        </p>
                    </div>
                @endif

                <!-- SPECIAL BANNER: REJECTED -->
                @if (in_array($statusVal, ['rejected', 'ministry_rejected', 'invalid']))
                    <div class="p-6 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-900 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-rose-800 uppercase">
                            <span class="material-symbols-outlined text-lg">cancel</span>
                            <span>Pengajuan Ditolak</span>
                        </div>
                        <p class="text-xs sm:text-sm font-medium leading-relaxed">
                            Alasan: <em>"{{ $item->rejection_reason ?? 'Data pemohon tidak memenuhi kriteria desil yang ditetapkan untuk tujuan penggunaan ini.' }}"</em>
                        </p>
                        <p class="text-xs text-rose-800">
                            Tindak lanjut: Bagi warga yang belum terdaftar atau ingin mengusulkan pemutakhiran data DTSEN, dapat menghubungi pemerintah desa setempat melalui mekanisme Musyawarah Desa (Musdes).
                        </p>
                    </div>
                @endif

                <!-- VERTICAL TIMELINE OF PROGRESS -->
                <div class="space-y-4 pt-4 border-t border-surface-variant">
                    <h3 class="font-headline text-lg font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">timeline</span>
                        <span>Riwayat Tahapan Pelayanan</span>
                    </h3>

                    @if ($statusHistories->isNotEmpty())
                        <div class="space-y-6 relative border-l-2 border-primary/20 ml-4 pl-6 pt-2">
                            @foreach ($statusHistories as $idx => $history)
                                <div class="relative">
                                    <div class="absolute -left-[31px] top-0 w-6 h-6 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-[10px] ring-4 ring-surface-container-low">
                                        {{ $idx + 1 }}
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                        <div class="font-headline font-bold text-xs sm:text-sm text-primary">
                                            Status: {{ ucfirst(str_replace('_', ' ', $history->to_status)) }}
                                        </div>
                                        <span class="text-[11px] text-outline">
                                            {{ $history->created_at?->translatedFormat('d M Y, H:i') ?? '-' }} WIB
                                        </span>
                                    </div>
                                    @if ($history->notes)
                                        <p class="text-xs text-on-surface-variant mt-1 leading-relaxed bg-surface-container-low p-2.5 rounded-xl border border-surface-container-high">
                                            {{ $history->notes }}
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-surface-container-low text-xs text-on-surface-variant">
                            Pengajuan baru saja terdaftar dan sedang mengantre verifikasi awal.
                        </div>
                    @endif
                </div>

                <!-- BOTTOM ACTIONS -->
                <div class="pt-6 border-t border-surface-variant flex flex-wrap items-center justify-between gap-4">
                    <button 
                        type="button" 
                        wire:click="resetSearch" 
                        class="px-4 py-2 border border-outline-variant hover:border-primary text-primary font-bold text-xs rounded-xl transition-colors"
                    >
                        Cari Tiket Lain
                    </button>
                    <a 
                        href="https://wa.me/6281234567890?text=Halo%20Dinsos%20Kab%20Blitar,%20saya%20ingin%20menanyakan%20status%20tiket%20{{ $itemType === 'service' ? $item->request_number : $item->complaint_number }}" 
                        target="_blank" 
                        class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-primary font-bold text-xs rounded-xl flex items-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-sm">chat</span>
                        <span>Hubungi Petugas Dinsos</span>
                    </a>
                </div>

            </div>

        </section>
    @endif

</div>
