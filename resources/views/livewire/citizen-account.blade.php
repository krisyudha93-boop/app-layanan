<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Area Akun Masyarakat</span>
    </nav>

    @auth
        <!-- DASHBOARD WARGA (LOGGED IN) -->
        <div class="space-y-8">
            <!-- User Header Card -->
            <div class="bg-surface-container-lowest rounded-3xl p-6 sm:p-8 border border-surface-variant shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary text-on-primary font-headline text-2xl font-bold flex items-center justify-center shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="space-y-1">
                        <span class="text-xs bg-surface-container text-primary font-bold px-2.5 py-0.5 rounded-full">
                            Akun Warga Terverifikasi
                        </span>
                        <h1 class="font-headline text-2xl font-extrabold text-primary">
                            Selamat Datang, {{ $user->name }}
                        </h1>
                        <p class="text-xs text-on-surface-variant">
                            NIK: <span class="font-mono font-bold">{{ substr($user->nik ?? '3505120000000000', 0, 4) . '******' . substr($user->nik ?? '0000', -4) }}</span> &bull; {{ $user->phone ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('layanan.index') }}" class="px-4 py-2.5 bg-primary hover:bg-primary-container text-on-primary font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">add</span>
                        <span>Ajukan Layanan Baru</span>
                    </a>
                    <button 
                        type="button" 
                        wire:click="logout" 
                        class="px-4 py-2.5 border border-outline-variant hover:border-error hover:text-error text-on-surface-variant font-bold text-xs rounded-xl transition-colors"
                    >
                        Keluar
                    </button>
                </div>
            </div>

            <!-- TABS: PENGAJUAN SAYA VS PROFIL -->
            <div class="flex border-b border-surface-variant gap-4 text-sm font-bold">
                <button 
                    type="button" 
                    wire:click="$set('tab', 'pengajuan')" 
                    class="pb-3 border-b-2 transition-colors {{ $tab === 'pengajuan' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}"
                >
                    Pengajuan Saya ({{ $myRequests->count() }})
                </button>
                <button 
                    type="button" 
                    wire:click="$set('tab', 'profil')" 
                    class="pb-3 border-b-2 transition-colors {{ $tab === 'profil' ? 'border-primary text-primary' : 'border-transparent text-outline hover:text-on-surface' }}"
                >
                    Profil Saya
                </button>
            </div>

            <!-- CONTENT: PENGAJUAN SAYA -->
            @if ($tab === 'pengajuan')
                <div class="space-y-6">
                    <!-- Filters -->
                    <div class="flex items-center gap-2 text-xs">
                        <button 
                            wire:click="$set('filterStatus', 'semua')" 
                            class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $filterStatus === 'semua' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant' }}"
                        >
                            Semua
                        </button>
                        <button 
                            wire:click="$set('filterStatus', 'proses')" 
                            class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $filterStatus === 'proses' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant' }}"
                        >
                            Dalam Proses
                        </button>
                        <button 
                            wire:click="$set('filterStatus', 'selesai')" 
                            class="px-3.5 py-1.5 rounded-full font-semibold transition-colors {{ $filterStatus === 'selesai' ? 'bg-primary text-on-primary' : 'bg-surface-container-lowest border border-outline-variant text-on-surface-variant' }}"
                        >
                            Selesai / Diterbitkan
                        </button>
                    </div>

                    <!-- List of Requests -->
                    @if ($myRequests->isEmpty())
                        <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant p-12 text-center space-y-3">
                            <span class="material-symbols-outlined text-4xl text-outline">inbox</span>
                            <h3 class="font-headline font-bold text-base text-primary">Belum Ada Pengajuan</h3>
                            <p class="text-xs text-on-surface-variant max-w-sm mx-auto">
                                Anda belum memiliki riwayat pengajuan layanan sosial. Ajukan layanan pertama Anda sekarang.
                            </p>
                            <a href="{{ route('layanan.index') }}" class="px-5 py-2.5 bg-primary text-on-primary rounded-xl font-bold text-xs inline-flex items-center gap-1.5 mt-2">
                                <span class="material-symbols-outlined text-sm">assignment_add</span>
                                <span>Pilih Layanan</span>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($myRequests as $req)
                                @php
                                    $statusVal = $req->status instanceof \BackedEnum ? $req->status->value : $req->status;
                                    $statusLabel = method_exists($req->status, 'label') ? $req->status->label() : ucfirst($statusVal);
                                    $badgeColor = match($statusVal) {
                                        'issued', 'completed' => 'bg-emerald-100 text-emerald-800',
                                        'revision_requested' => 'bg-amber-100 text-amber-800',
                                        'rejected' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-primary-fixed text-primary',
                                    };
                                @endphp
                                <div class="bg-surface-container-lowest rounded-2xl border border-surface-variant p-5 shadow-sm hover:shadow-md transition-all space-y-3 flex flex-col justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <span class="font-mono text-xs font-bold text-primary">{{ $req->request_number }}</span>
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $badgeColor }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>
                                        <h4 class="font-headline font-bold text-sm text-primary">
                                            {{ $req->serviceType?->name ?? 'Pengajuan Layanan' }}
                                        </h4>
                                        <div class="text-[11px] text-outline">
                                            Diajukan: {{ $req->submitted_at?->translatedFormat('d M Y, H:i') ?? '-' }} WIB
                                        </div>
                                    </div>

                                    <div class="pt-3 border-t border-surface-container-high flex items-center justify-between">
                                        <a href="{{ route('lacak', ['tiket' => $req->request_number]) }}" class="text-xs font-bold text-primary hover:underline inline-flex items-center gap-1">
                                            <span>Lihat Progres</span>
                                            <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                        </a>
                                        @if (in_array($statusVal, ['issued', 'completed']))
                                            <span class="text-[11px] text-emerald-700 font-semibold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                                <span>Surat Terbit</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            <!-- CONTENT: PROFIL -->
            @if ($tab === 'profil')
                <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-sm max-w-xl space-y-4 text-xs">
                    <h3 class="font-headline text-lg font-bold text-primary mb-2">Informasi Akun Warga</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-outline block mb-0.5">Nama Lengkap</span>
                            <strong class="text-sm text-on-surface">{{ $user->name }}</strong>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-outline block mb-0.5">Nomor Induk Kependudukan (NIK)</span>
                            <strong class="text-sm font-mono text-on-surface">{{ $user->nik ?? 'Belum diisi' }}</strong>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-outline block mb-0.5">Email</span>
                            <strong class="text-sm text-on-surface">{{ $user->email }}</strong>
                        </div>
                        <div class="p-3 bg-surface-container-low rounded-xl">
                            <span class="text-outline block mb-0.5">Nomor WhatsApp / HP</span>
                            <strong class="text-sm text-on-surface">{{ $user->phone ?? 'Belum diisi' }}</strong>
                        </div>
                    </div>
                </div>
            @endif

        </div>

    @else

        <!-- LOGIN / REGISTER TABS (GUEST) -->
        <div class="max-w-md mx-auto space-y-6">
            <div class="text-center space-y-2">
                <div class="w-14 h-14 rounded-2xl bg-surface-container text-primary mx-auto flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">account_circle</span>
                </div>
                <h1 class="font-headline text-2xl font-extrabold text-primary">Portal Akun Warga</h1>
                <p class="text-xs text-on-surface-variant">
                    Akun memudahkan Anda mengajukan layanan sosial dan memantau seluruh tiket dalam satu tempat.
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="bg-surface-container-lowest p-1 rounded-2xl border border-surface-variant grid grid-cols-2 text-center text-xs font-bold">
                <button 
                    type="button" 
                    wire:click="$set('tab', 'masuk')" 
                    class="py-2.5 rounded-xl transition-all {{ $tab === 'masuk' ? 'bg-primary text-on-primary shadow-sm' : 'text-outline hover:text-on-surface' }}"
                >
                    Masuk Akun
                </button>
                <button 
                    type="button" 
                    wire:click="$set('tab', 'daftar')" 
                    class="py-2.5 rounded-xl transition-all {{ $tab === 'daftar' ? 'bg-primary text-on-primary shadow-sm' : 'text-outline hover:text-on-surface' }}"
                >
                    Daftar Baru
                </button>
            </div>

            <!-- TAB 1: FORM MASUK -->
            @if ($tab === 'masuk')
                <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-xl space-y-4">
                    <form wire:submit="login" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">Email atau NIK KTP *</label>
                            <input 
                                wire:model="loginIdentifier" 
                                type="text" 
                                placeholder="nama@email.com atau 3505..." 
                                class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary"
                            />
                            @error('loginIdentifier') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">Kata Sandi *</label>
                            <input 
                                wire:model="loginPassword" 
                                type="password" 
                                placeholder="••••••••" 
                                class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary"
                            />
                            @error('loginPassword') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="remember" class="rounded text-primary h-4 w-4" />
                                <span>Ingat saya</span>
                            </label>
                            <span class="text-outline">Lupa sandi? Hubungi Dinsos</span>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl shadow-md transition-all active:scale-95"
                        >
                            Masuk Sekarang
                        </button>
                    </form>

                    <div class="pt-4 border-t border-surface-variant text-center text-xs text-on-surface-variant space-y-2">
                        <span>Belum memiliki akun?</span>
                        <div>
                            <button type="button" wire:click="$set('tab', 'daftar')" class="font-bold text-primary hover:underline">
                                Buat Akun Warga Baru
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- TAB 2: FORM DAFTAR -->
            @if ($tab === 'daftar')
                <div class="bg-surface-container-lowest rounded-3xl border border-surface-variant p-6 sm:p-8 shadow-xl space-y-4">
                    <form wire:submit="register" class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">Nama Lengkap Sesuai KTP *</label>
                            <input wire:model="regName" type="text" placeholder="Nama lengkap" class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs focus:border-primary" />
                            @error('regName') <p class="text-[10px] text-error mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">NIK (16 Digit) *</label>
                            <input wire:model="regNik" type="text" maxlength="16" placeholder="3505..." class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs font-mono focus:border-primary" />
                            @error('regNik') <p class="text-[10px] text-error mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">No. WhatsApp / HP *</label>
                            <input wire:model="regPhone" type="text" placeholder="08xxxxxxxxxx" class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs focus:border-primary" />
                            @error('regPhone') <p class="text-[10px] text-error mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-on-surface mb-1">Alamat Email *</label>
                            <input wire:model="regEmail" type="email" placeholder="nama@email.com" class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs focus:border-primary" />
                            @error('regEmail') <p class="text-[10px] text-error mt-0.5">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1">Kata Sandi *</label>
                                <input wire:model="regPassword" type="password" placeholder="Min. 8 karakter" class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs focus:border-primary" />
                                @error('regPassword') <p class="text-[10px] text-error mt-0.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1">Ulangi Sandi *</label>
                                <input wire:model="regPasswordConfirmation" type="password" placeholder="Ulangi" class="w-full h-10 px-3 rounded-xl border border-outline-variant text-xs focus:border-primary" />
                            </div>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full h-11 bg-primary hover:bg-primary-container text-on-primary font-bold text-xs rounded-xl shadow-md transition-all active:scale-95 mt-2"
                        >
                            Daftarkan Akun
                        </button>
                    </form>
                </div>
            @endif

            <!-- Direct Link Without Account -->
            <div class="text-center">
                <a href="{{ route('lacak') }}" class="text-xs text-primary font-semibold hover:underline inline-flex items-center gap-1">
                    <span>Lanjut tanpa akun &rarr; Cek Status Berkas Langsung</span>
                </a>
            </div>
        </div>

    @endauth

</div>
