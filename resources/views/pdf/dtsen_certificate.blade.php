<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan DTSEN - {{ $certificate->certificate_number }}</title>
    <style>
        @page {
            margin: 1.5cm 2cm 2cm 2cm;
            size: a4 portrait;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 13pt;
            text-transform: uppercase;
            font-weight: normal;
            letter-spacing: 1px;
        }
        .header h2 {
            margin: 0;
            font-size: 15pt;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 9.5pt;
            font-style: italic;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h4 {
            margin: 0;
            font-size: 12.5pt;
            text-decoration: underline;
            text-transform: uppercase;
            font-weight: bold;
        }
        .title p {
            margin: 2px 0 0 0;
            font-size: 11pt;
        }
        .content {
            text-align: justify;
        }
        table.data {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }
        table.data td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 11.5pt;
        }
        table.data td.label {
            width: 28%;
        }
        table.data td.colon {
            width: 3%;
            text-align: center;
        }
        table.data td.value {
            width: 69%;
        }
        .badge-box {
            border: 1px solid #333;
            background-color: #f7f7f7;
            padding: 8px 12px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .footer-table {
            width: 100%;
            margin-top: 30px;
        }
        .footer-table td {
            vertical-align: top;
        }
        .qr-section {
            width: 40%;
            font-size: 8.5pt;
            color: #333;
            line-height: 1.2;
        }
        .qr-section img {
            width: 95px;
            height: 95px;
            margin-bottom: 4px;
        }
        .sign-section {
            width: 60%;
            text-align: center;
            font-size: 11.5pt;
        }
        .signature-space {
            height: 70px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="header">
        <h3>Pemerintah Kabupaten Blitar</h3>
        <h2>Dinas Sosial</h2>
        <p>Jl. Veteran No. 12, Kepanjenkidul, Blitar, Jawa Timur 66117<br>
        Telepon: (0342) 801234 | Email: dinsos@blitarkab.go.id | Website: sapa.blitarkab.go.id</p>
    </div>

    <!-- JUDUL SURAT -->
    <div class="title">
        <h4>Surat Keterangan Terdaftar DTSEN</h4>
        <p>Nomor: {{ $certificate->certificate_number ?? '400.9/' . $request->request_number . '/DINSOS/2026' }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Dinas Sosial Kabupaten Blitar, dengan ini menerangkan bahwa:</p>

        <table class="data">
            <tr>
                <td class="label">Nama Pemohon</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ strtoupper($request->applicant_name) }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIK Pemohon</td>
                <td class="colon">:</td>
                <td class="value">{{ $request->applicant_nik }}</td>
            </tr>
            <tr>
                <td class="label">No. Kartu Keluarga</td>
                <td class="colon">:</td>
                <td class="value">{{ $request->family_card_number }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Domisili</td>
                <td class="colon">:</td>
                <td class="value">{{ $request->address }}, Desa/Kel. {{ $request->village?->name }}, Kec. {{ $request->village?->district?->name }}</td>
            </tr>
            @if($certificate->subject_name && $certificate->subject_name !== $request->applicant_name)
            <tr>
                <td class="label">Nama Yang Diterangkan</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ strtoupper($certificate->subject_name) }}</strong> (Hubungan: {{ $certificate->relationship_to_applicant ?? 'Anak/Keluarga' }})</td>
            </tr>
            <tr>
                <td class="label">NIK Yang Diterangkan</td>
                <td class="colon">:</td>
                <td class="value">{{ $certificate->subject_nik }}</td>
            </tr>
            @endif
        </table>

        <p>Berdasarkan hasil penelusuran data pada Sistem Informasi Kesejahteraan Sosial Next Generation (SIKS-NG) per tanggal {{ $certificate->checked_at ? \Carbon\Carbon::parse($certificate->checked_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}, yang bersangkutan dinyatakan:</p>

        <div class="badge-box">
            <table class="data" style="margin: 0;">
                <tr>
                    <td style="width: 32%; font-weight: bold;">Status Kepesertaan</td>
                    <td style="width: 3%;">:</td>
                    <td style="width: 65%; color: #047857; font-weight: bold;">TERDAFTAR DALAM DTSEN</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Peringkat Desil</td>
                    <td>:</td>
                    <td><strong style="font-size: 13pt;">DESIL {{ $certificate->decile ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Tujuan Penggunaan</td>
                    <td>:</td>
                    <td>{{ $certificate->purpose?->name ?? 'Keperluan Administrasi Sosial' }} {{ $certificate->purpose_description ? '('.$certificate->purpose_description.')' : '' }}</td>
                </tr>
                @if($certificate->valid_until)
                <tr>
                    <td style="font-weight: bold;">Masa Berlaku</td>
                    <td>:</td>
                    <td>Sampai dengan {{ \Carbon\Carbon::parse($certificate->valid_until)->translatedFormat('d F Y') }}</td>
                </tr>
                @endif
            </table>
        </div>

        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya sesuai tujuan yang diajukan.</p>
    </div>

    <!-- TANDA TANGAN & QR CODE -->
    <table class="footer-table">
        <tr>
            <td class="qr-section">
                <img src="{{ $qrCode }}" alt="QR Code Verifikasi"><br>
                <strong>KODE VERIFIKASI RESMI:</strong><br>
                <span style="font-family: monospace; font-size: 10pt; font-weight: bold;">{{ $certificate->verification_code }}</span><br>
                Dokumen ini sah dan diterbitkan secara digital oleh Sistem SAPA SOSIAL Dinas Sosial Kabupaten Blitar.<br>
                Pindai QR Code untuk memastikan keaslian dokumen.
            </td>
            <td class="sign-section">
                Blitar, {{ $certificate->issued_at ? \Carbon\Carbon::parse($certificate->issued_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}<br>
                <strong>Kepala Dinas Sosial Kabupaten Blitar</strong>
                <div class="signature-space"></div>
                <strong><u>Dr. Bambang Setiawan, M.M.</u></strong><br>
                Pembina Utama Muda<br>
                NIP. 19680211 199303 1 006
            </td>
        </tr>
    </table>

</body>
</html>
