# SAPA SOSIAL — Kumpulan Prompt Stitch (Portal Publik)

Gabungan seluruh prompt per halaman. Jalankan **Prompt 0** lebih dulu, lalu Prompt 1–9 di project Stitch yang sama agar gaya visual konsisten. Hasilkan versi Mobile dan Desktop.

## Daftar Isi

- [Prompt Stitch 0 — Beranda + Design System](#prompt-stitch-0--beranda--design-system)
- [Prompt Stitch 1 — Daftar & Detail Informasi Layanan](#prompt-stitch-1--daftar--detail-informasi-layanan)
- [Prompt Stitch 2 — Form Pengajuan Surat Keterangan DTSEN](#prompt-stitch-2--form-pengajuan-surat-keterangan-dtsen)
- [Prompt Stitch 3 — Form Reaktivasi KIS/PBI-JK](#prompt-stitch-3--form-reaktivasi-kispbi-jk)
- [Prompt Stitch 4 — Form Pengaduan & Pengajuan Layanan Lainnya](#prompt-stitch-4--form-pengaduan--pengajuan-layanan-lainnya)
- [Prompt Stitch 5 — Cek Status Tiket](#prompt-stitch-5--cek-status-tiket)
- [Prompt Stitch 6 — Verifikasi Keaslian SK DTSEN](#prompt-stitch-6--verifikasi-keaslian-sk-dtsen)
- [Prompt Stitch 7 — Akun Masyarakat](#prompt-stitch-7--akun-masyarakat)
- [Prompt Stitch 8 — Halaman Layanan Rehabilitasi Sosial](#prompt-stitch-8--halaman-layanan-rehabilitasi-sosial)
- [Prompt Stitch 9 — Informasi, FAQ & Unduh Formulir](#prompt-stitch-9--informasi-faq--unduh-formulir)

---

## Prompt Stitch 0 — Beranda + Design System

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan prompt ini lebih dulu; prompt lain memakai design system yang sama.

```
Design a mobile-first responsive public web portal homepage for "SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar", a government social-services portal run by Dinas Sosial Kabupaten Blitar (East Java, Indonesia). All UI text must be in Indonesian.

PURPOSE: One-stop portal where citizens apply for social services, file complaints, and track their request using a ticket number. Users are ordinary citizens (many older, many on low-end phones), village/sub-district operators helping them, and no login is required to browse.

VISUAL STYLE:
- Trustworthy, warm, modern government look. Clean, calm, lots of white space. Not corporate-cold, not childish.
- Primary color: deep teal-blue (#0F5C7A). Accent: warm amber (#F5A623) for main CTAs. Background: soft off-white (#F7FAFB). Success green, warning amber, error red for status.
- Typography: friendly humanist sans-serif (e.g. Plus Jakarta Sans or Inter). Large readable body text (min 16px), high contrast (WCAG AA), large touch targets (min 48px), rounded corners (12–16px), subtle shadows.
- Use simple line icons; light illustrations of families, elderly, children, and community (no stock-photo clichés).

HOMEPAGE SECTIONS (top to bottom):
1. Top navbar: logo placeholder + "SAPA SOSIAL / Dinas Sosial Kab. Blitar", menu: Beranda, Layanan, Pengaduan, Cek Status, Informasi & FAQ, and buttons "Masuk" and "Daftar". Collapses to hamburger on mobile.
2. Hero: headline "Satu Pintu Layanan Sosial Kabupaten Blitar", subtext "Ajukan layanan, sampaikan pengaduan, dan pantau prosesnya dengan nomor tiket — dari mana saja.", two primary buttons "Ajukan Layanan" and "Sampaikan Pengaduan". Beside/below it, a prominent "Cek Status Tiket" card with an input for ticket number (placeholder "Contoh: DTSEN-202610-00012") and a button "Lacak".
3. "Layanan Utama" — 3 large priority cards:
   • Surat Keterangan DTSEN (for SPMB, PIP, KIP Kuliah, bansos)
   • Reaktivasi KIS/PBI-JK (with small badge "Darurat medis diprioritaskan")
   • Pelayanan Rehabilitasi Sosial (lansia, disabilitas, ODGJ, anak, korban kekerasan).
   Each card: icon, one-line description, "Lihat Persyaratan" and "Ajukan" buttons. Below, a smaller row: "Layanan Sosial Lainnya" and "Pengaduan & Laporan Sosial".
4. "Cara Kerja" — 4-step horizontal stepper: Pilih Layanan → Isi Formulir & Unggah Berkas → Dapat Nomor Tiket → Pantau Status Online.
5. "Cek Keaslian Surat" — small banner explaining that SK DTSEN can be verified via QR/verification code, with a button "Verifikasi Surat".
6. "Informasi Terbaru & Pertanyaan Umum" — search bar ("Cari informasi layanan…") plus 4 popular FAQ accordions and 3 info cards.
7. "Butuh Bantuan?" — contact strip: alamat kantor, jam layanan (Senin–Jumat 08.00–15.30), telepon, and a note that residents can also get help at kantor kecamatan/desa/Puskesos.
8. Footer: Dinas Sosial Kabupaten Blitar, quick links, privacy note "Data pribadi Anda dilindungi dan hanya digunakan untuk keperluan layanan."

Generate both a mobile (390px) and desktop (1440px) version.
```

---

## Prompt Stitch 1 — Daftar & Detail Informasi Layanan

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design two screens for the SAPA SOSIAL public portal, in Indonesian:

SCREEN A — "Informasi Layanan" listing page:
- Page title, breadcrumb, and a large search bar "Cari layanan, persyaratan, atau formulir…" with popular keyword chips (DTSEN, PBI, Rehabilitasi, Pengaduan, Disabilitas, Lansia).
- Filter chips by category: Semua, Surat Keterangan, Kesehatan (KIS/PBI), Rehabilitasi Sosial, Disabilitas, Lansia, Pengaduan.
- Grid of service/information cards (icon, title, short description, category tag, "Lihat Detail"). Show the 3 priority services first with a "Prioritas" label.
- Empty-state design for "tidak ada hasil" with suggestion to contact the office.

SCREEN B — "Detail Layanan" page for "Surat Keterangan DTSEN":
- Header with title, category tag, last-updated date ("Diperbarui 12 Sep 2026").
- Sticky action box (right on desktop, bottom bar on mobile): primary button "Ajukan Sekarang", secondary "Unduh Formulir".
- Tabbed or sectioned content: Deskripsi, Persyaratan (checklist: KTP, KK), Alur Pelayanan (vertical numbered steps), Waktu & Lokasi Layanan, Kontak, Formulir Unduhan (file name, version, "Versi terbaru" badge, download button), FAQ accordion.
- A short highlighted note: "Surat hanya dapat diterbitkan jika desil DTSEN sesuai ketentuan tujuan penggunaan."
Generate mobile and desktop versions.
```

---

## Prompt Stitch 2 — Form Pengajuan Surat Keterangan DTSEN

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design a multi-step application form (wizard) for "Ajukan Surat Keterangan DTSEN" on the SAPA SOSIAL public portal, in Indonesian. Mobile-first.

Progress indicator with 4 steps: 1 Tujuan → 2 Data Pemohon → 3 Unggah Berkas → 4 Tinjau & Kirim.

Step 1 – Tujuan Penggunaan: selectable large option cards (radio): SPMB Jalur Afirmasi, PIP, KIP Kuliah, Bantuan Sosial, Layanan Kesehatan, Lainnya (with a text field for "Keterangan tujuan"). Show a small info note: "Persyaratan minimal: KTP dan KK."

Step 2 – Data: two grouped sections:
 • "Data Pemohon": Nama Lengkap, NIK (16 digit), No. KK (16 digit), Alamat, Kecamatan (dropdown) → Desa/Kelurahan (dependent dropdown), No. HP/WhatsApp.
 • "Data Orang yang Diterangkan" (e.g. anak/calon siswa): Nama, NIK, Hubungan dengan pemohon (dropdown), with a checkbox "Sama dengan pemohon".

Step 3 – Unggah Berkas: two upload dropzones "Foto/Scan KTP" and "Foto/Scan KK" with file preview, size/format hint (JPG/PNG/PDF, maks. 5 MB), remove/replace controls, upload progress and error states.

Step 4 – Tinjau & Kirim: read-only summary cards with "Ubah" links, a consent checkbox "Saya menyatakan data yang diisi benar", and a big "Kirim Pengajuan" button.

Also include: inline validation examples (NIK must be 16 digits), a sticky bottom navigation bar on mobile (Kembali / Lanjut), and a success screen: "Pengajuan Berhasil Dikirim" with the ticket number in a large copyable badge (DTSEN-202610-00012), short explanation of the next steps, buttons "Salin Nomor Tiket", "Lacak Status", "Kembali ke Beranda", and a note to save the ticket number.
Generate mobile and desktop versions.
```

---

## Prompt Stitch 3 — Form Reaktivasi KIS/PBI-JK

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design a multi-step application form for "Reaktivasi KIS / PBI-JK" on the SAPA SOSIAL public portal, in Indonesian. Mobile-first, wizard style with 4 steps: Data Peserta → Alasan Reaktivasi → Unggah Berkas → Tinjau & Kirim.

- Data Peserta: Nama & NIK peserta, No. KK, Nomor Kartu BPJS/KIS, Perkiraan tanggal nonaktif (date picker), alamat, Kecamatan → Desa/Kelurahan, data pemohon (nama, No. HP/WhatsApp) with checkbox "Pemohon sama dengan peserta".
- Alasan Reaktivasi: selectable cards — Penyakit kronis/katastropik, Kondisi darurat medis, Bayi baru lahir dari ibu peserta PBI, Lainnya. When "Darurat medis" is selected, show an amber badge "Pengajuan akan diprioritaskan".
- Unggah Berkas: KTP, KK, Kartu BPJS/KIS, and "Surat Keterangan dari Fasilitas Kesehatan" — the last one is marked "Wajib untuk alasan medis" and additionally asks Nama Faskes and Nomor Surat.
- Tinjau & Kirim + success screen with ticket number (PBI-202610-00007) and a short preview of what happens next: Verifikasi → Surat Rekomendasi → Diusulkan ke Kemensos → Aktif Kembali di BPJS.
Include validation and upload error states. Generate mobile and desktop versions.
```

---

## Prompt Stitch 4 — Form Pengaduan & Pengajuan Layanan Lainnya

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design two form screens for the SAPA SOSIAL public portal, in Indonesian, mobile-first:

SCREEN A — "Sampaikan Pengaduan Sosial":
- Short friendly intro: "Laporkan permasalahan sosial di lingkungan Anda. Laporan Anda akan diverifikasi dan ditindaklanjuti petugas."
- Step 1: choose a complaint category (icon cards: Anak Terlantar, Lansia Terlantar, Penyandang Disabilitas, ODGJ Terlantar, Korban Kekerasan, Kemiskinan/Bantuan Sosial, Lainnya).
- Step 2: Lokasi Kejadian (Kecamatan → Desa/Kelurahan required, detail alamat optional), Deskripsi Permasalahan (textarea with character counter), Unggah Foto/Dokumen (optional, drag-and-drop with thumbnails).
- Step 3: Data Pelapor: Nama, No. HP (required), with a privacy note.
- Submit button "Kirim Laporan" and success screen with ticket ADU-202610-00004, next steps, and "Lacak Laporan" button.

SCREEN B — "Pengajuan Layanan Sosial Lainnya":
- Dropdown/cards to choose service type; once chosen, the page dynamically shows the requirement checklist for that service and matching upload fields. Show an example with "Rekomendasi Bantuan".
- Applicant data fields (Nama, NIK, No. KK, alamat, Kecamatan/Desa, No. HP) and a submit button.
Generate mobile and desktop versions.
```

---

## Prompt Stitch 5 — Cek Status Tiket

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design the "Cek Status Tiket" (ticket tracking) page for the SAPA SOSIAL public portal, in Indonesian. Mobile-first.

STATE 1 – Search: centered card with two inputs: "Nomor Tiket" (e.g. DTSEN-202610-00012) and "4 Digit Terakhir NIK atau No. HP" for verification, plus a "Cek Status" button and a hint on where to find the ticket number. Include an error state ("Tiket tidak ditemukan atau data verifikasi tidak sesuai").

STATE 2 – Result for a PBI-JK reactivation ticket (PBI-202610-00007):
- Summary card: ticket number, service name, submitted date, current status badge, responsible unit, and a "Prioritas – Darurat Medis" badge. Applicant name partially masked (e.g. "Siti A*** R***") and NIK masked — no sensitive data shown.
- A vertical timeline of stages with the current stage highlighted, completed stages checked, and future stages greyed out: Diajukan → Pemeriksaan Berkas → Verifikasi Kelayakan → Menunggu Persetujuan → Surat Rekomendasi Terbit → Diusulkan ke Kemensos → Disetujui Kemensos → Aktif Kembali di BPJS → Selesai. Each completed step shows date/time and a short note.
- An alert card variant for "Perlu Perbaikan" status: shows the officer's note and a button "Perbaiki Data/Dokumen".
- A final-result card variant for status "Surat Terbit" with "Unduh Surat" button, and a variant for "Ditolak" with the reason and follow-up guidance.
- Buttons: "Salin Nomor Tiket", "Hubungi Petugas".
Show the states as separate screens, mobile and desktop.
```

---

## Prompt Stitch 6 — Verifikasi Keaslian SK DTSEN

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design the public "Verifikasi Keaslian Surat" page for the SAPA SOSIAL portal, in Indonesian. This page opens when someone scans the QR code on a Surat Keterangan DTSEN or types the verification code.

Screens:
1. Input state: title "Cek Keaslian Surat Keterangan DTSEN", input for "Kode Verifikasi" and button "Verifikasi", plus a note "Anda juga dapat memindai QR pada surat".
2. VALID result: a large green shield/check header "Surat Asli dan Masih Berlaku", details card: Nomor Surat (400.9/123/409.XX/2026), Nama yang diterangkan (partially masked), Tujuan penggunaan (SPMB), Tanggal terbit, Berlaku hingga, Diterbitkan oleh Dinas Sosial Kabupaten Blitar, Penandatangan (Kepala Dinas).
3. EXPIRED result: amber state "Surat Sudah Kedaluwarsa" with the expiry date.
4. NOT FOUND result: red state "Kode Verifikasi Tidak Ditemukan" with advice to contact Dinas Sosial and a warning that the letter may be invalid.
Keep it simple, official, and highly legible. Mobile and desktop versions.
```

---

## Prompt Stitch 7 — Akun Masyarakat

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design the citizen account area of the SAPA SOSIAL public portal, in Indonesian. Mobile-first.

SCREENS:
1. "Masuk" and "Daftar" (one screen with tabs or two screens): fields for NIK, Nama Lengkap, No. HP/WhatsApp, Kata Sandi; "Lupa kata sandi?" link; friendly note "Akun memudahkan Anda mengajukan layanan dan memantau semua tiket di satu tempat." Also show a link "Lanjut tanpa akun → Cek Status Tiket".
2. Dashboard "Pengajuan Saya": greeting, quick action buttons (Ajukan Layanan, Sampaikan Pengaduan), and a list of the citizen's tickets as cards. Each card: ticket number, service name, submitted date, color-coded status badge (Diajukan, Perlu Perbaikan, Dalam Proses, Selesai, Ditolak), and a "Lihat Detail" button. Include tabs "Semua / Dalam Proses / Selesai", a "Perlu Tindakan" highlighted card when the officer requested revision, and an empty state for no tickets.
3. "Profil Saya": basic profile data and change password; NIK shown masked.
Generate mobile and desktop versions.
```

---

## Prompt Stitch 8 — Halaman Layanan Rehabilitasi Sosial

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design the "Pelayanan Rehabilitasi Sosial" service page for the SAPA SOSIAL public portal, in Indonesian. Mobile-first. This is an information page (rehabilitation cases are handled by officers, not self-filled by citizens), so its main actions are to request service or report a case.

SECTIONS:
1. Hero: title "Pelayanan Rehabilitasi Sosial", a warm supportive subtitle "Pendampingan bagi warga yang membutuhkan pemulihan dan perlindungan sosial", buttons "Ajukan Permohonan" and "Laporkan Kasus Sosial".
2. "Siapa yang Dapat Dilayani?" — icon cards: Lansia Terlantar, Penyandang Disabilitas, ODGJ Terlantar, Anak yang Membutuhkan Perlindungan, Korban Tindak Kekerasan.
3. "Bagaimana Prosesnya?" — vertical or horizontal stepper: Laporan/Permohonan Diterima → Assessment oleh Petugas → Rencana Pelayanan → Pelayanan Langsung atau Rujukan ke Lembaga → Monitoring → Kasus Selesai.
4. "Persyaratan & Dokumen" checklist, "Waktu & Lokasi Layanan", and "Kontak Petugas".
5. A calm, respectful privacy notice: "Identitas klien adalah data sensitif dan dijaga kerahasiaannya."
6. FAQ accordion (3–4 items) and a bottom CTA card "Butuh bantuan segera? Hubungi kantor Dinas Sosial atau Puskesos terdekat."
Tone: empathetic, respectful, not pitying. Generate mobile and desktop versions.
```

---

## Prompt Stitch 9 — Informasi, FAQ & Unduh Formulir

Proyek: SAPA SOSIAL — Portal Publik Dinas Sosial Kabupaten Blitar

Jalankan di project Stitch yang sama dengan Prompt 0 agar gaya konsisten.

```
Using the same design system, design the "Informasi & FAQ" page for the SAPA SOSIAL public portal, in Indonesian. Mobile-first.

SECTIONS:
1. Page header with a large search bar "Cari informasi, persyaratan, atau formulir…" and a row of popular keyword chips.
2. Tabs: Semua, Program Sosial, Rehabilitasi Sosial, Disabilitas, Lansia, Pengaduan.
3. "Informasi Paling Sering Diakses": 3 highlighted cards with title, short excerpt, category tag, and "Baca Selengkapnya".
4. "Unduh Formulir": a clean list/table of downloadable forms with file name, "Versi terbaru" badge, updated date, file size, and a "Unduh" button.
5. "Pertanyaan Umum (FAQ)": grouped accordions by service (DTSEN, PBI-JK, Rehabilitasi, Pengaduan), e.g. "Berapa lama proses Surat Keterangan DTSEN?", "Apa yang harus dilakukan jika kepesertaan KIS saya nonaktif?".
6. Search-results state showing matching pages with highlighted keywords, plus a "tidak ditemukan" empty state with contact info.
7. Bottom CTA: "Tidak menemukan jawaban? Ajukan layanan atau hubungi petugas."
Generate mobile and desktop versions.
```
