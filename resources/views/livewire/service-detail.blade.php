<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ activeTab: 'deskripsi' }">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <a href="{{ route('layanan.index') }}" class="hover:text-primary transition-colors">Layanan</a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">
            @if ($isDtsen) Surat Keterangan DTSEN
            @elseif ($isPbi) Reaktivasi KIS / PBI-JK
            @elseif ($isRehsos) Pelayanan Rehabilitasi Sosial
            @else {{ $serviceType?->name ?? 'Detail Layanan' }}
            @endif
        </span>
    </nav>

    <!-- HEADER DETAIL LAYANAN -->
    <div class="space-y-4">
        <div class="flex flex-wrap items-center gap-3 text-xs">
            <span class="px-3 py-1 bg-surface-container-high text-primary rounded-full font-bold">
                @if ($isDtsen) Surat Keterangan Resmi
                @elseif ($isPbi) Jaminan Kesehatan
                @elseif ($isRehsos) Perlindungan &amp; Pemulihan
                @else {{ $serviceType?->category ?? 'Layanan Sosial' }}
                @endif
            </span>
            <span class="px-3 py-1 bg-surface-container text-on-surface-variant rounded-full flex items-center gap-1.5">
                <span class="material-symbols-outlined text-xs">update</span>
                <span>Diperbarui: September 2026</span>
            </span>
            <span class="px-3 py-1 bg-tertiary-fixed text-on-tertiary-fixed rounded-full flex items-center gap-1 font-semibold">
                <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                <span>Layanan Online Aktif</span>
            </span>
        </div>

        <h1 class="font-headline text-3xl sm:text-4xl font-extrabold text-primary tracking-tight">
            @if ($isDtsen)
                Surat Keterangan DTSEN (Data Tunggal Sosial Ekonomi Nasional)
            @elseif ($isPbi)
                Fasilitasi Reaktivasi KIS / PBI-JK (Penerima Bantuan Iuran)
            @elseif ($isRehsos)
                Pelayanan &amp; Pendampingan Rehabilitasi Sosial
            @else
                {{ $serviceType?->name ?? 'Layanan Sosial Terpadu' }}
            @endif
        </h1>

        <!-- ALERT BOX / CALLOUT -->
        @if ($isDtsen)
            <div class="bg-secondary-fixed/40 border-l-4 border-secondary-container p-4 rounded-r-2xl flex items-start gap-3">
                <span class="material-symbols-outlined text-secondary text-2xl mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                <div class="text-xs sm:text-sm text-on-surface leading-relaxed">
                    <strong class="font-bold text-on-secondary-fixed-variant">Perhatian Ketentuan:</strong> Surat Keterangan DTSEN hanya dapat diterbitkan bagi pemohon yang NIK/KK-nya aktif dan tercatat pada desil DTKS sesuai batas maksimal peruntukan (SPMB/PIP desil 1–5). Dokumen dilengkapi TTE resmi &amp; QR verifikasi.
                </div>
            </div>
        @elseif ($isPbi)
            <div class="bg-rose-50 border-l-4 border-rose-600 p-4 rounded-r-2xl flex items-start gap-3">
                <span class="material-symbols-outlined text-rose-600 text-2xl mt-0.5" style="font-variation-settings: 'FILL' 1;">emergency</span>
                <div class="text-xs sm:text-sm text-on-surface leading-relaxed">
                    <strong class="font-bold text-rose-900">Prioritas Darurat Medis:</strong> Pengajuan dengan alasan rawat inap darurat/penyakit katastropik akan ditandai prioritas dan langsung diverifikasi petugas untuk diterbitkan surat rekomendasi ke Kemensos RI.
                </div>
            </div>
        @else
            <div class="bg-surface-container-low border-l-4 border-primary p-4 rounded-r-2xl flex items-start gap-3">
                <span class="material-symbols-outlined text-primary text-2xl mt-0.5">info</span>
                <div class="text-xs sm:text-sm text-on-surface leading-relaxed">
                    <strong class="font-bold text-primary">Informasi Layanan:</strong> Pastikan Anda telah mempersiapkan dokumen persyaratan dalam format foto (JPG/PNG) atau PDF sebelum mengisi formulir.
                </div>
            </div>
        @endif
    </div>

    <!-- MAIN TWO-COLUMN LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT COLUMN: CONTENT (8 COLS) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Navigation Tabs -->
            <div class="bg-surface-container-lowest p-1.5 rounded-2xl border border-surface-variant flex flex-wrap gap-1 shadow-sm">
                <button 
                    type="button" 
                    @click="activeTab = 'deskripsi'" 
                    :class="activeTab === 'deskripsi' ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-colors"
                >
                    Deskripsi
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'persyaratan'" 
                    :class="activeTab === 'persyaratan' ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-colors"
                >
                    Persyaratan Berkas
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'alur'" 
                    :class="activeTab === 'alur' ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-colors"
                >
                    Alur Pelayanan
                </button>
                <button 
                    type="button" 
                    @click="activeTab = 'waktu'" 
                    :class="activeTab === 'waktu' ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:bg-surface-container'"
                    class="px-4 py-2 rounded-xl text-xs sm:text-sm font-medium transition-colors"
                >
                    Waktu &amp; Biaya
                </button>
            </div>

            <!-- Tab 1: Deskripsi -->
            <div x-show="activeTab === 'deskripsi'" class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <h2 class="font-headline text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <span>Deskripsi &amp; Kegunaan Layanan</span>
                </h2>
                
                @if ($isDtsen)
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Surat Keterangan DTSEN adalah surat resmi yang menerangkan bahwa pemohon atau anggota keluarganya terdaftar dalam Data Tunggal Sosial Ekonomi Nasional (DTSEN/DTKS) dengan peringkat desil tertentu. Petugas Dinsos melakukan validasi langsung ke basis data SIKS-NG Kementerian Sosial Republik Indonesia.
                    </p>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Dokumen ini dilengkapi dengan tanda tangan elektronik pejabat berwenang dan QR Code keaslian yang dapat diverifikasi oleh pihak universitas, sekolah, atau instansi lain.
                    </p>
                    <div class="pt-2">
                        <span class="text-xs font-bold text-primary uppercase tracking-wider block mb-2">Tujuan Penggunaan Utama:</span>
                        <ul class="space-y-2 text-xs sm:text-sm text-on-surface-variant">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                <span>Pendaftaran Siswa Baru (SPMB) Jalur Afirmasi jenjang SD, SMP, SMA/SMK</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                <span>Persyaratan Program Indonesia Pintar (PIP) dan KIP Kuliah</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                <span>Pengajuan beasiswa daerah dan keringanan Uang Kuliah Tunggal (UKT)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                                <span>Syarat administrasi bantuan sosial dan layanan kesehatan daerah</span>
                            </li>
                        </ul>
                    </div>
                @elseif ($isPbi)
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Layanan reaktivasi KIS / PBI-JK ditujukan untuk memfasilitasi pengaktifan kembali kartu BPJS Kesehatan Penerima Bantuan Iuran yang telah dinonaktifkan oleh Kementerian Sosial, khususnya bagi masyarakat yang mengalami kondisi sakit kronis, darurat medis, atau bayi baru lahir.
                    </p>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Dinas Sosial Kabupaten Blitar memverifikasi kelayakan, menerbitkan surat rekomendasi resmi, menginput usulan ke sistem SIKS-NG Kemensos RI, dan memantau status hingga peserta aktif kembali di BPJS Kesehatan.
                    </p>
                @else
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        {{ $serviceType?->description ?? 'Pelayanan sosial terintegrasi Dinas Sosial Kabupaten Blitar yang ditangani langsung oleh petugas yang berwenang.' }}
                    </p>
                @endif
            </div>

            <!-- Tab 2: Persyaratan Berkas -->
            <div x-show="activeTab === 'persyaratan'" class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-headline text-xl font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">task</span>
                        <span>Persyaratan Dokumen</span>
                    </h2>
                    <span class="text-xs bg-amber-100 text-amber-800 font-bold px-2.5 py-1 rounded-full">Wajib Diunggah</span>
                </div>
                <p class="text-xs sm:text-sm text-on-surface-variant">
                    Pastikan foto atau hasil scan dokumen jelas, terbaca, tidak terpotong (format JPG/PNG/PDF, maks 5 MB per berkas):
                </p>

                <div class="space-y-3 pt-2">
                    <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">badge</span>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-primary">Kartu Tanda Penduduk (KTP) Pemohon</div>
                            <div class="text-xs text-on-surface-variant mt-0.5">KTP asli atau Surat Keterangan Kependudukan resmi dengan NIK 16 digit.</div>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">family_restroom</span>
                        </div>
                        <div>
                            <div class="font-bold text-sm text-primary">Kartu Keluarga (KK) Kabupaten Blitar</div>
                            <div class="text-xs text-on-surface-variant mt-0.5">Kartu Keluarga terbaru ber-barcode Dukcapil yang mencantumkan nama pemohon.</div>
                        </div>
                    </div>

                    @if ($isPbi)
                        <div class="p-4 rounded-xl bg-surface-container-low border border-surface-variant flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary text-on-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-sm">credit_card</span>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-primary">Kartu BPJS Kesehatan / KIS</div>
                                <div class="text-xs text-on-surface-variant mt-0.5">Foto kartu fisik atau tangkapan layar kartu digital dari aplikasi Mobile JKN.</div>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-rose-600 text-white flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-sm">local_hospital</span>
                            </div>
                            <div>
                                <div class="font-bold text-sm text-rose-900">Surat Keterangan Rawat Inap / Fasilitas Kesehatan</div>
                                <div class="text-xs text-rose-800 mt-0.5">Wajib dilampirkan bagi pemohon alasan kondisi darurat medis atau sakit kronis.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab 3: Alur Pelayanan -->
            <div x-show="activeTab === 'alur'" class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant shadow-sm space-y-6">
                <h2 class="font-headline text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">account_tree</span>
                    <span>Alur Tahapan Pelayanan</span>
                </h2>

                <div class="space-y-6 relative border-l-2 border-surface-container-high ml-4 pl-6">
                    <div class="relative">
                        <div class="absolute -left-[33px] top-0 w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs">1</div>
                        <h4 class="font-headline font-bold text-sm text-primary">Pengajuan Mandiri / Melalui Operator</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Pemohon mengisi formulir online dan mengunggah dokumen persyaratan. Sistem menerbitkan Nomor Tiket.</p>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-[33px] top-0 w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs">2</div>
                        <h4 class="font-headline font-bold text-sm text-primary">Pemeriksaan Berkas &amp; Validasi SIKS-NG</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Petugas memeriksa kelengkapan dokumen dan mengecek keaktifan data pemohon di SIKS-NG Kemensos.</p>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-[33px] top-0 w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-xs">3</div>
                        <h4 class="font-headline font-bold text-sm text-primary">Persetujuan &amp; Tanda Tangan Elektronik</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Persetujuan berjenjang oleh Kepala Bidang dan penandatanganan oleh Kepala Dinas Sosial.</p>
                    </div>

                    <div class="relative">
                        <div class="absolute -left-[33px] top-0 w-8 h-8 rounded-full bg-tertiary text-on-tertiary flex items-center justify-center font-bold text-xs">4</div>
                        <h4 class="font-headline font-bold text-sm text-tertiary">Dokumen Terbit / Selesai</h4>
                        <p class="text-xs text-on-surface-variant mt-1">Surat resmi terbit dengan QR Code verifikasi. Pemohon dapat mengunduh langsung dari sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Waktu & Biaya -->
            <div x-show="activeTab === 'waktu'" class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant shadow-sm space-y-6">
                <h2 class="font-headline text-xl font-bold text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">schedule</span>
                    <span>Waktu Pelayanan &amp; Biaya</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                        <div class="text-xs font-bold text-outline uppercase tracking-wider">Waktu Penyelesaian (SLA)</div>
                        <div class="font-headline text-2xl font-extrabold text-primary">1x24 Jam Kerja</div>
                        <p class="text-xs text-on-surface-variant">Terhitung sejak dokumen persyaratan dinyatakan lengkap dan lolos verifikasi SIKS-NG.</p>
                    </div>

                    <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                        <div class="text-xs font-bold text-outline uppercase tracking-wider">Tarif / Biaya</div>
                        <div class="font-headline text-2xl font-extrabold text-tertiary">Rp 0,- (GRATIS)</div>
                        <p class="text-xs text-on-surface-variant">Seluruh pelayanan sosial Dinas Sosial Kabupaten Blitar tidak dipungut biaya apapun (Bebas Pungli).</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: STICKY ACTION CARD (4 COLS) -->
        <div class="lg:col-span-4 space-y-6 sticky top-28">
            <div class="bg-surface-container-lowest rounded-2xl border border-primary/20 shadow-xl p-6 sm:p-7 space-y-6">
                <div>
                    <span class="text-[11px] font-bold text-primary uppercase tracking-wider block mb-1">Aksi Cepat Layanan</span>
                    <h3 class="font-headline text-xl font-extrabold text-primary">Mulai Pengajuan</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Siapkan KTP dan KK Anda untuk mengisi formulir secara mandiri.</p>
                </div>

                <div class="space-y-3">
                    @if ($isDtsen)
                        <a href="{{ route('pengajuan.dtsen') }}" class="w-full py-3.5 px-4 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2 active:scale-95">
                            <span class="material-symbols-outlined text-lg">edit_document</span>
                            <span>Ajukan Surat Sekarang</span>
                        </a>
                    @elseif ($isPbi)
                        <a href="{{ route('pengajuan.pbi') }}" class="w-full py-3.5 px-4 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2 active:scale-95">
                            <span class="material-symbols-outlined text-lg">health_and_safety</span>
                            <span>Ajukan Reaktivasi KIS</span>
                        </a>
                    @elseif ($isRehsos)
                        <a href="{{ route('rehabilitasi') }}" class="w-full py-3.5 px-4 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2 active:scale-95">
                            <span class="material-symbols-outlined text-lg">healing</span>
                            <span>Buka Layanan Rehsos</span>
                        </a>
                    @else
                        <a href="{{ route('pengajuan.lainnya') }}" class="w-full py-3.5 px-4 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-extrabold text-sm rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2 active:scale-95">
                            <span class="material-symbols-outlined text-lg">edit</span>
                            <span>Isi Formulir Pengajuan</span>
                        </a>
                    @endif

                    <a href="{{ route('lacak') }}" class="w-full py-2.5 px-4 border border-outline-variant hover:border-primary text-primary font-bold text-xs sm:text-sm rounded-xl text-center transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">search_check</span>
                        <span>Cek Status Tiket Anda</span>
                    </a>
                </div>

                <div class="pt-4 border-t border-surface-container-high space-y-3 text-xs text-on-surface-variant">
                    <div class="flex items-center gap-2 text-primary font-semibold">
                        <span class="material-symbols-outlined text-base">headset_mic</span>
                        <span>Bantuan Petugas Pelayanan:</span>
                    </div>
                    <p class="leading-relaxed">
                        Kantor Dinsos Kab. Blitar: Jl. Merdeka No. 45<br>
                        Senin - Jumat 08.00 - 15.30 WIB
                    </p>
                </div>
            </div>

            <!-- QR Verification Link Card -->
            <div class="bg-surface-container-low rounded-2xl p-5 border border-surface-container-high text-xs space-y-2">
                <div class="font-bold text-primary flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base text-secondary">verified</span>
                    <span>Sudah memiliki surat fisik/PDF?</span>
                </div>
                <p class="text-on-surface-variant">
                    Verifikasi keabsahan dokumen tanda tangan digital Dinsos Blitar melalui pemindai QR atau nomor registrasi.
                </p>
                <a href="{{ route('surat.verifikasi') }}" class="text-primary font-bold hover:underline inline-flex items-center gap-1 pt-1">
                    <span>Verifikasi Keaslian Surat</span>
                    <span class="material-symbols-outlined text-xs">arrow_forward</span>
                </a>
            </div>
        </div>

    </div>

</div>
