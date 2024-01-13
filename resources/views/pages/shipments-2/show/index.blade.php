<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        @vite(['resources/scss/light/plugins/tomSelect/custom-tomSelect.scss'])
        @vite(['resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h6 class="mb-1 fw-bold">{{ $shipment->recipient_name }}</h6>
                            <p class="mb-1">Tujuan : <span>{{ $shipment->destination->name }}</span></p>
                            <p class="mb-1">Nomor Telepon : <span>{{ $shipment->recipient_phone ?? '-' }}</span></p>
                            <p class="mb-1">Alamat : <span>{{ $shipment->recipient_address ?? '-' }}</span></p>
                            <p class="mb-1">Pelabuhan : <span>{{ $shipment->harbor_name ?? '-' }}</span></p>
                            <p class="mb-1">Tanggal Pengiriman : <span>{{ Carbon\Carbon::parse($shipment->departure_date)->translatedFormat('l, j F Y') ?? '-' }}</span></p>
                            <p>Estimasi : <span>{{ Carbon\Carbon::parse($shipment->expected_arrival_date)->translatedFormat('l, j F Y') ?? '-' }}</span></p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">{{ $shipment->shipment_number }}</h6>
                            <p>{{ $shipment->created_at }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <button id="btn-edit-information" class="btn btn-primary btn-sm">Edit Informasi Pengiriman</button>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end mb-3">
                        <button id="btn-create-bale" class="btn btn-secondary btn-sm me-3">Tambah Bal</button>
                        <button id="btn-create-vehicle" class="btn btn-secondary btn-sm">Tambah Kendaraan</button>
                    </div>
                    <div class="row row-cols-1 row-cols-lg-2 g-4">
                        <div class="col">
                            <h6 class="fw-bold">List Bal</h6>
                            <div id="table-bales" class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 72px; min-width: 72px;">#</th>
                                            <th scope="col">Kg Vol</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col" class="text-center" style="width: 120px; min-width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('pages.shipments-2.show._list-bales')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="fw-bold">List Kendaraan</h6>
                            <div id="table-vehicles" class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 72px; min-width: 72px;">#</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col" class="text-center" style="width: 120px; min-width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @include('pages.shipments-2.show._list-vehicles')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">Total Harga</h6>
                            <h4 class="fw-bold text-primary">Rp. {{ number_format($shipment->paymentHeader->total_payment, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pages.shipments-2.show._modal')
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script>
            const apiUrl = @json(config('app.api_url'));
            const shipment = @json($shipment);
            const TRANSACTION = @json($shipment->id);
            const COST = @json($shipment->destination_cost);
        </script>
        <script type="module" src="{{ asset('pages/shipments/js/show.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
