<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if ($isSubmitted)
        <!-- SUCCESS STATE -->
        <div class="max-w-3xl mx-auto bg-surface-container-lowest rounded-3xl border border-surface-variant p-8 sm:p-12 shadow-xl text-center space-y-6">
            <div class="w-20 h-20 rounded-full bg-rose-50 text-rose-600 mx-auto flex items-center justify-center ring-8 ring-rose-50">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-rose-700 bg-rose-100 px-3 py-1 rounded-full uppercase tracking-wider">
                    Pengajuan Reaktivasi Berhasil Dikirimkan
                </span>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                    Berkas Reaktivasi KIS / PBI-JK Terdaftar
                </h1>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-lg mx-auto leading-relaxed">
                    Pengajuan Anda telah diterima dan masuk ke antrean verifikasi Dinas Sosial Kabupaten Blitar.
                </p>
            </div>

            <!-- TICKET BADGE -->
            <div class="bg-surface-container-low p-6 rounded-2xl border-2 border-dashed border-rose-300 max-w-md mx-auto space-y-3">
                <span class="text-xs text-outline font-semibold uppercase tracking-wider">Nomor Registrasi / Tiket Pelayanan</span>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold text-primary tracking-wider">
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

            <!-- WORKFLOW PREVIEW -->
            <div class="text-left bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 max-w-lg mx-auto space-y-4">
                <h4 class="font-headline font-bold text-sm text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-base">timeline</span>
                    <span>Alur Proses Reaktivasi:</span>
                </h4>
                <div class="space-y-3 text-xs text-on-surface-variant">
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">1</span>
                        <div><strong>Verifikasi Kelayakan:</strong> Petugas memeriksa desil dan status kepesertaan di SIKS-NG.</div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">2</span>
                        <div><strong>Surat Rekomendasi:</strong> Dinsos menerbitkan surat rekomendasi reaktivasi resmi.</div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">3</span>
                        <div><strong>Diusulkan ke Kemensos RI:</strong> Petugas menginput usulan reaktivasi ke server pusat.</div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-tertiary-fixed text-tertiary flex items-center justify-center font-bold text-[10px] shrink-0 mt-0.5">4</span>
                        <div><strong>Aktif Kembali di BPJS:</strong> Status kepesertaan aktif dan dapat digunakan di faskes.</div>
                    </div>
                </div>
            </div>

            <!-- BUTTONS -->
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

        <!-- FORM WIZARD -->
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
                    <span class="text-primary font-semibold">Form Reaktivasi KIS / PBI-JK</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-surface-variant pb-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-semibold mb-2">
                            <span class="material-symbols-outlined text-xs">emergency</span>
                            <span>Jalur Penanganan Khusus Kesehatan</span>
                        </div>
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">
                            Formulir Reaktivasi KIS / PBI-JK
                        </h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1 max-w-3xl">
                            Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran bagi warga Kabupaten Blitar.
                        </p>
                    </div>

                    <div class="flex items-center gap-3 bg-surface-container-lowest p-3 rounded-2xl border border-outline-variant shadow-sm shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                            <span class="material-symbols-outlined">health_and_safety</span>
                        </div>
                        <div class="text-left">
                            <div class="text-[11px] text-outline font-semibold">Prioritas Darurat</div>
                            <div class="font-headline text-sm font-bold text-rose-800">Rawat Inap Diprioritaskan</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- STEP TRACKER -->
            <section class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Step 1 -->
                    <button type="button" wire:click="goToStep(1)" class="flex items-center gap-3 text-left focus:outline-none">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 1 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 1 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 1) <span class="material-symbols-outlined text-sm">check</span> @else 1 @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 1 ? 'text-primary' : ($currentStep > 1 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 1</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 1 ? 'text-primary' : 'text-on-surface' }}">Data Peserta</span>
                        </div>
                    </button>

                    <!-- Step 2 -->
                    <button type="button" wire:click="goToStep(2)" class="flex items-center gap-3 text-left focus:outline-none">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 2 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 2 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 2) <span class="material-symbols-outlined text-sm">check</span> @else 2 @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 2 ? 'text-primary' : ($currentStep > 2 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 2</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 2 ? 'text-primary' : 'text-on-surface' }}">Alasan Reaktivasi</span>
                        </div>
                    </button>

                    <!-- Step 3 -->
                    <button type="button" wire:click="goToStep(3)" class="flex items-center gap-3 text-left focus:outline-none">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 3 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 3 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 3) <span class="material-symbols-outlined text-sm">check</span> @else 3 @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 3 ? 'text-primary' : ($currentStep > 3 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 3</span>
                            <span class="text-xs sm:text-sm font-semibold {{ $currentStep === 3 ? 'text-primary' : 'text-on-surface' }}">Unggah Berkas</span>
                        </div>
                    </button>

                    <!-- Step 4 -->
                    <button type="button" wire:click="goToStep(4)" class="flex items-center gap-3 text-left focus:outline-none">
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

            <!-- FORM BODY & SIDEBAR -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 space-y-6">

                    <!-- STEP 1: DATA PESERTA & PEMOHON -->
                    @if ($currentStep === 1)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Data Peserta &amp; Kartu BPJS / KIS</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Masukkan data peserta BPJS yang kepesertaannya dinonaktifkan.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Nama Lengkap Peserta BPJS *</label>
                                    <input wire:model="participant_name" type="text" placeholder="Sesuai kartu BPJS / KTP" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                    @error('participant_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">NIK Peserta (16 Digit) *</label>
                                    <input wire:model="participant_nik" type="text" maxlength="16" placeholder="3505..." class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                    @error('participant_nik') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Nomor Kartu Keluarga (16 Digit) *</label>
                                    <input wire:model="family_card_number" type="text" maxlength="16" placeholder="3505..." class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                    @error('family_card_number') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Nomor Kartu BPJS / KIS (13 Digit) *</label>
                                    <input wire:model="bpjs_card_number" type="text" placeholder="000xxxxxxxxxx" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm font-mono focus:border-primary" />
                                    @error('bpjs_card_number') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Perkiraan Tanggal Nonaktif (Bila Tahu)</label>
                                    <input wire:model="deactivated_date" type="date" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Alamat Tempat Tinggal *</label>
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

                                <!-- Data Kontak Pemohon -->
                                <div class="sm:col-span-2 pt-4 border-t border-surface-variant space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-primary uppercase">Kontak Penanggung Jawab / Pemohon</span>
                                        <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-semibold text-primary">
                                            <input wire:model.live="is_same_as_participant" type="checkbox" class="rounded text-primary focus:ring-primary h-4 w-4" />
                                            <span>Pemohon sama dengan Peserta</span>
                                        </label>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Nama Pemohon *</label>
                                            <input wire:model="applicant_name" type="text" placeholder="Nama pengaju" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                            @error('applicant_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">No. WhatsApp / HP Aktif *</label>
                                            <input wire:model="applicant_phone" type="text" placeholder="08xxxxxxxxxx" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                            @error('applicant_phone') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Lanjut ke Alasan Reaktivasi</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: ALASAN REAKTIVASI -->
                    @if ($currentStep === 2)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Alasan Permohonan Reaktivasi</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Pilih kondisi yang mendasari permohonan pengaktifan kembali kepesertaan.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Option 1: Darurat Medis -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $reason === 'emergency' ? 'border-rose-600 bg-rose-50/50 shadow-sm' : 'border-outline-variant hover:border-primary/50' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-lg bg-rose-600 text-white flex items-center justify-center">
                                            <span class="material-symbols-outlined">emergency</span>
                                        </div>
                                        <input type="radio" wire:model.live="reason" value="emergency" class="h-5 w-5 text-rose-600 focus:ring-rose-500" />
                                    </div>
                                    <span class="font-headline font-bold text-sm text-rose-900">Kondisi Darurat Medis</span>
                                    <span class="text-xs text-on-surface-variant mt-1">Sedang menjalani rawat inap gawat darurat di rumah sakit / faskes.</span>
                                    <div class="mt-3 pt-2 border-t border-rose-200 text-[11px] text-rose-700 font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">priority_high</span>
                                        <span>Prioritas Verifikasi 1x24 Jam</span>
                                    </div>
                                </label>

                                <!-- Option 2: Penyakit Kronis / Katastropik -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ in_array($reason, ['chronic', 'catastrophic']) ? 'border-primary bg-surface-container-low shadow-sm' : 'border-outline-variant hover:border-primary/50' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-lg bg-primary text-on-primary flex items-center justify-center">
                                            <span class="material-symbols-outlined">medical_services</span>
                                        </div>
                                        <input type="radio" wire:model.live="reason" value="chronic" class="h-5 w-5 text-primary focus:ring-primary" />
                                    </div>
                                    <span class="font-headline font-bold text-sm text-primary">Penyakit Kronis / Katastropik</span>
                                    <span class="text-xs text-on-surface-variant mt-1">Membutuhkan pengobatan rutin berkelanjutan (cuci darah, kemoterapi, jantung, dll).</span>
                                </label>

                                <!-- Option 3: Bayi Baru Lahir -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $reason === 'newborn' ? 'border-primary bg-surface-container-low shadow-sm' : 'border-outline-variant hover:border-primary/50' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container text-primary flex items-center justify-center">
                                            <span class="material-symbols-outlined">child_care</span>
                                        </div>
                                        <input type="radio" wire:model.live="reason" value="newborn" class="h-5 w-5 text-primary focus:ring-primary" />
                                    </div>
                                    <span class="font-headline font-bold text-sm text-primary">Bayi Baru Lahir dari Ibu PBI</span>
                                    <span class="text-xs text-on-surface-variant mt-1">Pendaftaran bayi baru lahir agar langsung terlindungi BPJS segmen PBI-JK.</span>
                                </label>

                                <!-- Option 4: Lainnya -->
                                <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $reason === 'other' ? 'border-primary bg-surface-container-low shadow-sm' : 'border-outline-variant hover:border-primary/50' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container text-primary flex items-center justify-center">
                                            <span class="material-symbols-outlined">more_horiz</span>
                                        </div>
                                        <input type="radio" wire:model.live="reason" value="other" class="h-5 w-5 text-primary focus:ring-primary" />
                                    </div>
                                    <span class="font-headline font-bold text-sm text-primary">Alasan Lainnya</span>
                                    <span class="text-xs text-on-surface-variant mt-1">Warga prasejahtera yang kepesertaannya terhapus pada pemutakhiran data.</span>
                                </label>
                            </div>

                            @if (in_array($reason, ['emergency', 'chronic', 'catastrophic']))
                                <div class="p-4 bg-surface-container-low rounded-xl border border-surface-container-high space-y-4">
                                    <div class="text-xs font-bold text-primary uppercase">Informasi Fasilitas Kesehatan (Faskes) Perujuk:</div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Nama Rumah Sakit / Puskesmas *</label>
                                            <input wire:model="health_facility_name" type="text" placeholder="Contoh: RSUD Ngudi Waluyo Wlingi" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm bg-surface-container-lowest focus:border-primary" />
                                            @error('health_facility_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-on-surface mb-1">Nomor Surat Keterangan Rawat Inap / Medis</label>
                                            <input wire:model="health_letter_number" type="text" placeholder="Nomor surat jika tersedia" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm bg-surface-container-lowest focus:border-primary" />
                                        </div>
                                    </div>
                                </div>
                            @endif

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
                                <h2 class="font-headline text-lg font-bold text-primary">Unggah Berkas Persyaratan</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Berkas wajib diunggah dalam format gambar (JPG/PNG) atau PDF (maks. 5 MB).</p>
                            </div>

                            <div class="space-y-4">
                                <!-- KTP -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-on-surface">1. Foto / Scan KTP Peserta *</label>
                                    <input type="file" wire:model="ktp_file" class="w-full p-2 border border-outline-variant rounded-xl text-xs bg-surface-container-low" accept=".jpg,.jpeg,.png,.pdf" />
                                    @error('ktp_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                                </div>

                                <!-- KK -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-on-surface">2. Foto / Scan Kartu Keluarga (KK) *</label>
                                    <input type="file" wire:model="kk_file" class="w-full p-2 border border-outline-variant rounded-xl text-xs bg-surface-container-low" accept=".jpg,.jpeg,.png,.pdf" />
                                    @error('kk_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                                </div>

                                <!-- Kartu BPJS -->
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-on-surface">3. Foto Kartu BPJS Kesehatan / KIS Peserta *</label>
                                    <input type="file" wire:model="bpjs_file" class="w-full p-2 border border-outline-variant rounded-xl text-xs bg-surface-container-low" accept=".jpg,.jpeg,.png,.pdf" />
                                    @error('bpjs_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                                </div>

                                <!-- Surat Faskes -->
                                @if (in_array($reason, ['emergency', 'chronic', 'catastrophic']))
                                    <div class="space-y-1.5 p-4 rounded-xl bg-rose-50 border border-rose-200">
                                        <label class="block text-xs font-bold text-rose-900">4. Surat Keterangan Rawat Inap / Medis dari RSUD/Puskesmas *</label>
                                        <input type="file" wire:model="health_letter_file" class="w-full p-2 border border-rose-300 rounded-xl text-xs bg-white" accept=".jpg,.jpeg,.png,.pdf" />
                                        <span class="text-[11px] text-rose-700 block">Wajib dilampirkan untuk verifikasi prioritas darurat medis.</span>
                                        @error('health_letter_file') <p class="text-xs text-error">{{ $message }}</p> @enderror
                                    </div>
                                @endif
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="button" wire:click="prevStep" class="px-5 py-2.5 border border-outline-variant hover:border-primary text-primary font-semibold text-xs rounded-xl">
                                    Kembali
                                </button>
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Tinjau &amp; Kirim</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 4: TINJAU & KIRIM -->
                    @if ($currentStep === 4)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Tinjau Ringkasan Reaktivasi KIS</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Periksa seluruh data peserta dan berkas sebelum dikirimkan.</p>
                            </div>

                            <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant space-y-2 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-primary uppercase">Data Peserta &amp; Alasan</span>
                                    <button type="button" wire:click="goToStep(1)" class="text-primary font-bold hover:underline">Ubah</button>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-on-surface-variant pt-1">
                                    <div><span class="text-outline">Nama Peserta:</span> <strong class="text-on-surface block">{{ $participant_name }}</strong></div>
                                    <div><span class="text-outline">NIK:</span> <strong class="text-on-surface block font-mono">{{ $participant_nik }}</strong></div>
                                    <div><span class="text-outline">Nomor BPJS/KIS:</span> <strong class="text-on-surface block font-mono">{{ $bpjs_card_number }}</strong></div>
                                    <div><span class="text-outline">Alasan:</span> <strong class="text-rose-700 block">{{ ucfirst($reason) }}</strong></div>
                                    @if ($health_facility_name)
                                        <div class="col-span-2"><span class="text-outline">Faskes Rawat:</span> <strong class="text-on-surface block">{{ $health_facility_name }}</strong></div>
                                    @endif
                                </div>
                            </div>

                            <!-- Consent Statement -->
                            <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-3">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="agreement" class="rounded text-primary focus:ring-primary h-5 w-5 mt-0.5" />
                                    <span class="text-xs text-on-surface leading-relaxed">
                                        Saya menyatakan data peserta yang dimasukkan adalah benar, dan bersedia mengikuti proses verifikasi kelayakan reaktivasi sesuai peraturan perundang-undangan.
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
                                    <span wire:loading.remove wire:target="submit">Kirim Permohonan Reaktivasi</span>
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

                <!-- Guidelines Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-high space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center">
                            <span class="material-symbols-outlined">e911_emergency</span>
                        </div>
                        <h4 class="font-headline font-bold text-sm text-primary">Petunjuk Khusus Pasien RS:</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Bagi keluarga pasien rawat inap yang membutuhkan rekomendasi darurat, segera unggah surat keterangan rawat inap faskes agar status tiket langsung diprioritaskan oleh verifikator dinas.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    @endif

</div>
