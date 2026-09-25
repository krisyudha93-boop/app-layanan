<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi Reaktivasi PBI-JK - {{ $pbi->recommendation_number }}</title>
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
            width: 32%;
        }
        table.data td.colon {
            width: 3%;
            text-align: center;
        }
        table.data td.value {
            width: 65%;
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
            width: 90px;
            height: 90px;
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

    <div class="header">
        <h3>Pemerintah Kabupaten Blitar</h3>
        <h2>Dinas Sosial</h2>
        <p>Jl. Veteran No. 12, Kepanjenkidul, Blitar, Jawa Timur 66117<br>
        Telepon: (0342) 801234 | Email: dinsos@blitarkab.go.id</p>
    </div>

    <div class="title">
        <h4>Surat Rekomendasi Reaktivasi JKN-KIS / PBI-JK</h4>
        <p>Nomor: {{ $pbi->recommendation_number ?? '460/' . $request->request_number . '/REK-PBI/2026' }}</p>
    </div>

    <div class="content">
        <p>Berdasarkan permohonan yang diajukan oleh pemohon dan hasil verifikasi data kelayakan pada Dinas Sosial Kabupaten Blitar, dengan ini memberikan rekomendasi reaktivasi kepesertaan Program JKN-KIS Penerima Bantuan Iuran Jaminan Kesehatan (PBI-JK) kepada:</p>

        <table class="data">
            <tr>
                <td class="label">Nama Peserta</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ strtoupper($pbi->participant_name) }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIK Peserta</td>
                <td class="colon">:</td>
                <td class="value">{{ $pbi->participant_nik }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Kartu BPJS / KIS</td>
                <td class="colon">:</td>
                <td class="value"><strong>{{ $pbi->bpjs_card_number }}</strong></td>
            </tr>
            <tr>
                <td class="label">Alamat Domisili</td>
                <td class="colon">:</td>
                <td class="value">{{ $request->address }}, Desa/Kel. {{ $request->village?->name }}, Kec. {{ $request->village?->district?->name }}</td>
            </tr>
            <tr>
                <td class="label">Alasan Reaktivasi</td>
                <td class="colon">:</td>
                <td class="value">{{ $pbi->reason?->label() ?? 'Kondisi Medis / Mendesak' }}</td>
            </tr>
            @if($pbi->health_facility_name)
            <tr>
                <td class="label">Fasilitas Kesehatan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pbi->health_facility_name }} (No. Surat: {{ $pbi->health_letter_number ?? '-' }})</td>
            </tr>
            @endif
            <tr>
                <td class="label">Hasil Verifikasi Kelayakan</td>
                <td class="colon">:</td>
                <td class="value">{{ $pbi->eligibility_notes ?? 'Memenuhi kriteria untuk diusulkan reaktivasi PBI-JK ke Kementerian Sosial RI.' }}</td>
            </tr>
        </table>

        <p>Demikian rekomendasi ini diberikan untuk dipergunakan sebagai bahan pertimbangan pengusulan reaktivasi data kepesertaan melalui SIKS-NG ke Kementerian Sosial Republik Indonesia.</p>
    </div>

    <table class="footer-table">
        <tr>
            <td class="qr-section">
                <img src="{{ $qrCode }}" alt="QR Code"><br>
                <strong>TIKET LAYANAN:</strong><br>
                <span style="font-family: monospace; font-size: 10pt; font-weight: bold;">{{ $request->request_number }}</span><br>
                Surat rekomendasi resmi Dinas Sosial Kab. Blitar.
            </td>
            <td class="sign-section">
                Blitar, {{ $pbi->recommendation_issued_at ? \Carbon\Carbon::parse($pbi->recommendation_issued_at)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}<br>
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
