<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">
    
    <!-- BREADCRUMB -->
    <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">home</span>
            <span>Beranda</span>
        </a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold">Pelayanan Rehabilitasi Sosial</span>
    </nav>

    <!-- 1. HERO SECTION -->
    <section class="bg-surface-container-low rounded-3xl p-8 sm:p-12 border border-surface-container-high relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-primary-fixed/30 blur-3xl pointer-events-none"></div>

        <div class="max-w-3xl space-y-4 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-lowest text-primary rounded-full text-xs font-semibold shadow-sm">
                <span class="material-symbols-outlined text-xs">healing</span>
                <span>Bidang Rehabilitasi Sosial Dinsos Blitar</span>
            </div>

            <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-extrabold text-primary tracking-tight leading-tight">
                Pelayanan &amp; Pendampingan <span class="text-secondary">Rehabilitasi Sosial</span>
            </h1>

            <p class="text-base text-on-surface-variant leading-relaxed">
                Pendampingan pemulihan, perlindungan, dan pemenuhan hak-hak dasar bagi pemerlu pelayanan kesejahteraan sosial (PPKS) agar dapat kembali berfungsi sosial secara mandiri dan bermartabat.
            </p>

            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ route('pengajuan.lainnya') }}" class="px-6 py-3.5 bg-primary hover:bg-primary-container text-on-primary rounded-xl font-bold text-sm shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">edit_note</span>
                    <span>Ajukan Permohonan Pendampingan</span>
                </a>
                <a href="{{ route('pengaduan') }}" class="px-6 py-3.5 bg-secondary-container hover:bg-secondary-fixed-dim text-on-secondary-container rounded-xl font-bold text-sm shadow-md transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">campaign</span>
                    <span>Laporkan Temuan Kasus Warga</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 2. SIAPA YANG DAPAT DILAYANI? -->
    <section class="space-y-6">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-secondary font-bold text-xs uppercase tracking-wider">Sasaran Penerima Manfaat</span>
            <h2 class="font-headline text-2xl sm:text-3xl font-bold text-primary">Siapa yang Dapat Dilayani?</h2>
            <p class="text-xs sm:text-sm text-on-surface-variant">
                Pemerlu Pelayanan Kesejahteraan Sosial (PPKS) yang berdomisili atau ditemukan di wilayah Kabupaten Blitar.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">elder</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">Lansia Terlantar</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Lanjut usia (60 tahun ke atas) tanpa sanak saudara, tidak berdaya memenuhi kebutuhan dasar hidup, atau dalam kondisi penelantaran.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">accessible</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">Penyandang Disabilitas</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Penyandang disabilitas fisik, sensorik, intelektual, maupun ganda yang membutuhkan alat bantu adaptif atau fasilitasi pelatihan kerja.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">ODGJ Terlantar</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Orang dengan gangguan jiwa yang berkeliaran terlantar, korban pasung, atau pasca-rawat inap RSJ yang membutuhkan reintegrasi keluarga.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">child_care</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">Anak yang Butuh Perlindungan</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Anak balita terlantar, anak berhadapan hukum (ABH), anak korban eksploitasi ekonomi, atau yang kehilangan pengasuhan orang tua.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">shield</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">Korban Tindak Kekerasan</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Perempuan dan anak korban kekerasan dalam rumah tangga (KDRT), tindak pidana perdagangan orang (TPPO), atau perlakuan salah lainnya.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-surface-container-lowest border border-outline-variant shadow-sm space-y-3">
                <div class="w-12 h-12 rounded-xl bg-surface-container text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">domain</span>
                </div>
                <h3 class="font-headline text-lg font-bold text-primary">Lembaga Kesejahteraan (LKS)</h3>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Kerja sama pembinaan panti asuhan, yayasan disabilitas, dan panti werdha di Kabupaten Blitar.
                </p>
            </div>

        </div>
    </section>

    <!-- 3. BAGAIMANA PROSESNYA? (6 STEPS TIMELINE) -->
    <section class="bg-surface-container-lowest p-8 sm:p-12 rounded-3xl border border-surface-variant shadow-sm space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-secondary font-bold text-xs uppercase tracking-wider">Tahapan Kasus</span>
            <h2 class="font-headline text-2xl sm:text-3xl font-bold text-primary">Bagaimana Alur Penanganannya?</h2>
            <p class="text-xs sm:text-sm text-on-surface-variant">
                Setiap kasus tercatat dari penerimaan hingga penutupan kasus dengan prinsip perlindungan hak asasi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-bold text-xs flex items-center justify-center">1</div>
                <h4 class="font-headline font-bold text-sm text-primary">Laporan / Permohonan Diterima</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Laporan masuk dari warga, aparat desa, puskesos, atau penjangkauan lapangan petugas.</p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-bold text-xs flex items-center justify-center">2</div>
                <h4 class="font-headline font-bold text-sm text-primary">Assessment oleh Pekerja Sosial</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Pekerja sosial melakukan wawancara, observasi kondisi fisik, psikis, dan kebutuhan mendesak klien.</p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-bold text-xs flex items-center justify-center">3</div>
                <h4 class="font-headline font-bold text-sm text-primary">Rencana Pelayanan</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Penyusunan rekomendasi tindakan: penanganan langsung atau rujukan ke lembaga yang kompeten.</p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-bold text-xs flex items-center justify-center">4</div>
                <h4 class="font-headline font-bold text-sm text-primary">Pelayanan Langsung / Rujukan</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Pemberian bantuan alat bantu, mediasi keluarga, atau rujukan ke panti werdha / RS Jiwa / Sentra Kemensos.</p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary font-bold text-xs flex items-center justify-center">5</div>
                <h4 class="font-headline font-bold text-sm text-primary">Monitoring Berkala</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Pemantauan perkembangan kondisi klien di lembaga rujukan atau lingkungan keluarga binaan.</p>
            </div>

            <div class="p-5 rounded-2xl bg-surface-container-low border border-surface-container-high space-y-2">
                <div class="w-8 h-8 rounded-full bg-tertiary text-on-tertiary font-bold text-xs flex items-center justify-center">6</div>
                <h4 class="font-headline font-bold text-sm text-tertiary">Kasus Selesai (Terminasi)</h4>
                <p class="text-xs text-on-surface-variant leading-relaxed">Hasil penanganan dicatat lengkap dan kasus dinyatakan selesai setelah kemandirian klien tercapai.</p>
            </div>
        </div>
    </section>

    <!-- 4. PRIVACY NOTE ON SENSITIVE DATA -->
    <div class="p-6 rounded-3xl bg-primary-fixed/30 border border-primary-fixed flex items-start gap-4">
        <span class="material-symbols-outlined text-primary text-3xl shrink-0 mt-0.5">verified_user</span>
        <div class="space-y-1 text-xs sm:text-sm text-on-surface leading-relaxed">
            <strong class="font-bold text-primary block">Jaminan Perlindungan Data Sensitif:</strong>
            Sesuai kode etik pekerjaan sosial dan regulasi perlindungan data pribadi, identitas klien rehabilitasi sosial dijaga kerahasiaannya dan hanya dapat diakses oleh pekerja sosial yang ditugaskan serta pejabat berwenang.
        </div>
    </div>

</div>
