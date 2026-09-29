<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Direktori Layanan Sosial</span>
    </nav>

    <!-- TITLE & HERO HEADER -->
    <div class="max-w-3xl space-y-3">
        <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-primary rounded-full text-xs font-semibold">
            <span class="material-symbols-outlined text-xs">verified</span>
            <span>Katalog Resmi Pelayanan Sosial Kabupaten Blitar</span>
        </div>
        <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-primary tracking-tight">
            Direktori &amp; Informasi Layanan Sosial
        </h1>
        <p class="text-base text-on-surface-variant leading-relaxed">
            Temukan informasi lengkap mengenai persyaratan, alur pelayanan, hingga formulir unduhan resmi Dinas Sosial Kabupaten Blitar secara transparan, mudah, dan bebas biaya.
        </p>
    </div>

    <!-- SEARCH & FILTER TOOLBAR -->
    <div class="space-y-4">
        <!-- Search Bar -->
        <div class="bg-surface-container-lowest p-2 rounded-2xl border border-surface-variant shadow-sm">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-primary">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    placeholder="Cari layanan, persyaratan, atau kata kunci..." 
                    class="w-full pl-11 pr-10 py-3.5 bg-transparent border-0 text-on-surface placeholder:text-outline text-sm sm:text-base focus:ring-0 focus:outline-none"
                />
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-outline hover:text-primary">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Category Filter Chips -->
        <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
            <span class="text-outline font-medium mr-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">filter_alt</span>
                <span>Kategori:</span>
            </span>
            <button 
                wire:click="setCategory('semua')" 
                class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $kategori === 'semua' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Semua Kategori
            </button>
            <button 
                wire:click="setCategory('surat')" 
                class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $kategori === 'surat' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Surat Keterangan
            </button>
            <button 
                wire:click="setCategory('kesehatan')" 
                class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $kategori === 'kesehatan' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Kesehatan (KIS/PBI)
            </button>
            <button 
                wire:click="setCategory('rehabilitasi')" 
                class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $kategori === 'rehabilitasi' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Rehabilitasi Sosial
            </button>
            <button 
                wire:click="setCategory('disabilitas')" 
                class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $kategori === 'disabilitas' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant hover:border-primary' }}"
            >
                Disabilitas &amp; Lansia
            </button>
        </div>
    </div>

    <!-- SERVICES GRID -->
    @if ($serviceTypes->isEmpty())
        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-12 text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-surface-container mx-auto flex items-center justify-center text-outline">
                <span class="material-symbols-outlined text-3xl">search_off</span>
            </div>
            <h3 class="font-headline text-lg font-bold text-primary">Layanan Tidak Ditemukan</h3>
            <p class="text-sm text-on-surface-variant max-w-md mx-auto">
                Tidak ada layanan yang cocok dengan kata kunci atau filter terpilih. Silakan ubah pencarian atau hubungi petugas Dinas Sosial.
            </p>
            <button wire:click="$set('search', ''); $set('kategori', 'semua')" class="px-5 py-2.5 bg-primary text-on-primary rounded-xl font-semibold text-xs hover:bg-primary-container transition-colors">
                Reset Pencarian
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($serviceTypes as $service)
                @php
                    $isDtsen = ($service->handler === 'dtsen' || str_contains(strtolower($service->name), 'dtsen'));
                    $isPbi = ($service->handler === 'pbi' || str_contains(strtolower($service->name), 'pbi') || str_contains(strtolower($service->name), 'kis'));
                    $isRehsos = ($service->code === 'REHSOS' || str_contains(strtolower($service->name), 'rehabilitasi'));
                    
                    $slug = match(true) {
                        $isDtsen => 'surat-keterangan-dtsen',
                        $isPbi => 'reaktivasi-kis-pbi-jk',
                        $isRehsos => 'pelayanan-rehabilitasi-sosial',
                        default => \Illuminate\Support\Str::slug($service->name),
                    };

                    $applyRoute = match(true) {
                        $isDtsen => route('pengajuan.dtsen'),
                        $isPbi => route('pengajuan.pbi'),
                        $isRehsos => route('rehabilitasi'),
                        default => route('pengajuan.lainnya'),
                    };
                @endphp

                <div class="bg-surface-container-lowest rounded-2xl border {{ ($isDtsen || $isPbi) ? 'border-2 border-primary/20 shadow-md' : 'border-outline-variant shadow-sm' }} p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-200 group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ ($isDtsen || $isPbi) ? 'bg-primary text-on-primary' : 'bg-surface-container text-primary' }}">
                                {{ $service->category ?? 'Layanan Sosial' }}
                            </span>
                            @if ($isDtsen || $isPbi)
                                <span class="text-[10px] font-bold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">star</span>
                                    <span>Prioritas</span>
                                </span>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-headline text-lg font-bold text-primary group-hover:text-primary-container transition-colors">
                                {{ $service->name }}
                            </h3>
                            <p class="text-xs sm:text-sm text-on-surface-variant mt-2 leading-relaxed line-clamp-3">
                                {{ $service->description ?? 'Pelayanan permohonan administrasi dan bantuan sosial terintegrasi Dinas Sosial Kabupaten Blitar.' }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-surface-container-high space-y-1.5 text-xs text-on-surface-variant">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-tertiary">schedule</span>
                                <span>Estimasi: {{ $service->sla_days ? $service->sla_days . ' Hari Kerja' : '1x24 Jam Kerja' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-primary">payments</span>
                                <span class="font-semibold text-tertiary">Gratis / Bebas Biaya</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-5 border-t border-surface-container-highest flex items-center gap-3">
                        <a href="{{ $applyRoute }}" class="flex-1 py-2.5 px-3 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-bold text-xs sm:text-sm rounded-xl text-center shadow-sm transition-all active:scale-95">
                            Ajukan
                        </a>
                        <a href="{{ route('layanan.detail', ['slug' => $slug]) }}" class="flex-1 py-2.5 px-3 border border-outline-variant hover:border-primary text-primary font-semibold text-xs sm:text-sm rounded-xl text-center transition-colors">
                            Persyaratan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- QUICK CALLOUT BANNER -->
    <div class="bg-surface-container-low rounded-3xl p-8 border border-surface-container-high flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-2xl">campaign</span>
            </div>
            <div>
                <h4 class="font-headline text-lg font-bold text-primary">Tidak Menemukan Layanan yang Dicari?</h4>
                <p class="text-xs sm:text-sm text-on-surface-variant">
                    Sampaikan aduan atau konsultasikan kebutuhan Anda langsung dengan petugas Dinas Sosial Kabupaten Blitar.
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3 w-full md:w-auto">
            <a href="{{ route('pengaduan') }}" class="w-full md:w-auto px-5 py-2.5 bg-primary text-on-primary font-bold text-xs sm:text-sm rounded-xl text-center hover:bg-primary-container transition-colors">
                Sampaikan Pengaduan
            </a>
            <a href="{{ route('informasi.faq') }}" class="w-full md:w-auto px-5 py-2.5 border border-outline-variant font-semibold text-xs sm:text-sm text-primary rounded-xl text-center hover:bg-surface-container transition-colors">
                Buka FAQ
            </a>
        </div>
    </div>

</div>
