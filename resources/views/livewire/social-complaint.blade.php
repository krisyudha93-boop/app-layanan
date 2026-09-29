<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if ($isSubmitted)
        <!-- SUCCESS STATE -->
        <div class="max-w-3xl mx-auto bg-surface-container-lowest rounded-3xl border border-surface-variant p-8 sm:p-12 shadow-xl text-center space-y-6">
            <div class="w-20 h-20 rounded-full bg-amber-100 text-amber-700 mx-auto flex items-center justify-center ring-8 ring-amber-50">
                <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">campaign</span>
            </div>

            <div class="space-y-2">
                <span class="text-xs font-bold text-amber-800 bg-amber-100 px-3 py-1 rounded-full uppercase tracking-wider">
                    Laporan Pengaduan Diterima
                </span>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                    Terima Kasih atas Kepedulian Anda
                </h1>
                <p class="text-xs sm:text-sm text-on-surface-variant max-w-lg mx-auto leading-relaxed">
                    Laporan Anda telah tercatat dengan nomor registrasi unik di bawah ini dan akan segera diverifikasi oleh tim penanganan Dinsos Kabupaten Blitar.
                </p>
            </div>

            <!-- TICKET BADGE -->
            <div class="bg-surface-container-low p-6 rounded-2xl border-2 border-dashed border-amber-400 max-w-md mx-auto space-y-3">
                <span class="text-xs text-outline font-semibold uppercase tracking-wider">Nomor Laporan / Tiket Pengaduan</span>
                <div class="font-mono text-2xl sm:text-3xl font-extrabold text-primary tracking-wider">
                    {{ $submittedTicket }}
                </div>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <button 
                        type="button" 
                        onclick="navigator.clipboard.writeText('{{ $submittedTicket }}'); alert('Nomor laporan berhasil disalin!');"
                        class="px-4 py-1.5 bg-surface-container text-primary hover:bg-surface-container-high rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors"
                    >
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                        <span>Salin Nomor Laporan</span>
                    </button>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-4">
                <a href="{{ route('lacak', ['tiket' => $submittedTicket]) }}" class="w-full sm:w-auto px-6 py-3.5 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl shadow-md transition-all">
                    Lacak Tindak Lanjut Laporan
                </a>
                <a href="{{ route('home') }}" class="w-full sm:w-auto px-6 py-3.5 border border-outline-variant hover:border-primary text-primary font-bold text-sm rounded-xl transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    @else

        <!-- FORM CONTAINER -->
        <div class="space-y-8">
            <!-- BREADCRUMB & HEADER -->
            <section class="space-y-4">
                <nav aria-label="Breadcrumb" class="flex items-center text-xs text-outline gap-2">
                    <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="text-outline-variant">/</span>
                    <span class="text-primary font-semibold">Pengaduan &amp; Laporan Sosial</span>
                </nav>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-surface-variant pb-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container text-secondary rounded-full text-xs font-semibold mb-2">
                            <span class="material-symbols-outlined text-xs">record_voice_over</span>
                            <span>Kanal Aspirasi &amp; Aduan Sosial Warga</span>
                        </div>
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">
                            Sampaikan Pengaduan atau Laporan Sosial
                        </h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant mt-1 max-w-3xl">
                            Laporkan permasalahan sosial seperti warga terlantar, penyandang disabilitas darurat, ODGJ, atau kendala bansos di lingkungan Kabupaten Blitar.
                        </p>
                    </div>

                    <a href="{{ route('pengajuan.lainnya') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-outline-variant text-xs font-semibold text-primary hover:bg-surface-container transition-colors shrink-0">
                        <span class="material-symbols-outlined text-base">post_add</span>
                        <span>Form Layanan Sosial Lainnya</span>
                    </a>
                </div>
            </section>

            <!-- STEP INDICATOR -->
            <section class="bg-surface-container-lowest p-6 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                <div class="grid grid-cols-3 gap-4">
                    <button type="button" wire:click="goToStep(1)" class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 1 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 1 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 1) <span class="material-symbols-outlined text-sm">check</span> @else 1 @endif
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 1 ? 'text-primary' : ($currentStep > 1 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 1</span>
                            <span class="text-xs font-semibold {{ $currentStep === 1 ? 'text-primary' : 'text-on-surface' }}">Kategori Masalah</span>
                        </div>
                    </button>

                    <button type="button" wire:click="goToStep(2)" class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep > 2 ? 'bg-tertiary text-on-tertiary' : ($currentStep === 2 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline') }}">
                            @if ($currentStep > 2) <span class="material-symbols-outlined text-sm">check</span> @else 2 @endif
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 2 ? 'text-primary' : ($currentStep > 2 ? 'text-tertiary' : 'text-outline') }}">LANGKAH 2</span>
                            <span class="text-xs font-semibold {{ $currentStep === 2 ? 'text-primary' : 'text-on-surface' }}">Lokasi &amp; Uraian</span>
                        </div>
                    </button>

                    <button type="button" wire:click="goToStep(3)" class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shrink-0 shadow-sm {{ $currentStep === 3 ? 'bg-primary text-on-primary ring-4 ring-primary-fixed' : 'bg-surface-container-high text-outline' }}">
                            3
                        </div>
                        <div class="hidden sm:flex flex-col">
                            <span class="text-[11px] font-bold tracking-wider {{ $currentStep === 3 ? 'text-primary' : 'text-outline' }}">LANGKAH 3</span>
                            <span class="text-xs font-semibold {{ $currentStep === 3 ? 'text-primary' : 'text-on-surface' }}">Data Pelapor</span>
                        </div>
                    </button>
                </div>

                <div class="w-full bg-surface-variant h-2 rounded-full overflow-hidden">
                    <div class="bg-primary h-full rounded-full transition-all duration-300" style="width: {{ $currentStep * 33.33 }}%;"></div>
                </div>
            </section>

            <!-- MAIN FORM BODY -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-8 space-y-6">

                    <!-- STEP 1: KATEGORI PENGADUAN -->
                    @if ($currentStep === 1)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Pilih Kategori Permasalahan Sosial</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Klasifikasi yang tepat membantu percepatan disposisi ke unit kerja Dinsos terkait.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($categories as $cat)
                                    <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $complaint_category_id == $cat->id ? 'border-secondary bg-surface-container-low shadow-sm' : 'border-outline-variant hover:border-secondary/50' }}">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $complaint_category_id == $cat->id ? 'bg-secondary text-on-secondary' : 'bg-surface-container text-secondary' }}">
                                                <span class="material-symbols-outlined">
                                                    @if (str_contains(strtolower($cat->name), 'anak')) child_care
                                                    @elseif (str_contains(strtolower($cat->name), 'lansia')) elder
                                                    @elseif (str_contains(strtolower($cat->name), 'disabilitas')) accessible
                                                    @elseif (str_contains(strtolower($cat->name), 'odgj') || str_contains(strtolower($cat->name), 'jiwa')) psychology
                                                    @elseif (str_contains(strtolower($cat->name), 'kekerasan')) security
                                                    @elseif (str_contains(strtolower($cat->name), 'bansos')) handshake
                                                    @else campaign
                                                    @endif
                                                </span>
                                            </div>
                                            <input type="radio" wire:model.live="complaint_category_id" value="{{ $cat->id }}" class="h-5 w-5 text-secondary focus:ring-secondary" />
                                        </div>
                                        <span class="font-headline font-bold text-sm text-primary">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="pt-4 flex justify-end">
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Lanjut ke Lokasi &amp; Uraian</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 2: LOKASI & DESKRIPSI -->
                    @if ($currentStep === 2)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Lokasi Kejadian &amp; Uraian Permasalahan</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Berikan detail tempat dan kronologi agar petugas dapat melakukan penjangkauan.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Kecamatan Lokasi *</label>
                                    <select wire:model.live="district_id" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary">
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($districts as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Desa / Kelurahan Lokasi *</label>
                                    <select wire:model="village_id" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" {{ empty($district_id) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Desa / Kelurahan --</option>
                                        @foreach ($villages as $v)
                                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('village_id') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Detail Lokasi / Patokan</label>
                                    <input wire:model="location_detail" type="text" placeholder="Contoh: Depan pasar Wlingi, dekat gardu ronda RT 03" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                </div>

                                <div class="sm:col-span-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-semibold text-on-surface">Uraian / Deskripsi Permasalahan *</label>
                                        <span class="text-[11px] text-outline">{{ strlen($description) }}/1000 karakter</span>
                                    </div>
                                    <textarea wire:model="description" rows="4" placeholder="Jelaskan kondisi permasalahan sosial yang Anda temui secara rinci..." class="w-full p-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary"></textarea>
                                    @error('description') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Foto Bukti / Situasi Lapangan (Opsional)</label>
                                    <input type="file" wire:model="attachment_file" class="w-full p-2 border border-outline-variant rounded-xl text-xs bg-surface-container-low" accept=".jpg,.jpeg,.png,.pdf" />
                                    <span class="text-[11px] text-outline">Format: JPG, PNG, atau PDF (maks. 5 MB).</span>
                                    @error('attachment_file') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="pt-4 flex items-center justify-between">
                                <button type="button" wire:click="prevStep" class="px-5 py-2.5 border border-outline-variant hover:border-primary text-primary font-semibold text-xs rounded-xl">
                                    Kembali
                                </button>
                                <button type="button" wire:click="nextStep" class="px-6 py-3 bg-primary hover:bg-primary-container text-on-primary font-bold text-sm rounded-xl flex items-center gap-2">
                                    <span>Lanjut ke Data Pelapor</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- STEP 3: DATA PELAPOR -->
                    @if ($currentStep === 3)
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-surface-variant shadow-sm space-y-6">
                            <div class="border-b border-surface-variant pb-4">
                                <h2 class="font-headline text-lg font-bold text-primary">Identitas Pelapor</h2>
                                <p class="text-xs text-on-surface-variant mt-0.5">Identitas pelapor diperlukan untuk konfirmasi dan klarifikasi laporan.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">Nama Pelapor *</label>
                                    <input wire:model="reporter_name" type="text" placeholder="Nama Anda" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                    @error('reporter_name') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-on-surface mb-1">No. WhatsApp / HP Aktif *</label>
                                    <input wire:model="reporter_phone" type="text" placeholder="08xxxxxxxxxx" class="w-full h-11 px-3.5 rounded-xl border border-outline-variant text-sm focus:border-primary" />
                                    @error('reporter_phone') <p class="text-xs text-error mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Consent Statement -->
                            <div class="p-4 bg-primary/5 rounded-xl border border-primary/20 space-y-3">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="agreement" class="rounded text-primary focus:ring-primary h-5 w-5 mt-0.5" />
                                    <span class="text-xs text-on-surface leading-relaxed">
                                        Saya menyatakan laporan ini disampaikan dengan itikad baik dan data yang diberikan dapat dipertanggungjawabkan untuk membantu penanganan masalah sosial.
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
                                    <span wire:loading.remove wire:target="submit">Kirim Laporan Pengaduan</span>
                                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-base animate-spin">refresh</span>
                                        <span>Mengirim...</span>
                                    </span>
                                    <span class="material-symbols-outlined text-base" wire:loading.remove wire:target="submit">send</span>
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Guidelines Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-surface-container-low rounded-2xl p-6 border border-surface-container-high space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-secondary text-on-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">privacy_tip</span>
                        </div>
                        <h4 class="font-headline font-bold text-sm text-primary">Privasi Anda Terjaga</h4>
                        <p class="text-xs text-on-surface-variant leading-relaxed">
                            Data identitas dan nomor kontak Anda dijamin kerahasiaannya dan hanya digunakan oleh petugas Dinsos untuk koordinasi penjangkauan di lokasi.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    @endif

</div>
