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
      size: A4 landscape;
      margin: 1cm 0 !important;
    }

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
    <h1 style="margin: 0 !important;">Manifest Barang Perwakilan</h1>
    <table style="margin: 4mm 0 !important;">
      <thead>
        <tr>
          <th style="text-align: center !important">No</th>
          <th>Tanggal Pengiriman</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Nama Kapal</th>
          <th>Nama Pelabuhan</th>
          <th>Koli</th>
          <th>Nomor Kontainer</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        @php
          $totalColly = 0;
        @endphp
        @foreach ($shipmentsReports as $item)
          @php
            $totalColly += $item->total_colly;
          @endphp
          <tr>
            <td style="text-align: center !important">{{ $loop->iteration }}</td>
            <td>{{ $item->departure_date ?? '-' }}</td>
            <td>{{ $item->recipient_name ?? '-' }}</td>
            <td>{{ $item->recepient_address ?? '-' }}</td>
            <td>{{ $item->shipmentItems->first()->ship_name ?? '-' }}</td>
            <td>{{ $item->harbor_name ?? '-' }}</td>
            <td>{{ $item->total_colly ?? '0' }}</td>
            <td></td>
            <td>{{ $item->remarks ?? '' }}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="4" class="no-border" style="border-right: 1px solid #000 !important;"></td>
          <th colspan="4" style="font-weight: 900; text-align: right !important;">Total Koli :</th>
          <th style="text-align: center !important; ">{{ $totalColly }} Koli</th>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    window.addEventListener('load', function() {
      window.print()
    })
  </script>
</body>

</html>
