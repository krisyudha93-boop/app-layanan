<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if ($isSubmitted)
        <!-- SUCCESS STATE -->
        <div class="max-w-3xl mx-auto bg-surface-container-lowest rounded-3xl border border-surface-variant p-8 sm:p-12 shadow-xl text-center space-y-6">
            <div class="w-20 h-20 rounded-full bg-tertiary/10 text-tertiary mx-auto flex items-center justify-center ring-8 ring-tertiary/5">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-tertiary bg-tertiary/10 px-3 py-1 rounded-full uppercase tracking-wider">
                    Pengajuan Berhasil Dikirimkan
                </span>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                    Terima Kasih, Berkas Anda Sedang Diproses
                </h1>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-lg mx-auto leading-relaxed">
                    Permohonan Surat Keterangan DTSEN Anda telah terdaftar di sistem SAPA SOSIAL Dinas Sosial Kabupaten Blitar.
                </p>
            </div>

            <!-- TICKET BADGE -->
            <div class="bg-surface-container-low p-6 rounded-2xl border-2 border-dashed border-primary/30 max-w-md mx-auto space-y-3">
                <span class="text-xs text-outline font-semibold uppercase tracking-wider">Nomor Registrasi / Tiket Pelayanan</span>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold text-primary tracking-wider" id="ticket-badge">
                    {{ $submittedTicket }}
                </div>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <button 
                        type="button" 
                        onclick="navigator.clipboard.writeText('{{ $submittedTicket }}'); alert('Nomor tiket berhasil disalin ke papan klip!');"
                        class="px-4 py-1.5 bg-surface-container text-primary hover:bg-surface-container-high rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                        <span>Salin Nomor Tiket</span>
                    </button>
                </div>
            </div>

            <!-- NEXT STEPS PREVIEW -->
            <div class="text-left bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 max-w-lg mx-auto space-y-4">
                <h4 class="font-headline font-bold text-sm text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-base">checklist</span>
                    <span>Tahapan Selanjutnya:</span>
                </h4>
                <div class="space-y-3 text-xs text-on-surface-variant">
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">1</span>
                        <div><strong>Pemeriksaan Berkas:</strong> Verifikator memeriksa keabsahan foto KTP &amp; KK (maksimal 1x24 jam kerja).</div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">2</span>
                        <div><strong>Validasi SIKS-NG:</strong> Petugas mengecek data desil pemohon di basis data DTKS nasional.</div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">3</span>
                        <div><strong>Penerbitan Surat Resmi:</strong> Surat ber-TTE terbit dan langsung siap diunduh melalui fitur Cek Status Tiket.</div>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
                <a href="{{ route('lacak', ['tiket' => $submittedTicket]) }}" class="w-full sm:w-auto px-6 py-3.5 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl shadow-md transition-all">
                    Lacak Status Pengajuan
                </a>
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3.5 border border-outline-variant hover:border-primary text-primary font-bold text-sm rounded-xl transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    @else

        <!-- FORM WIZARD VIEW -->
        <div class="space-y-8">
            <!-- BREADCRUMB & HEADER -->
            <section class="space-y-4">
                <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-outline-variant">/</span>
                    <a href="{{ route('layanan.index') }}" class="hover:text-primary transition-colors">Layanan</a>
                    <span class="text-outline-variant">/</span>
                    <span class="text-primary font-semibold">Pengajuan Surat Keterangan DTSEN</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-surface-variant pb-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high text-primary rounded-full text-xs font-semibold mb-2">
                            <span class="material-symbols-outlined text-xs">verified_user</span>
                            <span>Layanan Pengajuan Mandiri</span>
                        </div>
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">
                            Formulir Pengajuan Surat Keterangan DTSEN
                        </h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1 max-w-3xl">
                            Isi formulir secara lengkap dengan data NIK &amp; KK yang valid untuk penerbitan surat keterangan terdaftar Data Terpadu Kesejahteraan Sosial (DTKS/DTSEN).
                        </p>
                    </div>

                    <div class="flex items-center gap-3 bg-surface-container-lowest p-3 rounded-2xl border border-outline-variant shadow-sm shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-outline font-semibold">Standar Pelayanan</div>
                            <div class="font-headline text-sm font-bold text-primary">1x24 Jam Kerja</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STEP PROGRESS TRACKER (4 STEPS WIZARD) -->
            <section class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Step 1 -->
                    <button 
                        type="button" 
                        wire:click="goToStep(1)" 
                        class="flex items-center gap-3 text-left focus:outline-none"
                    >
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 1 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 1 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 1)
                                <span class="material-symbols-outlined text-sm">check</span>
                            @else
                                1
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 1 ? 'text-primary' : ($currentStep > 1 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 1</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 1 ? 'text-primary' : 'text-on-surface' }}">Tujuan Surat</span>
                        </div>
                    </button>

                    <!-- Step 2 -->
                    <button 
                        type="button" 
                        wire:click="goToStep(2)" 
                        class="flex items-center gap-3 text-left focus:outline-none"
                    >
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 2 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 2 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 2)
                                <span class="material-symbols-outlined text-sm">check</span>
                            @else
                                2
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 2 ? 'text-primary' : ($currentStep > 2 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 2</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 2 ? 'text-primary' : 'text-on-surface' }}">Data Pemohon</span>
                        </div>
                    </button>

                    <!-- Step 3 -->
                    <button 
                        type="button" 
                        wire:click="goToStep(3)" 
                        class="flex items-center gap-3 text-left focus:outline-none"
                    >
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 3 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 3 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 3)
                                <span class="material-symbols-outlined text-sm">check</span>
                            @else
                                3
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 3 ? 'text-primary' : ($currentStep > 3 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 3</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 3 ? 'text-primary' : 'text-on-surface' }}">Unggah Berkas</span>
                        </div>
                    </button>

                    <!-- Step 4 -->
                    <button 
                        type="button" 
                        wire:click="goToStep(4)" 
                        class="flex items-center gap-3 text-left focus:outline-none"
                    >
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep === 4 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline' }}">
                            4
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 4 ? 'text-primary' : 'text-outline' }}">LANGKAH 4</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 4 ? 'text-primary' : 'text-on-surface' }}">Tinjau &amp; Kirim</span>
                        </div>
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-surface-variant h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full rounded-full transition-all duration-300" style="width: {{ $currentStep * 25 }}%;"></div>
                </div>
            </section>

            <!-- WIZARD STEP BODIES -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Main Form (8 Cols) -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- STEP 1: TUJUAN PENGGUNAAN -->
                    @if ($currentStep === 1)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="flex items-center justify-between border-b border-surface-variant pb-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary font-bold">1</span>
                                    <div>
                                        <h2 class="font-headline text-lg font-bold text-primary">Tujuan Penggunaan Surat</h2>
                                        <p class="text-xs text-on-surface-variant">Pilih alasan spesifik pengajuan surat keterangan DTSEN.</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-surface-container text-primary rounded-lg text-xs font-semibold">Wajib Pilih</span>
                            </div>

                            @error('dtsen_purpose_id')
                                <div class="p-3 bg-error/10 text-error rounded-xl text-xs">{{ $message }}</div>
                            @enderror

                            <!-- Radio cards bento -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($purposes as $p)
                                    <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $dtsen_purpose_id == $p->id ? 'border-primary bg-surface-container-low shadow-sm' : 'border-outline-variant hover:border-primary/50' }}">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $dtsen_purpose_id == $p->id ? 'bg-primary text-on-primary' : 'bg-surface-container text-primary' }}">
                                                <span class="material-symbols-outlined">
                                                    @if (str_contains(strtolower($p->name), 'spmb')) school
                                                    @elseif (str_contains(strtolower($p->name), 'kip') || str_contains(strtolower($p->name), 'kuliah')) account_balance
                                                    @elseif (str_contains(strtolower($p->name), 'pip')) menu_book
                                                    @elseif (str_contains(strtolower($p->name), 'bansos')) handshake
                                                    @elseif (str_contains(strtolower($p->name), 'kesehatan')) health_and_safety
                                                    @else description
                                                    @endif
                                                </span>
                                            </div>
                                            <input 
                                                type="radio" 
                                                wire:model.live="dtsen_purpose_id" 
                                                value="{{ $p->id }}" 
                                                class="h-5 w-5 text-primary focus:ring-primary border-outline-variant"
                                            />
                                        </div>
                                        <span class="font-headline font-bold text-sm text-primary">{{ $p->name }}</span>
                                        <span class="text-xs text-on-surface-variant mt-1">Batas Maksimal: Desil {{ $p->max_decile ?? 5 }} (DTKS)</span>
                                        @if ($dtsen_purpose_id == $p->id)
                                            <div class="mt-3 pt-2 border-t border-primary/20 flex items-center gap-1 text-[11px] text-tertiary font-semibold">
                                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                                <span>Pilihan aktif</span>
                                            </div>
                                        @endif
                                    </label>
                                @endforeach
                            </div>

                            @if ($selectedPurpose && str_contains(strtolower($selectedPurpose->name), 'lain'))
                                <div class="pt-2">
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Jelaskan Keterangan Tujuan Lainnya</label>
                                    <textarea 
                                        wire:model="purpose_description" 
                                        rows="2" 
                                        placeholder="Contoh: Pengajuan beasiswa swasta yayasan X..."
                                        class="w-full p-3 rounded-xl border border-outline-variant bg-surface-container-lowest text-xs text-on-surface focus:ring-primary focus:border-primary"
                                    ></textarea>
                                </div>
                            @endif

                            <div class="pt-4 flex justify-end">
                                <button 
                                    type="button" 
                                    wire:click="nextStep" 
                                    class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2 shadow-sm transition-all"
                                >
                                    <span>Lanjut ke Data Pemohon</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: DATA PEMOHON & DATA YANG DITERANGKAN -->
                    @if ($currentStep === 2)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Data Pemohon &amp; Penerima Surat</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Identitas pemohon harus sesuai dengan dokumen KTP dan Kartu Keluarga.</p>
                            </div>

                            <!-- Section A: Data Pemohon -->
                            <div class="space-y-4">
                                <span class="text-xs font-bold text-primary uppercase tracking-wider block">A. Identitas Pemohon (Kepala Keluarga / Pengaju)</span>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Nama Lengkap Pemohon *</label>
                                        <input wire:model="applicant_name" type="text" placeholder="Sesuai KTP" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                        @error('applicant_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">NIK Pemohon (16 Digit) *</label>
                                        <input wire:model="applicant_nik" type="text" maxlength="16" placeholder="3505..." class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                        @error('applicant_nik') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Nomor Kartu Keluarga (16 Digit) *</label>
                                        <input wire:model="family_card_number" type="text" maxlength="16" placeholder="3505..." class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                        @error('family_card_number') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Alamat Lengkap (RT/RW, Dusun, Jalan) *</label>
                                        <input wire:model="address" type="text" placeholder="Contoh: RT 02 RW 01, Dusun Krajan" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                        @error('address') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Kecamatan *</label>
                                        <select wire:model.live="district_id" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary">
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @foreach ($districts as $d)
                                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('district_id') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Desa / Kelurahan *</label>
                                        <select wire:model="village_id" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" {{ empty($district_id) ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Desa / Kelurahan --</option>
                                            @foreach ($villages as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('village_id') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Nomor WhatsApp / HP Aktif *</label>
                                        <input wire:model="phone" type="text" placeholder="08xxxxxxxxxx" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                        <span class="text-[11px] text-outline">Nomor ini digunakan untuk verifikasi dan konfirmasi penerbitan surat.</span>
                                        @error('phone') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section B: Data Orang yang Diterangkan -->
                            <div class="space-y-4 pt-6 border-t border-surface-variant">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-primary uppercase tracking-wider">B. Data Orang yang Diterangkan (Siswa / Mahasiswa / Klien)</span>
                                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-primary">
                                        <input wire:model.live="is_same_as_applicant" type="checkbox" class="rounded text-primary focus:ring-primary h-4 w-4" />
                                        <span>Sama dengan Pemohon</span>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Nama yang Diterangkan *</label>
                                        <input wire:model="subject_name" type="text" placeholder="Nama calon siswa/mahasiswa" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                        @error('subject_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-on-surface mb-1">NIK yang Diterangkan (16 Digit) *</label>
                                        <input wire:model="subject_nik" type="text" maxlength="16" placeholder="3505..." class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                        @error('subject_nik') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-semibold text-on-surface mb-1">Hubungan dengan Pemohon *</label>
                                        <select wire:model="relationship_to_applicant" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary">
                                            <option value="Diri Sendiri">Diri Sendiri</option>
                                            <option value="Anak Kandung">Anak Kandung</option>
                                            <option value="Suami / Istri">Suami / Istri</option>
                                            <option value="Orang Tua">Orang Tua</option>
                                            <option value="Saudara Kandung">Saudara Kandung</option>
                                            <option value="Lainnya">Lainnya / Perwalian</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="button" wire:click="prevStep" class="px-5 py-2.5 border border-outline-variant hover:border-primary text-primary font-semibold text-xs rounded-xl">
                                    Kembali
                                </button>
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Lanjut ke Unggah Berkas</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 3: UNGGAH BERKAS -->
                    @if ($currentStep === 3)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Unggah Dokumen Persyaratan</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Unggah foto atau scan dokumen asli yang jelas dan dapat dibaca.</p>
                            </div>

                            <!-- Upload KTP -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-on-surface">1. Foto / Scan KTP Asli Pemohon *</label>
                                <div class="border-2 border-dashed border-outline-variant hover:border-primary rounded-2xl p-6 text-center bg-surface-container-low transition-colors">
                                    <input type="file" wire:model="ktp_file" id="ktp_file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                    <label for="ktp_file" class="cursor-pointer flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                                        </div>
                                        <div class="text-xs text-on-surface">
                                            <span class="font-bold text-primary hover:underline">Klik untuk memilih berkas KTP</span> atau tarik ke sini
                                        </div>
                                        <span class="text-[11px] text-outline">Format: JPG, PNG, atau PDF (Maks. 5 MB)</span>
                                    </label>
                                </div>
                                <div wire:loading wire:target="ktp_file" class="text-xs text-primary font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm animate-spin">refresh</span>
                                    <span>Mengunggah KTP...</span>
                                </div>
                                @if ($ktp_file)
                                    <div class="p-3 bg-tertiary/10 border border-tertiary/30 rounded-xl text-xs flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-tertiary">
                                            <span class="material-symbols-outlined text-base">check_circle</span>
                                            <span>KTP Terpilih: <strong>{{ $ktp_file->getClientOriginalName() }}</strong></span>
                                        </div>
                                        <button type="button" wire:click="$set('ktp_file', null)" class="text-error font-semibold hover:underline">Hapus</button>
                                    </div>
                                @endif
                                @error('ktp_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                            </div>

                            <!-- Upload KK -->
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-on-surface">2. Foto / Scan Kartu Keluarga (KK) Asli *</label>
                                <div class="border-2 border-dashed border-outline-variant hover:border-primary rounded-2xl p-6 text-center bg-surface-container-low transition-colors">
                                    <input type="file" wire:model="kk_file" id="kk_file" class="hidden" accept=".jpg,.jpeg,.png,.pdf" />
                                    <label for="kk_file" class="cursor-pointer flex flex-col items-center justify-center space-y-2">
                                        <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined text-2xl">cloud_upload</span>
                                        </div>
                                        <div class="text-xs text-on-surface">
                                            <span class="font-bold text-primary hover:underline">Klik untuk memilih berkas KK</span> atau tarik ke sini
                                        </div>
                                        <span class="text-[11px] text-outline">Format: JPG, PNG, atau PDF (Maks. 5 MB)</span>
                                    </label>
                                </div>
                                <div wire:loading wire:target="kk_file" class="text-xs text-primary font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm animate-spin">refresh</span>
                                    <span>Mengunggah KK...</span>
                                </div>
                                @if ($kk_file)
                                    <div class="p-3 bg-tertiary/10 border border-tertiary/30 rounded-xl text-xs flex items-center justify-between">
                                        <div class="flex items-center gap-2 text-tertiary">
                                            <span class="material-symbols-outlined text-base">check_circle</span>
                                            <span>KK Terpilih: <strong>{{ $kk_file->getClientOriginalName() }}</strong></span>
                                        </div>
                                        <button type="button" wire:click="$set('kk_file', null)" class="text-error font-semibold hover:underline">Hapus</button>
                                    </div>
                                @endif
                                @error('kk_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="button" wire:click="prevStep" class="px-5 py-2.5 border border-outline-variant hover:border-primary text-primary font-semibold text-xs rounded-xl">
                                    Kembali
                                </button>
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Tinjau Pengajuan</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4: TINJAU & KIRIM -->
                    @if ($currentStep === 4)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Tinjau Ringkasan Pengajuan</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Periksa kembali kebenaran seluruh data sebelum mengirimkan ke verifikator Dinas Sosial.</p>
                            </div>

                            <!-- Summary 1: Tujuan -->
                            <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-primary uppercase">1. Tujuan Penggunaan Surat</span>
                                    <button type="button" wire:click="goToStep(1)" class="text-xs text-primary font-bold hover:underline">Ubah</button>
                                </div>
                                <div class="font-headline font-bold text-sm text-primary">{{ $selectedPurpose?->name ?? 'Tujuan Belum Dipilih' }}</div>
                                @if ($purpose_description)
                                    <div class="text-xs text-on-surface-variant italic">Keterangan: {{ $purpose_description }}</div>
                                @endif
                            </div>

                            <!-- Summary 2: Data Pemohon -->
                            <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant space-y-2 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-primary uppercase">2. Identitas Pemohon &amp; Penerima</span>
                                    <button type="button" wire:click="goToStep(2)" class="text-primary font-bold hover:underline">Ubah</button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-on-surface-variant pt-1">
                                    <div><span class="text-outline">Nama Pemohon:</span> <strong class="text-on-surface block">{{ $applicant_name }}</strong></div>
                                    <div><span class="text-outline">NIK Pemohon:</span> <strong class="text-on-surface block font-mono">{{ $applicant_nik }}</strong></div>
                                    <div><span class="text-outline">Nomor KK:</span> <strong class="text-on-surface block font-mono">{{ $family_card_number }}</strong></div>
                                    <div><span class="text-outline">No. WhatsApp:</span> <strong class="text-on-surface block">{{ $phone }}</strong></div>
                                    <div class="col-span-2"><span class="text-outline">Domisili:</span> <strong class="text-on-surface block">{{ $address }}, Ds. {{ $selectedVillage?->name }}, Kec. {{ $selectedDistrict?->name }}</strong></div>
                                    <div class="col-span-2 pt-2 border-t border-surface-container-high">
                                        <span class="text-outline">Orang yang Diterangkan:</span>
                                        <strong class="text-primary block">{{ $subject_name }} (NIK: {{ $subject_nik }}) — Hubungan: {{ $relationship_to_applicant }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary 3: Berkas -->
                            <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant space-y-2 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-primary uppercase">3. Dokumen Lampiran</span>
                                    <button type="button" wire:click="goToStep(3)" class="text-primary font-bold hover:underline">Ubah</button>
                                </div>
                                <div class="space-y-1 text-on-surface-variant pt-1">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                        <span>KTP: {{ $ktp_file ? $ktp_file->getClientOriginalName() : 'Belum diunggah' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                        <span>KK: {{ $kk_file ? $kk_file->getClientOriginalName() : 'Belum diunggah' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Consent Statement -->
                            <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-3">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="agreement" class="rounded text-primary focus:ring-primary h-5 w-5 mt-0.5" />
                                    <span class="text-xs text-on-surface leading-relaxed">
                                        Saya menyatakan dengan sadar dan sesungguhnya bahwa seluruh data yang diisi serta dokumen yang diunggah adalah <strong>benar dan sah</strong>. Apabila di kemudian hari ditemukan ketidakbenaran data, saya bersedia menerima sanksi sesuai ketentuan peraturan perundang-undangan.
                                    </span>
                                </label>
                                @error('agreement') <p class="text-xs text-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="button" wire:click="prevStep" class="px-5 py-2.5 border border-outline-variant hover:border-primary text-primary font-semibold text-xs rounded-xl">
                                    Kembali
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="submit" 
                                    wire:loading.attr="disabled"
                                    class="px-8 py-3.5 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl flex items-center gap-2 shadow-lg transition-all active:scale-95"
                                >
                                    <span wire:loading.remove wire:target="submit">Kirim Pengajuan Sekarang</span>
                                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base animate-spin">refresh</span>
                                        <span>Memproses...</span>
                                    </span>
                                    <span class="material-symbols-outlined text-base" wire:loading.remove wire:target="submit">send</span>
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Sidebar Guidelines (4 Cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-high space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">lightbulb</span>
                        </div>
                        <h4 class="font-headline font-bold text-sm text-primary">Panduan Pengisian:</h4>
                        <ul class="space-y-2.5 text-xs text-on-surface-variant leading-relaxed">
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5">verified</span>
                                <span>Pastikan NIK dan No. KK sudah sesuai dengan dokumen resmi kependudukan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5">verified</span>
                                <span>Foto dokumen tidak blur, tidak silau, dan seluruh 4 sudut kartu terlihat jelas.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-primary text-base shrink-0 mt-0.5">verified</span>
                                <span>Setelah pengajuan dikirim, simpan <strong>Nomor Tiket</strong> untuk memantau status berkas Anda.</span>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant text-xs space-y-3">
                        <div class="font-bold text-primary flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-secondary">security</span>
                            <span>Kerahasiaan Data Terjamin</span>
                        </div>
                        <p class="text-on-surface-variant leading-relaxed">
                            Data pribadi dan dokumen Anda disimpan pada basis data berkeamanan tinggi dan hanya dapat diakses oleh petugas verifikasi Dinas Sosial Kabupaten Blitar.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    @endif

</div>
