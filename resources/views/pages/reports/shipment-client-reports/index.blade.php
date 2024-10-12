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
                    <form id="filter-form" action="{{ route('shipment-client-report') }}" method="GET">
                        <div class="row row-cols-4 mb-4">
                            <div class="col">
                                <div class="form-group mb-0">
                                    <label for="departure-date">Tanggal Pengiriman</label>
                                    <input type="date" class="form-control form-control-sm" id="departure-date" name="departure_date" value="{{ $request['departure_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-0">
                                    <label for="recipient-names">Nama</label>
                                    <input type="search" class="form-control form-control-sm" id="recipient-names" name="recipient_names" value="{{ $request['recipient_names'] ?? '' }}">
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
                    <div class="text-left">
                        @if (!!$shipmentsReports)
                            {{-- <p class="mb-1">Tanggal Dikirim : <span>{{ date('Y-m-d') }}</span></p> --}}
                            <p class="mb-1">Dari : Jakarta</span></h6>
                        @else
                            {{-- <p class="mb-1">Tanggal Dikirim : -</span></p> --}}
                            <p class="mb-1">Dari : -</span></p>
                        @endif
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Nama Kapal</th>
                                    <th>Nama Pelabuhan</th>
                                    <th>Kg Vol</th>
                                    <th>Jumlah Koli</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            @if (count($shipmentsReports) > 0)
                            <tbody>
                                    @php
                                        $totalPrice = 0;
                                        $totalKgVol = 0;
                                        $totalColly = 0;
                                    @endphp
                                    @foreach ($shipmentsReports as $shipment)
                                    @php
                                        $totalColly += $shipment->shipmentItems->count();
                                        $totalKgVol += $shipment->total_vol_weight;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $shipment->departure_date }}</td>
                                        <td>{{ $shipment->recipient_name }}</td>
                                        <td>{{ $shipment->recipient_address }}</td>
                                        <td>{{ !!$shipment->shipmentItems->first() ? $shipment->shipmentItems->first()->ship_name : '-' }}</td>
                                        <td>{{ !!$shipment->harbor_name ? $shipment->harbor_name : '-' }}</td>
                                        <td>{{ $shipment->total_vol_weight }} m<sup>3</sup></td>
                                        <td>{{ count($shipment->shipmentItems) }}</td>
                                        <td>{{ $shipment->remarks ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold">{{ $totalKgVol }} m<sup>3</sup></td>
                                        <td class="fw-bold">{{ $totalColly }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada pengiriman hari ini</td>
                                    </tr>
                                </tbody>
                            @endif
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
                const url = `{{ route('api.report.export.shipment-clients') }}?${form.serialize()}`
                window.open(url)
            })
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
