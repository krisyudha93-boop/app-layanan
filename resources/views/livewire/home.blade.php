<div>
    <!-- 1. HERO SECTION WITH EMBEDDED TICKET TRACKER -->
    <section class="relative bg-surface-container-low pt-10 pb-16 md:py-20 overflow-hidden border-b border-surface-container-high">
        <!-- Decorative Backdrop Elements -->
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-primary-fixed/40 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 bottom-0 w-80 h-80 rounded-full bg-secondary-fixed/40 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                
                <!-- Hero Narrative (7 cols) -->
                <div class="lg:col-span-7 flex flex-col space-y-6">
                    <div class="inline-flex items-center gap-2 bg-surface-container-lowest px-3.5 py-1.5 rounded-full border border-surface-container-highest shadow-sm self-start">
                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary animate-pulse"></span>
                        <span class="text-primary font-semibold text-xs sm:text-sm">Portal Resmi Layanan Sosial Mandiri Terpadu</span>
                    </div>

                    <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-extrabold text-primary tracking-tight leading-tight">
                        Satu Pintu Layanan Sosial <span class="text-secondary">Kabupaten Blitar</span>
                    </h1>

                    <p class="font-body text-base sm:text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                        Ajukan layanan sosial, sampaikan pengaduan warga, dan pantau proses verifikasi secara real-time dengan nomor tiket — dari mana saja secara mudah, transparan, dan akuntabel.
                    </p>

                    <!-- Primary Action Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('layanan.index') }}" class="bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container px-6 py-3.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2.5 active:scale-95">
                            <span class="material-symbols-outlined text-xl" style="font-variation-settings: 'FILL' 1;">assignment_add</span>
                            <span>Ajukan Layanan</span>
                        </a>
                        <a href="{{ route('pengaduan') }}" class="border-2 border-primary-container text-primary hover:bg-surface-container px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 active:scale-95">
                            <span class="material-symbols-outlined text-xl">campaign</span>
                            <span>Sampaikan Pengaduan</span>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="pt-4 flex flex-wrap items-center gap-6 text-on-surface-variant text-xs sm:text-sm border-t border-outline-variant/40">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-tertiary text-lg">verified</span>
                            <span>Verifikasi Resmi SIKS-NG</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-primary text-lg">lock</span>
                            <span>Tanda Tangan Elektronik &amp; QR</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-secondary text-lg">schedule</span>
                            <span>Proses Cepat &amp; Transparan</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Right: Interactive Ticket Tracker Card (5 cols) -->
                <div class="lg:col-span-5" id="cek-status">
                    <div class="bg-surface-container-lowest rounded-2xl border border-surface-container-highest shadow-xl p-6 sm:p-8 relative">
                        <div class="absolute -top-3 right-6 bg-primary text-on-primary text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            Pelacak Berkas Terpadu
                        </div>

                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-12 h-12 rounded-xl bg-surface-container-low text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">manage_search</span>
                            </div>
                            <div>
                                <h2 class="font-headline text-xl font-bold text-primary">Cek Status Tiket</h2>
                                <p class="text-xs text-on-surface-variant">Lacak posisi berkas dan catatan verifikator</p>
                            </div>
                        </div>

                        <form wire:submit="trackTicket" class="space-y-4">
                            <div>
                                <label for="ticket-input" class="block text-sm font-semibold text-on-surface mb-1.5">
                                    Nomor Registrasi / Tiket Pelayanan
                                </label>
                                <div class="relative">
                                    <input 
                                        wire:model="ticketNumber"
                                        id="ticket-input"
                                        type="text" 
                                        placeholder="Contoh: DTSEN-202609-00001" 
                                        class="w-full h-12 pl-11 pr-4 bg-surface-container-lowest border-2 border-outline-variant focus:border-primary-container focus:ring-2 focus:ring-primary/20 rounded-xl font-body text-sm text-on-surface placeholder:text-outline transition-all"
                                    />
                                    <span class="material-symbols-outlined absolute left-3.5 top-3 text-outline text-xl">tag</span>
                                </div>
                                @error('ticketNumber')
                                    <p class="text-xs text-error mt-1.5">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-on-surface-variant mt-1.5">
                                    Format: DTSEN-..., PBI-..., ADU-..., atau REQ-...
                                </p>
                            </div>

                            <button 
                                type="submit" 
                                class="w-full h-12 bg-primary hover:bg-primary-container text-on-primary rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-sm active:scale-95"
                            >
                                <span class="material-symbols-outlined text-lg">search</span>
                                <span>Lacak Status Berkas</span>
                            </button>
                        </form>

                        <!-- Quick Hint Banner -->
                        <div class="mt-5 p-3.5 rounded-xl bg-surface-container-low border border-surface-container-high text-xs text-on-surface-variant flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">info</span>
                            <span>Tidak memerlukan login. Cukup nomor tiket &amp; 4 digit NIK/HP.</span>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('lacak') }}" class="text-xs text-primary font-semibold hover:underline inline-flex items-center gap-1">
                                <span>Buka Halaman Pencarian Lengkap</span>
                                <span class="material-symbols-outlined text-xs">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. LAYANAN UTAMA (BENTO GRID: 3 PRIORITAS + 2 SEKUNDER) -->
    <section class="py-16 md:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="layanan">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-wider mb-2">
                    <span class="material-symbols-outlined text-secondary text-base">verified_user</span>
                    <span>Katalog Layanan Publik</span>
                </div>
                <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary">Layanan Prioritas Dinsos</h2>
                <p class="text-base text-on-surface-variant max-w-2xl mt-1">
                    Dinas Sosial Kabupaten Blitar memprioritaskan 3 layanan terpenting untuk kemudahan warga Blitar.
                </p>
            </div>
            <a href="{{ route('layanan.index') }}" class="text-primary font-bold text-sm hover:underline inline-flex items-center gap-1.5 self-start md:self-auto">
                <span>Lihat Seluruh Layanan</span>
                <span class="material-symbols-outlined text-base">arrow_forward</span>
            </a>
        </div>

        <!-- 3 Priority Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- CARD 1: SK DTSEN -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-6 lg:p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-surface-container-low text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">description</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-surface-container-high text-primary text-[11px] font-bold px-2.5 py-0.5 rounded-full">⭐ Prioritas Utama</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary group-hover:text-primary-container transition-colors mb-2">
                        Surat Keterangan DTSEN
                    </h3>
                    <p class="text-sm text-on-surface-variant mb-4 leading-relaxed">
                        Surat bukti keterangan peringkat desil Data Tunggal Sosial Ekonomi Nasional (DTSEN/DTKS) untuk SPMB Afirmasi, PIP, KIP Kuliah, dan bantuan sosial.
                    </p>
                    <ul class="space-y-2 mb-6 text-xs text-on-surface-variant">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Syarat minimal KTP &amp; Kartu Keluarga</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Surat resmi bertanda TTE &amp; QR verifikasi</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 border-t border-surface-container-highest flex items-center gap-3">
                    <a href="{{ route('pengajuan.dtsen') }}" class="flex-1 py-2.5 px-3 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-bold text-sm rounded-xl text-center shadow-sm transition-all active:scale-95">
                        Ajukan Sekarang
                    </a>
                    <a href="{{ route('layanan.detail', ['slug' => 'surat-keterangan-dtsen']) }}" class="flex-1 py-2.5 px-3 border border-outline-variant hover:border-primary text-primary font-semibold text-sm rounded-xl text-center transition-colors">
                        Persyaratan
                    </a>
                </div>
            </div>

            <!-- CARD 2: REAKTIVASI KIS / PBI-JK -->
            <div class="bg-surface-container-lowest rounded-2xl border-2 border-primary/20 p-6 lg:p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 relative group hover:-translate-y-1">
                <div class="absolute -top-3 left-6">
                    <span class="bg-rose-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">emergency</span>
                        <span>Darurat Medis Diprioritaskan</span>
                    </span>
                </div>
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-surface-container-low text-primary flex items-center justify-center mb-6 mt-2 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">health_and_safety</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-rose-100 text-rose-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full">Layanan Cepat Tanggap</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary group-hover:text-primary-container transition-colors mb-2">
                        Reaktivasi KIS / PBI-JK
                    </h3>
                    <p class="text-sm text-on-surface-variant mb-4 leading-relaxed">
                        Fasilitasi pengaktifan kembali kepesertaan JKN-KIS Penerima Bantuan Iuran yang nonaktif karena kuota atau perubahan data Kemensos RI.
                    </p>
                    <ul class="space-y-2 mb-6 text-xs text-on-surface-variant">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Verifikasi kelayakan &amp; usulan ke Kemensos</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Pantau hingga aktif kembali di BPJS</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 border-t border-surface-container-highest flex items-center gap-3">
                    <a href="{{ route('pengajuan.pbi') }}" class="flex-1 py-2.5 px-3 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-bold text-sm rounded-xl text-center shadow-sm transition-all active:scale-95">
                        Ajukan Reaktivasi
                    </a>
                    <a href="{{ route('layanan.detail', ['slug' => 'reaktivasi-kis-pbi-jk']) }}" class="flex-1 py-2.5 px-3 border border-outline-variant hover:border-primary text-primary font-semibold text-sm rounded-xl text-center transition-colors">
                        Persyaratan
                    </a>
                </div>
            </div>

            <!-- CARD 3: REHABILITASI SOSIAL -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-6 lg:p-8 flex flex-col justify-between hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                <div>
                    <div class="w-14 h-14 rounded-2xl bg-surface-container-low text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">accessible_forward</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-surface-container-high text-primary text-[11px] font-bold px-2.5 py-0.5 rounded-full">Perlindungan Khusus</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary group-hover:text-primary-container transition-colors mb-2">
                        Pelayanan Rehabilitasi Sosial
                    </h3>
                    <p class="text-sm text-on-surface-variant mb-4 leading-relaxed">
                        Pendampingan dan pemulihan sosial bagi lansia terlantar, disabilitas, ODGJ terlantar, anak terlantar, serta korban kekerasan.
                    </p>
                    <ul class="space-y-2 mb-6 text-xs text-on-surface-variant">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Assessment langsung petugas sosial</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-base">check_circle</span>
                            <span>Layanan langsung atau rujukan ke panti/RS</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 border-t border-surface-container-highest flex items-center gap-3">
                    <a href="{{ route('rehabilitasi') }}" class="flex-1 py-2.5 px-3 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container font-bold text-sm rounded-xl text-center shadow-sm transition-all active:scale-95">
                        Lihat Alur &amp; Ajukan
                    </a>
                    <a href="{{ route('pengaduan') }}" class="flex-1 py-2.5 px-3 border border-outline-variant hover:border-primary text-primary font-semibold text-sm rounded-xl text-center transition-colors">
                        Laporkan Kasus
                    </a>
                </div>
            </div>

        </div>

        <!-- Secondary Row: Layanan Sosial Lainnya & Pengaduan -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-highest flex items-start gap-5 hover:border-primary/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-surface-container-lowest text-primary flex items-center justify-center shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-2xl">category</span>
                </div>
                <div class="flex-grow">
                    <h4 class="font-headline text-lg font-bold text-primary mb-1">Layanan Sosial Lainnya</h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant mb-3 leading-relaxed">
                        Pengajuan rekomendasi bantuan sosial, santunan kedaruratan, serta permohonan administrasi sosial lainnya dengan formulir terstandar.
                    </p>
                    <a href="{{ route('pengajuan.lainnya') }}" class="text-primary font-bold text-xs sm:text-sm hover:underline inline-flex items-center gap-1">
                        <span>Buka Formulir Pengajuan Lainnya</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-highest flex items-start gap-5 hover:border-secondary/40 transition-colors">
                <div class="w-12 h-12 rounded-xl bg-surface-container-lowest text-secondary flex items-center justify-center shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-2xl">campaign</span>
                </div>
                <div class="flex-grow">
                    <h4 class="font-headline text-lg font-bold text-primary mb-1">Pengaduan &amp; Laporan Sosial</h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant mb-3 leading-relaxed">
                        Temukan warga terlantar di sekitar Anda atau ada kendala penyaluran bansos? Laporkan segera ke Dinas Sosial Kabupaten Blitar.
                    </p>
                    <a href="{{ route('pengaduan') }}" class="text-secondary font-bold text-xs sm:text-sm hover:underline inline-flex items-center gap-1">
                        <span>Kirim Pengaduan / Aduan Warga</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. CARA KERJA (4-STEP STEPPER) -->
    <section class="py-16 bg-surface-container-lowest border-y border-surface-container-high">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-secondary font-bold text-xs uppercase tracking-wider">Alur Pelayanan Digital</span>
                <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary mt-1">4 Langkah Mudah Pelayanan</h2>
                <p class="text-sm sm:text-base text-on-surface-variant mt-2">
                    Proses pengajuan sosial dibuat ringkas, transparan, dan dapat dipantau dari gawai Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary text-on-primary flex items-center justify-center font-headline text-2xl font-bold mb-4 shadow-md ring-8 ring-surface-container-low">
                        1
                    </div>
                    <span class="material-symbols-outlined text-primary mb-2 text-2xl">touch_app</span>
                    <h3 class="font-headline text-lg font-bold text-primary mb-1">Pilih Layanan</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Pilih jenis layanan sosial yang dibutuhkan sesuai peruntukan.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary text-on-primary flex items-center justify-center font-headline text-2xl font-bold mb-4 shadow-md ring-8 ring-surface-container-low">
                        2
                    </div>
                    <span class="material-symbols-outlined text-primary mb-2 text-2xl">upload_file</span>
                    <h3 class="font-headline text-lg font-bold text-primary mb-1">Isi Data &amp; Berkas</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Lengkapi NIK, No. KK, dan unggah foto/scan dokumen persyaratan.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-16 h-16 rounded-2xl bg-primary text-on-primary flex items-center justify-center font-headline text-2xl font-bold mb-4 shadow-md ring-8 ring-surface-container-low">
                        3
                    </div>
                    <span class="material-symbols-outlined text-primary mb-2 text-2xl">confirmation_number</span>
                    <h3 class="font-headline text-lg font-bold text-primary mb-1">Dapat Nomor Tiket</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Simpan nomor registrasi unik untuk pelacakan tahapan verifikasi.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="flex flex-col items-center text-center p-4">
                    <div class="w-16 h-16 rounded-2xl bg-secondary-container text-on-secondary-container flex items-center justify-center font-headline text-2xl font-bold mb-4 shadow-md ring-8 ring-secondary-fixed">
                        4
                    </div>
                    <span class="material-symbols-outlined text-secondary mb-2 text-2xl">download_for_offline</span>
                    <h3 class="font-headline text-lg font-bold text-primary mb-1">Pantau &amp; Unduh Surat</h3>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Pantau status secara online. Unduh surat resmi bertanda TTE jika telah disetujui.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. BANNER VERIFIKASI KEASLIAN SK -->
    <section class="py-14 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-primary to-primary-container rounded-3xl text-on-primary p-8 md:p-12 shadow-xl overflow-hidden relative">
            <span class="material-symbols-outlined absolute -right-8 -bottom-10 text-[200px] text-white/5 pointer-events-none">security_update_good</span>
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <div class="lg:col-span-8 space-y-3">
                    <div class="inline-flex items-center gap-2 bg-on-primary/10 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold">
                        <span class="material-symbols-outlined text-sm">qr_code_scanner</span>
                        <span>Verifikasi Dokumen Resmi Blitar</span>
                    </div>
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-white">
                        Cek Keaslian Surat Keterangan DTSEN
                    </h2>
                    <p class="text-sm sm:text-base text-surface-container-high max-w-2xl leading-relaxed">
                        Setiap Surat Keterangan yang diterbitkan Dinas Sosial Kabupaten Blitar memuat QR Code dan kode verifikasi resmi. Cek keaslian surat untuk memastikan keabsahan dokumen.
                    </p>
                </div>
                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3 justify-center">
                    <a href="{{ route('surat.verifikasi') }}" class="px-6 py-3.5 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container rounded-xl font-bold text-sm text-center shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        <span>Verifikasi Surat Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. INFORMASI & FAQ PREVIEW -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" id="faq">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: FAQs Accordion (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-secondary font-bold text-xs uppercase tracking-wider">Tanya Jawab</span>
                    <h2 class="font-headline text-2xl sm:text-3xl font-bold text-primary mt-1">Pertanyaan yang Sering Diajukan</h2>
                    <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                        Informasi praktis seputar persyaratan dan proses layanan sosial.
                    </p>
                </div>

                <div class="space-y-3" x-data="{ activeAccordion: 1 }">
                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-4 shadow-sm">
                        <button 
                            type="button" 
                            @click="activeAccordion = (activeAccordion === 1 ? null : 1)" 
                            class="w-full flex items-center justify-between text-left font-headline font-bold text-sm sm:text-base text-primary"
                        >
                            <span>Berapa lama proses penerbitan Surat Keterangan DTSEN?</span>
                            <span class="material-symbols-outlined text-lg transition-transform" :class="activeAccordion === 1 ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="activeAccordion === 1" class="mt-3 text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-surface-container-high pt-3">
                            Standar pelayanan penerbitan Surat Keterangan DTSEN adalah 1x24 jam kerja setelah berkas (KTP dan KK) dinyatakan lengkap dan hasil pengecekan SIKS-NG memenuhi ketentuan desil tujuan penggunaan.
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-4 shadow-sm">
                        <button 
                            type="button" 
                            @click="activeAccordion = (activeAccordion === 2 ? null : 2)" 
                            class="w-full flex items-center justify-between text-left font-headline font-bold text-sm sm:text-base text-primary"
                        >
                            <span>Apakah warga yang belum memiliki akun bisa mengajukan layanan?</span>
                            <span class="material-symbols-outlined text-lg transition-transform" :class="activeAccordion === 2 ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="activeAccordion === 2" class="mt-3 text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-surface-container-high pt-3">
                            Ya, masyarakat dapat langsung mengajukan layanan dan cek status cukup dengan Nomor Tiket serta 4 digit terakhir NIK atau nomor WhatsApp yang didaftarkan tanpa harus login terlebih dahulu.
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-4 shadow-sm">
                        <button 
                            type="button" 
                            @click="activeAccordion = (activeAccordion === 3 ? null : 3)" 
                            class="w-full flex items-center justify-between text-left font-headline font-bold text-sm sm:text-base text-primary"
                        >
                            <span>Bagaimana jika kartu BPJS PBI dinonaktifkan saat sedang darurat medis?</span>
                            <span class="material-symbols-outlined text-lg transition-transform" :class="activeAccordion === 3 ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="activeAccordion === 3" class="mt-3 text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-surface-container-high pt-3">
                            Pilih layanan "Reaktivasi KIS/PBI-JK", tandai alasan "Kondisi Darurat Medis", dan lampirkan surat keterangan rawat inap dari fasilitas kesehatan (RSUD/Puskesmas). Pengajuan darurat medis ditandai prioritas dan langsung ditindaklanjuti verifikator.
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant p-4 shadow-sm">
                        <button 
                            type="button" 
                            @click="activeAccordion = (activeAccordion === 4 ? null : 4)" 
                            class="w-full flex items-center justify-between text-left font-headline font-bold text-sm sm:text-base text-primary"
                        >
                            <span>Bagaimana cara melaporkan lansia terlantar atau ODGJ di lingkungan kami?</span>
                            <span class="material-symbols-outlined text-lg transition-transform" :class="activeAccordion === 4 ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div x-show="activeAccordion === 4" class="mt-3 text-xs sm:text-sm text-on-surface-variant leading-relaxed border-t border-surface-container-high pt-3">
                            Buka menu "Pengaduan Sosial", pilih kategori permasalahan, cantumkan lokasi kecamatan dan desa/kelurahan serta foto situasi. Laporan Anda akan didisposisikan ke petugas rehabilitasi sosial untuk dilakukan assessment lapangan.
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('informasi.faq') }}" class="text-primary font-bold text-sm hover:underline inline-flex items-center gap-1.5">
                        <span>Lihat Semua Informasi &amp; Formulir Unduhan</span>
                        <span class="material-symbols-outlined text-base">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Right: Puskesos & Bantuan Wilayah Card (5 cols) -->
            <div class="lg:col-span-5 bg-surface-container-low rounded-3xl p-6 sm:p-8 border border-surface-container-high">
                <div class="w-12 h-12 rounded-2xl bg-primary text-on-primary flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined text-2xl">support_agent</span>
                </div>
                <h3 class="font-headline text-xl font-bold text-primary mb-2">Butuh Pendampingan Langsung?</h3>
                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6">
                    Warga yang mengalami kendala teknis atau tidak memiliki gawai dapat mendatangi kantor Kecamatan, Desa/Kelurahan setempat, atau posko Puskesos untuk didampingi oleh Operator Desa.
                </p>

                <div class="space-y-4 border-t border-outline-variant/40 pt-5 text-xs sm:text-sm">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-lg mt-0.5">location_city</span>
                        <div>
                            <span class="font-semibold text-primary block">Tersedia di 22 Kecamatan &amp; 248 Desa/Kelurahan</span>
                            <span class="text-on-surface-variant">Operator siap mendampingi pengajuan dan pencetakan dokumen.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-lg mt-0.5">contact_phone</span>
                        <div>
                            <span class="font-semibold text-primary block">Layanan Konsultasi Dinsos</span>
                            <span class="text-on-surface-variant">Senin - Jumat 08.00 - 15.30 WIB di Kantor Dinsos Kab. Blitar.</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-outline-variant/40 flex flex-col gap-2">
                    <a href="{{ route('layanan.index') }}" class="w-full py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm text-center rounded-xl transition-colors">
                        Mulai Pengajuan Mandiri
                    </a>
                </div>
            </div>

        </div>
    </section>
</div>
