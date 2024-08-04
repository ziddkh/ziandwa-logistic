<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <h1 style="margin: 0 !important;">Laporan Pengiriman Pelanggan</h1>
    <table style="margin: 4mm 0 !important;">
      <thead>
        <tr>
          <th style="text-align: center !important">#</th>
          <th>Pelanggan</th>
          <th>Alamat</th>
          <th>Tanggal Dikirim</th>
          <th>Tipe Pembayaran</th>
          <th>Status</th>
          <th>Jml Koli</th>
          <th>Kg Vol</th>
          <th>Total</th>
          <th>Total Bayar</th>
          <th>Sisa Bayar</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($shipmentsReports as $transaction)
          <tr>
              <td style="text-align: center !important;">{{ $loop->iteration }}</td>
              <td>{{ $transaction->recipient_name }}</td>
              <td>{{ $transaction->harbor_name }}</td>
              <td>{{ $transaction->departure_date }}</td>
              <td style="text-align: left !important;">{{ $transaction->paymentHeader->payment_method ?? '-' }}</sup></td>
              <td>{{ $transaction->paymentHeader->payment_status ?? '-' }}</td>
              <td style="text-align: right !important;">{{ $transaction->shipmentItems->count() }}</td>
              <td style="text-align: right !important;">{{ $transaction->total_vol_weight }} m<sup>3</sup></td>
              <td style="text-align: right !important;">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
              <td style="text-align: right !important;">Rp. {{ number_format($transaction->paymentHeader->payment_status === 'Lunas' ? $transaction->paymentHeader->total_payment : (!empty($transaction->paymentHeader->payment_method) && $transaction->paymentHeader->payment_method !== 'Bayar Nanti' ? ($transaction->paymentHeader->latestPaymentDetail->invoiceHeader->total_amount ?? 0) : 0), 0, ',', '.') }}</td>
          </tr>
        @endforeach
        <tr>
          <th colspan="6" style="text-align: right !important;">Total :</th>
          @php
              $totalPrice = 0;
              $totalKgVol = 0;
              $totalColly = 0;
              $totalAmount = 0;
          @endphp
          @foreach ($shipmentsReports as $transaction)
            @php
                $totalColly += $transaction->shipmentItems->count();
                $totalKgVol += $transaction->total_vol_weight;
                $totalPrice += $transaction->paymentHeader->total_payment;
                $totalAmount += $transaction->paymentHeader->payment_status === 'Lunas' ? $transaction->paymentHeader->total_payment : ($transaction->paymentHeader->payment_method !== 'Bayar Nanti' ? ($transaction->paymentHeader->latestPaymentDetail->invoiceHeader->total_amount ?? 0) : 0);
            @endphp
          @endforeach
          @php
              $remainingAmount = (int)$totalPrice - (int)$totalAmount;
          @endphp
          <th style="text-align: right !important;">{{ $totalColly }}</th>
          <th style="text-align: right !important;">{{ $totalKgVol }} m<sup>3</sup></th>
          <th style="text-align: right !important;">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</th>
          <th style="text-align: right !important;">Rp. {{ number_format($totalAmount, 0, ',', '.') }}</th>
          <th style="text-align: right !important;">Rp. {{ number_format($remainingAmount, 0, ',', '.') }}</th>
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
