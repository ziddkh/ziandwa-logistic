<x-base-layout :scrollspy="false">

  <x-slot:pageTitle>
    {{ $title }}
  </x-slot>

  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <x-slot:headerFiles>
    <!--  BEGIN CUSTOM STYLE FILE  -->
    @vite(['resources/scss/light/assets/components/modal.scss', 'resources/scss/dark/assets/components/modal.scss'])
    @vite(['resources/scss/light/assets/apps/invoice-preview.scss'])
    @vite(['resources/scss/dark/assets/apps/invoice-preview.scss'])
    <link rel="stylesheet" href="{{ asset('pages/payments/scss/index.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
    @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
    @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
    @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
    <!--  END CUSTOM STYLE FILE  -->
  </x-slot>
  <!-- END GLOBAL MANDATORY STYLES -->

  <div class="row invoice layout-top-spacing layout-spacing">

    <!-- CONTENT HERE -->
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      <div class="doc-container">
        <div class="row">
          <div class="col-xl-9">
            <div class="invoice-container">
              <div class="invoice-inbox">
                <div id="ct" class="">
                  <div class="invoice-00001">
                    <div class="content-section">
                      <div class="inv--head-section inv--detail-section">
                        <div class="row">
                          <div class="col-sm-6 col-12 mr-auto">
                            <div class="d-flex">
                              <img class="company-logo" src="{{ asset('logo.png') }}" alt="company">
                            </div>
                            <h5 class=" fw-bold mt-3 mb-1">Halton 39 Cargo</h5>
                            <p class="inv-email-address fw-normal">082319983738 / 082211604145</p>
                            <p class="inv-email-address fw-normal">Jl. Kebon Kacang 4, Nomor 16, Kelurahan Tanah Abang,
                              Kecamatan Tanah Abang, Kota Jakarta Pusat.</p>
                          </div>
                          <div class="col-sm-6 text-sm-end">
                            <p class="inv-list-number mt-sm-3 pb-sm-2 mt-4"><span class="inv-title">Invoice : </span>
                              <span class="inv-number">{{ $invoiceHeader->invoice_number }}</span>
                            </p>
                            @switch($invoiceHeader->paymentDetail->payment_status)
                              @case("Pending")
                                <p class="badge badge-light-danger">Belum Dibayar</p>
                                @break
                              @case("Sudah Dibayar")
                                <p class="badge badge-light-success">Sudah Dibayar</p>
                                @break
                            @endswitch
                            <p class="inv-created-date mt-sm-5 mt-3"><span class="inv-title">Tanggal Terbit : </span>
                              <span class="inv-date">{{ $invoiceHeader->created_at_formatted }}</span>
                            </p>
                            <p class="inv-created-date mt-1"><span class="inv-title">Nama Pelabuhan : </span> <span
                                class="inv-date">{{ !!$invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->harbor_name ? $invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->harbor_name : '-' }}</span>
                            </p>
                            <p class="inv-created-date mt-1"><span class="inv-title">Tanggal Pengiriman : </span> <span
                                class="inv-date">{{ !!$invoiceHeader->departure_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $invoiceHeader->departure_date)->format('d M Y') : '-' }}</span>
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="inv--detail-section inv--customer-detail-section">
                        <div class="row">
                          <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                            <p class="inv-to">Kepada</p>
                          </div>
                          <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                            <p class="inv-customer-name">
                              {{ $invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->recipient_name }}</p>
                            <p class="inv-street-addr">
                              {{ $invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->recipient_address }}</p>
                            <p class="inv-email-address">
                              {{ $invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->recipient_phone }}</p>
                          </div>
                        </div>

                      </div>
                      <div class="inv--product-table-section">
                        @php
                            $totalVolWeight = 0;
                            $totalColly = $invoiceHeader->invoiceItems->count();
                        @endphp
                        @if (count($invoiceHeader->baleItems) > 0)
                            <div class="table-responsive mb-3">
                            <table class="table">
                                <thead class="">
                                <tr>
                                    <th scope="col" class="text-center">No.</th>
                                    <th scope="col" class="text-start" style="width: 200px; min-width: 200px;">Nama Kapal
                                    </th>
                                    <th scope="col" class="text-center">Panjang</th>
                                    <th scope="col" class="text-center">Lebar</th>
                                    <th scope="col" class="text-center">Tinggi</th>
                                    <th scope="col" class="text-center">M3</th>
                                    <th scope="col" class="text-center" style="width: 220px; min-width: 220px;">Total
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoiceHeader->baleItems as $item)
                                    @php
                                        $totalVolWeight += $item->vol_weight;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start" style="width: 200px; min-width: 200px;">
                                        {{ $item->ship_name }}</td>
                                        <td class="text-center">{{ $item->length }}</td>
                                        <td class="text-center">{{ $item->width }}</td>
                                        <td class="text-center">{{ $item->height }}</td>
                                        <td class="text-center">{{ $item->vol_weight }}</td>
                                        <td class="text-center" style="width: 220px; min-width: 220px;">Rp.
                                        {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        @endif
                        @if (count($invoiceHeader->vehicleItems) > 0)
                            <div class="table-responsive">
                            <table class="table">
                                <thead class="">
                                <tr>
                                    <th scope="col" class="text-center">No.</th>
                                    <th scope="col" class="text-start" style="width: 200px; min-width: 200px;">Nama Kapal
                                    </th>
                                    <th scope="col" class="text-start">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 220px; min-width: 220px;">Total
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($invoiceHeader->vehicleItems as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start" style="width: 200px; min-width: 200px;">
                                        {{ $item->ship_name }}</td>
                                        <td class="text-start">{{ $item->description }}</td>
                                        <td class="text-center" style="width: 220px; min-width: 220px;">Rp.
                                        {{ number_format($item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                        @endif
                      </div>
                      <div class="inv--total-amounts">
                        <div class="row mt-4" style="margin-bottom: 60px">
                          <div class="col-sm-5 col-12 order-sm-0 order-1">
                            <div class="text-sm-start">
                              <div class="row">
                                <div class="col-12">
                                  <div class="mb-2">Transfer Rekening :</div>
                                  <p class="mb-1">Doby Mursid</p>
                                  <p class="mb-2">BNI : 1846309145</p>
                                  <p class="mb-1">Khairuddin Ade</p>
                                  <p class="">BCA : 0280226190</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-7 col-12 order-sm-1 order-0">
                            <div class="text-sm-end">
                              <div class="row">
                                <div class="col-sm-8 col-7">
                                  <p class="">Jml Koli :</p>
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">{{ $totalColly }}</p>
                                </div>
                                <div class="col-sm-8 col-7">
                                  <p class="">Jml M3 :</p>
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">{{ $totalVolWeight }} m<sup>3</sup></p>
                                </div>
                                <div class="col-sm-8 col-7">
                                  <p class="">Harga Per Kubik :</p>
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">Rp.
                                    {{ number_format($invoiceHeader->paymentDetail->paymentHeader->shipmentHeader->destination_cost, 0, ',', '.') }}
                                  </p>
                                </div>
                                @if ($invoiceHeader->paymentDetail->paymentHeader->payment_method === 'DP')
                                    <div class="col-sm-8 col-7">
                                        <p class=" discount-rate">Total Harga :</p>
                                    </div>
                                    <div class="col-sm-4 col-5">
                                        <p class=" discount-rate">Rp. {{ number_format($invoiceHeader->paymentDetail->paymentHeader->total_payment, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                                <div class="col-sm-8 col-7">
                                    @if ($invoiceHeader->paymentDetail->paymentHeader->payment_method === 'DP')
                                    <p class=" discount-rate">DP :</p>
                                    @else
                                    <p class=" discount-rate">Subtotal :</p>
                                    @endif
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">Rp. {{ number_format($invoiceHeader->total_amount, 0, ',', '.') }}
                                  </p>
                                </div>
                                <div class="col-sm-8 col-7">
                                  <p class=" discount-rate">Diskon :</p>
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">Rp.
                                    {{ number_format($invoiceHeader->paymentDetail->paymentHeader->discount, 0, ',', '.') }}
                                  </p>
                                </div>
                                {{-- <div class="col-sm-8 col-7">
                                  <p class=" discount-rate">Total :</p>
                                </div>
                                <div class="col-sm-4 col-5">
                                  <p class="">Rp. {{ number_format($invoiceHeader->total_amount, 0, ',', '.') }}
                                  </p>
                                </div> --}}
                                <div class="col-sm-8 col-7 grand-total-title mt-3">
                                  <h4 class="text-dark">Total Pembayaran : </h4>
                                </div>
                                <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                  <h4 class="text-dark">Rp.
                                    {{ number_format($invoiceHeader->total_amount, 0, ',', '.') }}</h4>
                                </div>
                                @if ($invoiceHeader->paymentDetail->paymentHeader->payment_method === 'DP')
                                  <div class="col-sm-8 col-7 grand-total-title mt-3">
                                    <h4 class="text-dark">Sisa Pembayaran : </h4>
                                  </div>
                                  <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                    <h4 class="text-dark">
                                      Rp.{{ number_format($invoiceHeader->paymentDetail->paymentHeader->grand_total_payment - $invoiceHeader->total_amount, 0, ',', '.') }}
                                    </h4>
                                  </div>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <p>Ini adalah <i>Invoice</i> yang dihasilkan oleh sistem. Tidak diperlukan tanda tangan.</p>
                          </div>
                        </div>
                      </div>
                      <div class="inv--note">
                        <div class="row mt-4">
                          <div class="col-sm-12 col-12 order-sm-0 order-1">
                            <p class="fw-normal">*Mohon sertakan bukti transfer.</p>
                            <p class="fw-normal">*Apabila nota ini tidak disanggah sejak penyerahan, nota ini dianggap benar.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3">
            <div class="invoice-actions-btn">
              <div class="invoice-action-btn">
                <div class="row">
                  <div class="col-xl-12 col-md-3 col-sm-6">
                    <a href="javascript:void(0);"
                      class="btn btn-primary btn-send _effect--ripple waves-effect waves-light">Send Invoice</a>
                  </div>
                  <div class="col-xl-12 col-md-3 col-sm-6">
                    <a href="javascript:void(0);"
                      class="btn btn-secondary btn-print action-print _effect--ripple waves-effect waves-light">Print</a>
                  </div>
                  <div class="col-xl-12 col-md-3 col-sm-6">
                    <a href="javascript:void(0);"
                      class="btn btn-success btn-download _effect--ripple waves-effect waves-light">Download</a>
                  </div>
                  <div class="col-xl-12 col-md-3 col-sm-6">
                    <a href="./app-invoice-edit.html"
                      class="btn btn-dark btn-edit _effect--ripple waves-effect waves-light">Edit</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--  BEGIN CUSTOM SCRIPTS FILE  -->
  <x-slot:footerFiles>
    @vite(['resources/assets/js/apps/invoice-preview.js'])
    <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
    <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
  </x-slot>
  <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
