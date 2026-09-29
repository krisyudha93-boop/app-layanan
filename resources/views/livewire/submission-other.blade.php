<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if ($isSubmitted)
        <!-- SUCCESS STATE -->
        <div class="max-w-3xl mx-auto bg-surface-container-lowest rounded-3xl border border-surface-variant p-8 sm:p-12 shadow-xl text-center space-y-6">
            <div class="w-20 h-20 rounded-full bg-tertiary/10 text-tertiary mx-auto flex items-center justify-center ring-8 ring-tertiary/5">
                <span class="material-symbols-outlined text-4xl">check_circle</span>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-tertiary bg-tertiary/10 px-3 py-1 rounded-full uppercase tracking-wider">
                    Pengajuan Berhasil Dikirimkan
                </span>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                    Permohonan Layanan Sosial Diterima
                </h1>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-lg mx-auto leading-relaxed">
                    Berkas pengajuan Anda telah tercatat pada sistem. Silakan simpan nomor tiket untuk melacak perkembangan status berkas.
                </p>
            </div>

            <div class="bg-surface-container-low p-6 rounded-2xl border-2 border-dashed border-primary/30 max-w-md mx-auto space-y-3">
                <span class="text-xs text-outline font-semibold uppercase tracking-wider">Nomor Registrasi / Tiket</span>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold text-primary tracking-wider">
                    {{ $submittedTicket }}
                </div>
                <button 
                    type="button" 
                    onclick="navigator.clipboard.writeText('{{ $submittedTicket }}'); alert('Nomor tiket berhasil disalin!');"
                    class="px-4 py-1.5 bg-surface-container text-primary hover:bg-surface-container-high rounded-lg text-xs font-bold inline-flex items-center gap-1.5 transition-colors"
                >
                    <span class="material-symbols-outlined text-sm">content_copy</span>
                    <span>Salin Nomor Tiket</span>
                </button>
            </div>

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
                    <span class="text-primary font-semibold">Pengajuan Layanan Sosial Lainnya</span>
                </nav>

                <div class="border-b border-surface-variant pb-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-primary rounded-full text-xs font-semibold mb-2">
                        <span class="material-symbols-outlined text-xs">folder_shared</span>
                        <span>Formulir Terstandar Dinas Sosial</span>
                    </div>
                    <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">
                        Formulir Pengajuan Layanan Sosial Lainnya
                    </h1>
                    <p class="text-xs sm:text-sm text-on-surface-variant mt-1 max-w-3xl">
                        Pilih jenis layanan sosial yang ingin diajukan. Sistem secara otomatis menampilkan persyaratan dokumen yang relevan.
                    </p>
                </div>
            </section>

            <!-- FORM GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                    
                    <!-- 1. PILIH JENIS LAYANAN -->
                    <div class="space-y-3 border-b border-surface-variant pb-6">
                        <label class="block text-xs font-bold text-primary uppercase">1. Pilih Jenis Layanan Sosial *</label>
                        <select wire:model.live="service_type_id" class="w-full h-12 px-3.5 rounded-xl border border-outline-variant text-sm font-semibold focus:border-primary">
                            @foreach ($services as $srv)
                                <option value="{{ $srv->id }}">{{ $srv->name }} ({{ $srv->category ?? 'Sosial' }})</option>
                            @endforeach
                        </select>
                        @if ($selectedService)
                            <div class="p-3 bg-surface-container-low rounded-xl text-xs text-on-surface-variant leading-relaxed">
                                {{ $selectedService->description }}
                            </div>
                        @endif
                    </div>

                    <!-- 2. DATA IDENTITAS PEMOHON -->
                    <div class="space-y-4 border-b border-surface-variant pb-6">
                        <span class="text-xs font-bold text-primary uppercase block">2. Identitas Pemohon</span>

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
                                <label class="block text-xs font-semibold text-on-surface mb-1">Alamat Lengkap *</label>
                                <input wire:model="address" type="text" placeholder="RT/RW, Dusun, Jalan" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
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
                                <label class="block text-xs font-semibold text-on-surface mb-1">No. WhatsApp / HP Aktif *</label>
                                <input wire:model="phone" type="text" placeholder="08xxxxxxxxxx" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                @error('phone') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 3. UNGGAH PERSYARATAN DINAMIS -->
                    <div class="space-y-4 border-b border-surface-variant pb-6">
                        <span class="text-xs font-bold text-primary uppercase block">3. Dokumen Persyaratan Layanan</span>

                        @if ($requirements->isNotEmpty())
                            <div class="space-y-4">
                                @foreach ($requirements as $req)
                                    <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label class="text-xs font-bold text-primary">
                                                {{ $req->name }} {{ $req->is_mandatory ? '*' : '(Opsional)' }}
                                            </label>
                                            <span class="text-[10px] text-outline font-mono">{{ $req->allowed_mimes ?? 'pdf,jpg,png' }}</span>
                                        </div>
                                        <input type="file" wire:model="uploads.{{ $req->id }}" class="w-full p-2 border border-outline-variant rounded-xl text-xs bg-white" />
                                        @if (isset($uploads[$req->id]))
                                            <div class="text-[11px] text-tertiary flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">check</span>
                                                <span>Berkas dipilih: {{ $uploads[$req->id]->getClientOriginalName() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 rounded-xl bg-surface-container-low text-xs text-on-surface-variant">
                                Layanan ini menggunakan verifikasi standar NIK dan Kartu Keluarga.
                            </div>
                        @endif
                    </div>

                    <!-- STATEMENT -->
                    <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-3">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" wire:model="agreement" class="rounded text-primary focus:ring-primary h-5 w-5 mt-0.5" />
                            <span class="text-xs text-on-surface leading-relaxed">
                                Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan dapat dipertanggungjawabkan untuk keperluan pemrosesan layanan sosial.
                            </span>
                        </label>
                        @error('agreement') <p class="text-xs text-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button 
                            type="button" 
                            wire:click="submit" 
                            wire:loading.attr="disabled"
                            class="px-8 py-3.5 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl flex items-center gap-2 shadow-lg transition-all active:scale-95"
                        >
                            <span wire:loading.remove wire:target="submit">Kirim Pengajuan</span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base animate-spin">refresh</span>
                                <span>Memproses...</span>
                            </span>
                            <span class="material-symbols-outlined text-base" wire:loading.remove wire:target="submit">send</span>
                        </button>
                    </div>

                </div>

                <!-- Sidebar Guidelines -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-high space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">help</span>
                        </div>
                        <h4 class="font-headline font-bold text-sm text-primary">Bantuan &amp; Verifikasi</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Pengajuan akan diverifikasi oleh unit kerja terkait dalam waktu 1-3 hari kerja tergantung jenis permohonan. Pantau selalu nomor tiket Anda.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    @endif

</div>
