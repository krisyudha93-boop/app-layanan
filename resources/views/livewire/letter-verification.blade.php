<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Verifikasi Keaslian Surat</span>
    </nav>

    <!-- SEARCH INPUT CARD -->
    <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-xl space-y-6">
        <div class="text-center space-y-2 max-w-xl mx-auto">
            <div class="w-14 h-14 rounded-2xl bg-surface-container text-primary mx-auto flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">qr_code_scanner</span>
            </div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Verifikasi Keaslian Surat Keterangan</h1>
            <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                Masukkan kode verifikasi unik atau pindai QR Code yang tercantum pada lembar Surat Keterangan DTSEN Dinas Sosial Kabupaten Blitar.
            </p>
        </div>

        <form wire:submit="verify" class="max-w-md mx-auto space-y-4">
            <div>
                <label for="verification_code" class="block text-xs font-bold text-on-surface mb-1">
                    Kode Verifikasi Surat *
                </label>
                <div class="relative">
                    <input 
                        id="verification_code"
                        wire:model="code"
                        type="text" 
                        placeholder="Contoh: A1B2C3D4E5" 
                        class="w-full h-12 pl-11 pr-4 rounded-xl border-2 border-outline-variant focus:border-primary text-sm font-mono uppercase tracking-wider text-center"
                    />
                    <span class="material-symbols-outlined absolute left-3.5 top-3 text-outline">verified</span>
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-md transition-all active:scale-95"
            >
                <span class="material-symbols-outlined text-lg">check_circle</span>
                <span>Verifikasi Dokumen Sekarang</span>
            </button>
        </form>
    </div>

    <!-- VERIFICATION RESULT STATES -->
    @if ($hasVerified)
        
        @if ($verifyStatus === 'valid' && $certificate)
            <!-- STATE: VALID -->
            <div class="bg-surface-container-lowest rounded-3xl border-2 border-emerald-500 shadow-xl overflow-hidden animate-fadeIn">
                <!-- Header Status -->
                <div class="bg-emerald-600 text-white p-6 sm:p-8 text-center space-y-2">
                    <div class="w-16 h-16 rounded-full bg-white/20 text-white mx-auto flex items-center justify-center ring-8 ring-white/10 mb-2">
                        <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full inline-block">
                        Pemerintah Kabupaten Blitar — Dinas Sosial
                    </span>
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold">
                        Surat Asli dan Masih Berlaku
                    </h2>
                    <p class="text-xs sm:text-sm text-emerald-100 max-w-lg mx-auto">
                        Dokumen ini terdaftar resmi dalam basis data SAPA SOSIAL dan telah ditandatangani secara elektronik (BSrE).
                    </p>
                </div>

                <!-- Detail Body -->
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Nomor Surat Dinas</span>
                            <div class="font-mono text-sm font-bold text-primary">{{ $certificate->certificate_number ?? '400.9/123/409.XX/2026' }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Kode Verifikasi Unik</span>
                            <div class="font-mono text-sm font-bold text-emerald-700">{{ $certificate->verification_code }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Nama yang Diterangkan</span>
                            <div class="text-sm font-bold text-on-surface">{{ $this->maskName($certificate->subject_name) }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">NIK yang Diterangkan</span>
                            <div class="font-mono text-sm font-bold text-on-surface">{{ $this->maskNik($certificate->subject_nik) }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Tujuan Penggunaan</span>
                            <div class="text-sm font-bold text-primary">{{ $certificate->dtsenPurpose?->name ?? 'Surat Keterangan DTSEN' }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Status DTKS / Desil</span>
                            <div class="text-sm font-bold text-tertiary">
                                Terdaftar — {{ $certificate->decile ? 'Desil ' . $certificate->decile : 'Desil Terkonfirmasi' }}
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Tanggal Terbit</span>
                            <div class="text-sm font-semibold text-on-surface">{{ $certificate->issued_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}</div>
                        </div>

                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-container-high space-y-1">
                            <span class="text-outline uppercase font-semibold text-[10px]">Berlaku Hingga</span>
                            <div class="text-sm font-semibold text-on-surface">{{ $certificate->valid_until?->translatedFormat('d F Y') ?? 'Sesuai Masa Berlaku Ketentuan' }}</div>
                        </div>
                    </div>

                    <!-- Pejabat Penandatangan -->
                    <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container-high flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-xl">shield_person</span>
                            </div>
                            <div>
                                <div class="text-[11px] text-outline">Pejabat Penandatangan</div>
                                <div class="font-headline text-sm font-bold text-primary">Kepala Dinas Sosial Kabupaten Blitar</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                            TTE Tersertifikasi
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="pt-2 flex justify-center">
                        <a 
                            href="{{ route('surat.dtsen.unduh', ['certificate' => $certificate->id]) }}" 
                            class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary rounded-xl font-bold text-xs sm:text-sm flex items-center gap-2 shadow-md transition-all"
                        >
                            <span class="material-symbols-outlined text-base">download</span>
                            <span>Unduh Salinan Dokumen PDF Resmi</span>
                        </a>
                    </div>
                </div>
            </div>

        @elseif ($verifyStatus === 'expired' && $certificate)
            <!-- STATE: EXPIRED -->
            <div class="bg-surface-container-lowest rounded-3xl border-2 border-amber-500 shadow-xl p-8 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-700 mx-auto flex items-center justify-center ring-8 ring-amber-50">
                    <span class="material-symbols-outlined text-4xl">history</span>
                </div>
                <h2 class="font-headline text-2xl font-extrabold text-amber-900">
                    Surat Sudah Kedaluwarsa
                </h2>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-md mx-auto leading-relaxed">
                    Dokumen ini asli diterbitkan oleh Dinas Sosial Kabupaten Blitar, namun masa berlakunya telah berakhir pada tanggal <strong>{{ $certificate->valid_until?->translatedFormat('d F Y') }}</strong>.
                </p>
                <div class="pt-2">
                    <a href="{{ route('pengajuan.dtsen') }}" class="px-5 py-2.5 bg-primary text-on-primary font-bold text-xs rounded-xl inline-flex items-center gap-2">
                        <span>Ajukan Surat Keterangan Baru</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

        @else
            <!-- STATE: NOT FOUND -->
            <div class="bg-surface-container-lowest rounded-3xl border-2 border-rose-400 shadow-xl p-8 text-center space-y-4">
                <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-700 mx-auto flex items-center justify-center ring-8 ring-rose-50">
                    <span class="material-symbols-outlined text-4xl">gpp_bad</span>
                </div>
                <h2 class="font-headline text-2xl font-extrabold text-rose-900">
                    Kode Verifikasi Tidak Ditemukan
                </h2>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-md mx-auto leading-relaxed">
                    Dokumen dengan kode verifikasi <strong>"{{ $code }}"</strong> tidak tercatat dalam basis data resmi Dinas Sosial Kabupaten Blitar. Waspadai indikasi pemalsuan dokumen.
                </p>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3 text-xs">
                    <a href="{{ route('home') }}" class="px-4 py-2 border border-outline-variant hover:border-primary text-primary font-bold rounded-xl">
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('pengaduan') }}" class="px-4 py-2 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-700">
                        Laporkan Indikasi Pemalsuan
                    </a>
                </div>
            </div>

        @endif

    @endif

</div>
