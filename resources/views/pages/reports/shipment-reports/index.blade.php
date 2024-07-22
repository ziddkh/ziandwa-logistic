<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget">
                <div class="widget-content widget-content-area">
                    <h4 class="mb-2 fw-bold truncate">Filter Laporan</h4>
                    <hr>
                    <form id="filter-form" action="{{ route('shipment-report.index') }}" method="GET">
                        <div class="row row-cols-4 mb-4">
                            <div class="col">
                                <div class="form-group mb-0">
                                    <label for="departure-date">Tanggal Pengiriman</label>
                                    <input type="date" class="form-control form-control-sm" id="departure-date" name="departure_date" value="{{ $request['departure_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-0">
                                    <label for="recipient-address">Alamat</label>
                                    <input type="search" class="form-control form-control-sm" id="recipient-address" name="recipient_address" value="{{ $request['recipient_address'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mb-4" type="submit">Cari</button>
                        <button class="btn btn-warning mb-4" type="button" id="export-button">Export</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal Dikirim</th>
                                    <th>Jml Koli</th>
                                    <th>Kg Vol</th>
                                    <th>Harga</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.reports.shipment-reports._list')
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    @php
                                        $totalPrice = 0;
                                        $totalKgVol = 0;
                                        $totalColly = 0;
                                    @endphp
                                    @foreach ($shipmentsReports as $transaction)
                                        @php
                                            $totalColly += $transaction->shipmentItems->count();
                                            $totalKgVol += $transaction->total_vol_weight;
                                            $totalPrice += $transaction->paymentHeader->total_payment;
                                        @endphp

                                    @endforeach
                                    <td class="fw-bold">{{ $totalColly }}</td>
                                    <td class="fw-bold">{{ $totalKgVol }} m<sup>3</sup></td>
                                    <td class="fw-bold" colspan="2">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
      <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
      <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
      <script>
          $('#export-button').on('click', (e) => {
              e.preventDefault()
              const form = $('#filter-form')
              const url = `{{ route('api.report.export.shipments') }}?${form.serialize()}`
              window.open(url)
          })
      </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
