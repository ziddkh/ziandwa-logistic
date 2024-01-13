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
                    <form action="{{ route('shipment-report.index') }}" method="GET">
                        <div class="row row-cols-4 mb-4">
                            <div class="col">
                                <div class="form-group mb-0">
                                    <label for="departure-date">Tanggal Pengiriman</label>
                                    <input type="date" class="form-control form-control-sm" id="departure-date" name="departure_date" value="{{ old('departure_date') }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mb-4" type="submit">Cari</button>
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

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
