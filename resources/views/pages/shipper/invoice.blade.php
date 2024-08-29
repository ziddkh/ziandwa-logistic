<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>{{ $title }}</title>
  <style media="print">
    @page {
      size: A4 vertical;
      margin: 1cm 0 !important;
    }

    body {
      margin: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      print-color-adjust: exact;
      font-size: 12px !important;
    }

    .pagebreak {
        page-break-inside: avoid;
    }

    .container {
      width: 90%;
      margin: 0 auto;
    }

    h1 {
      font-size: 16px !important;
    }

    p {
      font-size: 12px !important;
    }

    table {
      width: 100%;
    }

    thead {
      display: table-header-group;
    }

    tfoot {
      display: table-footer-group;
    }

    table,
    th,
    td {
      border-collapse: collapse !important;
      border: 1px solid #000 !important;
    }

    th,
    td {
      padding: 8px 12px !important;
      text-align: left !important;
    }

    th {
      background-color: #88a5d1 !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
    }

    .no-border {
      border: 1px solid transparent !important;
    }

    .transparent {
      background-color: #fff !important;
    }
  </style>
  <style media="screen">
    body {
      margin: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      print-color-adjust: exact;
      font-size: 12px !important;
    }

    .container {
      width: 90%;
      margin: 0 auto;
    }

    h1 {
      font-size: 16px !important;
    }

    p {
      font-size: 12px !important;
    }

    table {
      width: 100%;
    }

    thead {
      display: table-header-group;
    }

    tfoot {
      display: table-footer-group;
    }

    table,
    th,
    td {
      border-collapse: collapse !important;
      border: 1px solid #000 !important;
    }

    th,
    td {
      padding: 8px 12px !important;
      text-align: left !important;
    }

    th {
      background-color: #88a5d1 !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
    }

    .no-border {
      border: 1px solid transparent !important;
    }

    .transparent {
      background-color: #fff !important;
    }
  </style>
</head>

<body>
  <div class="container">
    <div
      style="display: flex !important; align-items: center !important; gap: 16px !important; margin-bottom: 40px !important;">
      <div style="width: 80px !important; height: 80px !important;">
        <img class="company-logo" src="{{ asset('logo.png') }}" alt="company"
          style="width: 100% !important; height: 100% !important;">
      </div>
      <div>
        <h1
          style="font-weight: 800 !important; font-size: 24px !important; text-transform: uppercase !important; margin-bottom: 8px !important; margin-top: 0px !important; color: #1c4587 !important;">
          Halton 39 Cargo
        </h1>
        <p style="margin-bottom: 4px !important; margin-top: 0px !important;">Jl. Kebon Kacang 4, Nomor 16, Kelurahan
          Tanah Abang, Kecamatan Tanah Abang, Kota Jakarta Pusat.</p>
        <p style="margin: 0px !important;">Kontak: 082319983738 / 082211604145</p>
      </div>
    </div>
    <div style="display: flex; justify-content: space-between;">
      <div>
        <p><strong>Shipper</strong>: {{ $invoice->name }}</p>
        <p><strong>Destinasi</strong>: {{ $invoice->destination_name }}</p>
        <p><strong>Kapal</strong>: {{ $invoice->ship_name }}</p>
        <p><strong>Pelabuhan</strong>: {{ $invoice->harbor_name }}</p>
      </div>
      <div>
        <p><strong>Nomor Invoice</strong>:
          {{ $invoice->document_number }}</p>
        <p><strong>Pengiriman</strong>:
          {{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->departure_date)->format('d M Y') }}</p>
        <p><strong>Status Pembayaran</strong>: {{ $invoice->payment_status }}</p>
      </div>
    </div>
    {{-- <h1 style="margin: 0 !important;">Manifest Barang Perwakilan</h1> --}}
    <table style="margin: 4mm 0 !important;">
      <thead>
        <tr>
          <th style="text-align: center !important">No</th>
          <th>Nama</th>
          <th>Colly</th>
          <th>Kg Vol</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($invoice->items as $index => $item)
          <tr>
            <td style="text-align: center !important; width: 32px;">{{ $index + 1 }}</td>
            <td>{{ $item->recipient_name ?? '-' }}</td>
            <td>{{ $item->colly }}</td>
            <td>{{ $item->vol_weight }} m3</td>
            <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div style="width: 100% !important; display: flex !important; justify-content: space-between !important; margin-bottom: 24px;">
      <div>
        <p><strong>Transfer Rekening</strong></p>
        <p>Khairuddin Ade</p>
        <p>BCA : 0280226190</p>
        {{-- <p>Doby Mursid</p>
        <p>BNI : 1846309145</p> --}}
      </div>
      <div>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="no-border" style="padding: 4px !important;">Total M3</td>
            <td class="no-border" style="padding: 4px !important;">:
              {{ number_format($invoice->total_vol_weight, 3, ',', '.') }}</td>
          </tr>
          <tr>
            <td class="no-border" style="padding: 4px !important;">Total Colly</td>
            <td class="no-border" style="padding: 4px !important;">:
              {{ number_format($invoice->total_colly, 3, ',', '.') }}</td>
          </tr>
          <tr>
            <td class="no-border" style="padding: 4px !important;">Harga/M3</td>
            <td class="no-border" style="padding: 4px !important;">: Rp.
              {{ number_format($invoice->destination_cost, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td class="no-border" style="padding: 4px !important;">Total Tagihan</td>
            <td class="no-border" style="padding: 4px !important;">: Rp.
              {{ number_format($invoice->remaining_payment_amount, 0, ',', '.') }}</td>
          </tr>
        </table>
      </div>
    </div>
    <div style="width: 100% !important; display: flex !important; justify-content: space-between !important;">
        <div style="flex: 1 1 0% !important"></div>
        <div style="flex: 1 1 0% !important">
            <div style="text-align: end !important;">
                <p>Ini adalah <i>Invoice</i> yang dihasilkan oleh sistem. Tidak diperlukan tanda tangan.</p>
            </div>
        </div>
    </div>
    <div style="margin-top: 12px !important;    ">
        <p style="margin-top: 0 !important;">*Mohon sertakan bukti transfer.</p>
        <p>*Apabila nota ini tidak disanggah sejak penyerahan, nota ini dianggap benar.</p>
    </div>

    <script>
      window.addEventListener('load', function() {
        window.print()
      })
    </script>
</body>

</html>
