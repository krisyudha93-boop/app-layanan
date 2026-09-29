<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar. Ajukan Surat Keterangan DTSEN, Reaktivasi KIS/PBI-JK, Layanan Rehabilitasi Sosial, Pengaduan, dan lacak status secara online.">
    <meta name="keywords" content="SAPA SOSIAL, Dinas Sosial Kabupaten Blitar, DTSEN, DTKS, KIS, PBI-JK, Rehabilitasi Sosial, Pengaduan Sosial Blitar">
    <meta name="author" content="Dinas Sosial Kabupaten Blitar">

    <title>{{ $title ?? 'SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar' }}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CDN fallback with configuration for instant rich rendering -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00445c",
                        "primary-container": "#0f5c7a",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#95d3f5",
                        "primary-fixed": "#c2e8ff",
                        "primary-fixed-dim": "#90cef1",
                        "on-primary-fixed": "#001e2c",
                        "on-primary-fixed-variant": "#004d68",
                        "inverse-primary": "#90cef1",

                        "secondary": "#835500",
                        "secondary-container": "#feae2c",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#6b4500",
                        "secondary-fixed": "#ffddb4",
                        "secondary-fixed-dim": "#ffb955",
                        "on-secondary-fixed": "#291800",
                        "on-secondary-fixed-variant": "#633f00",

                        "tertiary": "#004927",
                        "tertiary-container": "#006337",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#83dea2",
                        "tertiary-fixed": "#9af6b8",
                        "tertiary-fixed-dim": "#7ed99e",

                        "background": "#f1fbff",
                        "on-background": "#0a1e24",

                        "surface": "#f1fbff",
                        "on-surface": "#0a1e24",
                        "surface-dim": "#c8dee6",
                        "surface-bright": "#f1fbff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#e2f7ff",
                        "surface-container": "#dcf1fa",
                        "surface-container-high": "#d6ecf4",
                        "surface-container-highest": "#d1e6ee",
                        "on-surface-variant": "#40484d",
                        "surface-variant": "#d1e6ee",
                        "surface-tint": "#1f6583",

                        "inverse-surface": "#203339",
                        "inverse-on-surface": "#dff4fc",

                        "outline": "#70787e",
                        "outline-variant": "#c0c7ce",

                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a"
                    },
                    fontFamily: {
                        display: ["Plus Jakarta Sans", "sans-serif"],
                        headline: ["Plus Jakarta Sans", "sans-serif"],
                        body: ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-background text-on-surface font-body antialiased min-h-screen flex flex-col selection:bg-primary selection:text-on-primary" x-data="{ mobileMenuOpen: false }">

    <!-- TOP NAV BAR -->
    <header class="bg-surface-container-lowest/95 backdrop-blur border-b border-outline-variant/60 sticky top-0 z-50 shadow-sm transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center gap-4">
            
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group focus:outline-none">
                <div class="w-11 h-11 rounded-xl bg-primary flex items-center justify-center text-on-primary shadow-sm group-hover:bg-primary-container transition-colors">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">diversity_3</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-headline text-xl sm:text-2xl font-bold text-primary tracking-tight leading-tight">SAPA SOSIAL</span>
                        <span class="hidden sm:inline-block bg-primary-container text-on-primary text-[10px] font-bold px-2 py-0.5 rounded-full tracking-wider">KAB. BLITAR</span>
                    </div>
                    <span class="text-xs text-on-surface-variant font-medium">Dinas Sosial Kabupaten Blitar</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 font-medium text-sm">
                <a href="{{ route('home') }}" class="transition-colors pb-1 {{ request()->routeIs('home') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Beranda
                </a>
                <a href="{{ route('layanan.index') }}" class="transition-colors pb-1 {{ request()->routeIs('layanan.*') || request()->routeIs('pengajuan.*') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Layanan
                </a>
                <a href="{{ route('pengaduan') }}" class="transition-colors pb-1 {{ request()->routeIs('pengaduan') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Pengaduan
                </a>
                <a href="{{ route('rehabilitasi') }}" class="transition-colors pb-1 {{ request()->routeIs('rehabilitasi') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Rehabilitasi Sosial
                </a>
                <a href="{{ route('lacak') }}" class="transition-colors pb-1 {{ request()->routeIs('lacak') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Cek Status
                </a>
                <a href="{{ route('informasi.faq') }}" class="transition-colors pb-1 {{ request()->routeIs('informasi.faq') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary' }}">
                    Informasi & FAQ
                </a>
            </nav>

            <!-- Actions Cluster -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('surat.verifikasi') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface-container text-primary hover:bg-surface-container-high transition-colors" title="Verifikasi Keaslian Surat Keterangan">
                    <span class="material-symbols-outlined text-base">verified</span>
                    <span>Verifikasi SK</span>
                </a>

                @auth
                    <a href="{{ url('/admin') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-primary text-on-primary rounded-xl font-semibold text-xs sm:text-sm hover:bg-primary-container shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-sm">dashboard</span>
                        <span>Panel Petugas</span>
                    </a>
                @else
                    <a href="{{ route('akun') }}" class="px-3 sm:px-4 py-2 text-primary font-semibold text-xs sm:text-sm hover:bg-surface-container rounded-xl transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('akun') }}?tab=daftar" class="inline-flex items-center gap-1 px-3 sm:px-4 py-2 bg-primary text-on-primary rounded-xl font-semibold text-xs sm:text-sm hover:bg-primary-container shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        <span>Daftar</span>
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button 
                    type="button" 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden p-2 rounded-xl text-on-surface hover:bg-surface-container focus:outline-none"
                    aria-label="Menu Utama"
                >
                    <span class="material-symbols-outlined text-2xl" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="lg:hidden border-t border-outline-variant bg-surface-container-lowest px-4 pt-3 pb-6 shadow-xl space-y-2"
            style="display: none;"
        >
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('home') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">home</span>
                Beranda
            </a>
            <a href="{{ route('layanan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('layanan.*') || request()->routeIs('pengajuan.*') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">apps</span>
                Layanan Sosial
            </a>
            <a href="{{ route('pengaduan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('pengaduan') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">campaign</span>
                Pengaduan Sosial
            </a>
            <a href="{{ route('rehabilitasi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('rehabilitasi') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">healing</span>
                Rehabilitasi Sosial
            </a>
            <a href="{{ route('lacak') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('lacak') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">search_check</span>
                Cek Status Tiket
            </a>
            <a href="{{ route('informasi.faq') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm {{ request()->routeIs('informasi.faq') ? 'bg-primary text-on-primary' : 'text-on-surface hover:bg-surface-container' }}">
                <span class="material-symbols-outlined text-xl">help_outline</span>
                Informasi & FAQ
            </a>
            <a href="{{ route('surat.verifikasi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm text-primary hover:bg-surface-container">
                <span class="material-symbols-outlined text-xl">verified</span>
                Verifikasi Keaslian Surat
            </a>
            <div class="pt-3 border-t border-outline-variant flex gap-2">
                <a href="{{ route('akun') }}" class="flex-1 text-center py-2.5 border border-outline-variant rounded-xl font-semibold text-sm text-primary hover:bg-surface-container">
                    Masuk Akun
                </a>
                <a href="{{ url('/admin') }}" class="flex-1 text-center py-2.5 bg-primary-container text-on-primary rounded-xl font-semibold text-sm hover:bg-primary">
                    Panel Petugas
                </a>
            </div>
        </div>
    </header>

    <!-- FLASH MESSAGES -->
    @if (session()->has('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-tertiary/10 border border-tertiary/30 text-tertiary-container rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-2xl text-tertiary">check_circle</span>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-tertiary hover:opacity-75">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="bg-error/10 border border-error/30 text-error rounded-xl p-4 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-2xl text-error">error</span>
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-error hover:opacity-75">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    <!-- MAIN SLOT -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- CIVIC FOOTER -->
    <footer class="bg-inverse-surface text-inverse-on-surface mt-20 pt-16 pb-10 border-t border-inverse-surface/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-outline/30">
                
                <!-- Col 1: Instansi & Deskripsi -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center text-on-primary">
                            <span class="material-symbols-outlined text-2xl">diversity_3</span>
                        </div>
                        <div>
                            <div class="font-headline font-bold text-xl text-white">SAPA SOSIAL</div>
                            <div class="text-xs text-outline-variant font-medium">Kabupaten Blitar</div>
                        </div>
                    </div>
                    <p class="text-sm text-outline-variant leading-relaxed max-w-sm">
                        Satu Pintu Layanan Sosial Terpadu Dinas Sosial Kabupaten Blitar. Menjamin transparansi, kecepatan pelayanan, dan kemudahan akses bagi seluruh lapisan masyarakat.
                    </p>
                    <div class="pt-2 flex items-center gap-3 text-xs text-secondary-fixed">
                        <span class="material-symbols-outlined text-base">security</span>
                        <span>Data pribadi dilindungi Undang-Undang &amp; dienkripsi.</span>
                    </div>
                </div>

                <!-- Col 2: Layanan Utama -->
                <div class="space-y-3">
                    <div class="font-headline font-bold text-white text-sm tracking-wider uppercase">Layanan Utama</div>
                    <ul class="space-y-2 text-sm text-outline-variant">
                        <li><a href="{{ route('pengajuan.dtsen') }}" class="hover:text-white transition-colors">Surat Keterangan DTSEN</a></li>
                        <li><a href="{{ route('pengajuan.pbi') }}" class="hover:text-white transition-colors">Reaktivasi KIS / PBI-JK</a></li>
                        <li><a href="{{ route('rehabilitasi') }}" class="hover:text-white transition-colors">Rehabilitasi Sosial</a></li>
                        <li><a href="{{ route('pengajuan.lainnya') }}" class="hover:text-white transition-colors">Layanan Sosial Lainnya</a></li>
                        <li><a href="{{ route('pengaduan') }}" class="hover:text-white transition-colors">Pengaduan Sosial</a></li>
                    </ul>
                </div>

                <!-- Col 3: Akses Cepat -->
                <div class="space-y-3">
                    <div class="font-headline font-bold text-white text-sm tracking-wider uppercase">Akses Mandiri</div>
                    <ul class="space-y-2 text-sm text-outline-variant">
                        <li><a href="{{ route('lacak') }}" class="hover:text-white transition-colors">Lacak Status Tiket</a></li>
                        <li><a href="{{ route('surat.verifikasi') }}" class="hover:text-white transition-colors">Verifikasi Keaslian SK</a></li>
                        <li><a href="{{ route('informasi.faq') }}" class="hover:text-white transition-colors">Unduh Formulir &amp; FAQ</a></li>
                        <li><a href="{{ route('akun') }}" class="hover:text-white transition-colors">Portal Akun Warga</a></li>
                        <li><a href="{{ url('/admin') }}" class="hover:text-white transition-colors">Portal Petugas &amp; Operator</a></li>
                    </ul>
                </div>

                <!-- Col 4: Kontak & Lokasi -->
                <div class="space-y-3">
                    <div class="font-headline font-bold text-white text-sm tracking-wider uppercase">Kontak &amp; Kantor</div>
                    <div class="space-y-2 text-sm text-outline-variant">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base text-primary-fixed mt-0.5">location_on</span>
                            <span>Jl. Merdeka No. 45, Kepanjenkidul, Blitar, Jawa Timur 66117</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-primary-fixed">schedule</span>
                            <span>Senin – Jumat: 08.00 – 15.30 WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-primary-fixed">call</span>
                            <span>(0342) 801-xxx / WA Dinsos</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-primary-fixed">mail</span>
                            <span>dinsos@blitarkab.go.id</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Row -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-outline-variant">
                <div>
                    &copy; 2026 Pemerintah Kabupaten Blitar — Dinas Sosial. Seluruh Hak Cipta Dilindungi.
                </div>
                <div class="flex items-center gap-6">
                    <span class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sistem Beroperasi Normal
                    </span>
                    <span>Versi 1.0 (Livewire v4)</span>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
