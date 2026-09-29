<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Informasi, FAQ &amp; Unduh Formulir</span>
    </nav>

    <!-- HEADER & SEARCH BAR -->
    <div class="space-y-6">
        <div class="max-w-3xl space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-primary rounded-full text-xs font-semibold">
                <span class="material-symbols-outlined text-xs">help</span>
                <span>Pusat Edukasi &amp; Tanya Jawab</span>
            </div>
            <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-primary tracking-tight">
                Pusat Informasi &amp; Formulir Pelayanan
            </h1>
            <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                Temukan jawaban pertanyaan umum, pedoman persyaratan, dan unduh berkas formulir resmi Dinas Sosial Kabupaten Blitar.
            </p>
        </div>

        <!-- SEARCH INPUT -->
        <div class="bg-surface-container-lowest p-2 rounded-2xl border border-surface-variant shadow-sm max-w-3xl">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-primary">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari pertanyaan, berkas, atau formulir..." 
                    class="w-full pl-11 pr-10 py-3.5 bg-transparent border-0 text-on-surface placeholder:text-outline text-sm sm:text-base focus:ring-0 focus:outline-none"
                />
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- FILTER TABS -->
        <div class="flex flex-wrap items-center gap-2 text-xs">
            <button 
                wire:click="setTab('semua')" 
                class="px-4 py-2 rounded-xl font-semibold transition-colors {{ $tab === 'semua' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Semua Informasi
            </button>
            <button 
                wire:click="setTab('program')" 
                class="px-4 py-2 rounded-xl font-semibold transition-colors {{ $tab === 'program' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Program Sosial
            </button>
            <button 
                wire:click="setTab('rehabilitasi')" 
                class="px-4 py-2 rounded-xl font-semibold transition-colors {{ $tab === 'rehabilitasi' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Rehabilitasi Sosial
            </button>
            <button 
                wire:click="setTab('disabilitas')" 
                class="px-4 py-2 rounded-xl font-semibold transition-colors {{ $tab === 'disabilitas' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Disabilitas &amp; Lansia
            </button>
        </div>
    </div>

    <!-- 1. UNDUH FORMULIR RESMI -->
    <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-3xl border border-surface-variant shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-surface-variant pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">download_for_offline</span>
                </div>
                <div>
                    <h2 class="font-headline text-lg font-bold text-primary">Unduh Formulir &amp; Format Berkas</h2>
                    <p class="text-xs text-on-surface-variant">Dokumen terstandar versi terbaru siap unduh dan cetak.</p>
                </div>
            </div>
            <span class="text-xs bg-surface-container text-primary font-bold px-3 py-1 rounded-full">
                {{ $forms->count() }} Berkas
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($forms as $form)
                <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container-high flex flex-col justify-between space-y-3 hover:border-primary/50 transition-colors">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-rose-600 text-3xl shrink-0">picture_as_pdf</span>
                        <div class="space-y-1">
                            <h4 class="font-headline font-bold text-xs sm:text-sm text-primary leading-tight">
                                {{ $form->name }}
                            </h4>
                            <div class="flex items-center gap-2 text-[10px] text-outline">
                                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold">Versi Terbaru</span>
                                <span>{{ $form->version ?? 'v1.0' }}</span>
                            </div>
                        </div>
                    </div>

                    <a 
                        href="{{ asset('storage/' . $form->file_path) }}" 
                        download 
                        class="w-full py-2 bg-surface-container hover:bg-primary hover:text-on-primary text-primary font-bold text-xs rounded-xl text-center flex items-center justify-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span>Unduh Berkas (PDF)</span>
                    </a>
                </div>
            @empty
                <!-- Fallback Mock Forms -->
                <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container-high flex flex-col justify-between space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-rose-600 text-3xl shrink-0">picture_as_pdf</span>
                        <div class="space-y-1">
                            <h4 class="font-headline font-bold text-xs sm:text-sm text-primary leading-tight">
                                Formulir Permohonan SK DTSEN Mandiri
                            </h4>
                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Versi Terbaru (v2026)</span>
                        </div>
                    </div>
                    <button type="button" onclick="alert('Mengunduh formulir...');" class="w-full py-2 bg-surface-container hover:bg-primary hover:text-on-primary text-primary font-bold text-xs rounded-xl flex items-center justify-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span>Unduh Berkas</span>
                    </button>
                </div>
                <div class="p-4 rounded-2xl bg-surface-container-low border border-surface-container-high flex flex-col justify-between space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-rose-600 text-3xl shrink-0">picture_as_pdf</span>
                        <div class="space-y-1">
                            <h4 class="font-headline font-bold text-xs sm:text-sm text-primary leading-tight">
                                Format Surat Keterangan Rawat Inap Faskes PBI
                            </h4>
                            <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Format Standar</span>
                        </div>
                    </div>
                    <button type="button" onclick="alert('Mengunduh formulir...');" class="w-full py-2 bg-surface-container hover:bg-primary hover:text-on-primary text-primary font-bold text-xs rounded-xl flex items-center justify-center gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span>Unduh Berkas</span>
                    </button>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 2. PERTANYAAN UMUM (FAQ) ACCORDION -->
    <section class="space-y-6" x-data="{ activeFaq: null }">
        <div class="border-b border-surface-variant pb-4">
            <h2 class="font-headline text-2xl font-bold text-primary">Pertanyaan yang Kerap Ditanyakan (FAQ)</h2>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                Kumpulan jawaban seputar teknis pendaftaran, verifikasi, dan tindak lanjut permohonan.
            </p>
        </div>

        <div class="space-y-3">
            @forelse ($faqs as $f)
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-4 shadow-sm">
                    <button 
                        type="button" 
                        @click="activeFaq = (activeFaq === {{ $f->id }} ? null : {{ $f->id }})" 
                        class="w-full flex items-center justify-between text-left font-headline font-bold text-sm sm:text-base text-primary"
                    >
                        <span>{{ $f->question }}</span>
                        <span class="material-symbols-outlined text-lg transition-transform" :class="activeFaq === {{ $f->id }} ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="activeFaq === {{ $f->id }}" class="mt-3 text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-surface-container-high pt-3">
                        {{ $f->answer }}
                    </div>
                </div>
            @empty
                <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-8 text-center text-xs text-on-surface-variant">
                    Tidak ada FAQ yang cocok dengan kata kunci pencarian.
                </div>
            @endforelse
        </div>
    </section>

    <!-- BOTTOM CTA -->
    <div class="bg-surface-container-low rounded-3xl p-8 border border-surface-container-high text-center space-y-4">
        <h3 class="font-headline text-xl font-bold text-primary">Tidak Menemukan Jawaban atas Pertanyaan Anda?</h3>
        <p class="text-xs sm:text-sm text-on-surface-variant max-w-md mx-auto">
            Tim layanan Dinas Sosial Kabupaten Blitar siap membantu Anda melalui konsultasi langsung di kantor atau posko Puskesos terdekat.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a href="{{ route('pengaduan') }}" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-xs sm:text-sm rounded-xl">
                Sampaikan Aduan / Pertanyaan
            </a>
            <a href="{{ route('home') }}" class="px-6 py-3 border border-outline-variant hover:border-primary text-primary font-bold text-xs sm:text-sm rounded-xl">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</div>
