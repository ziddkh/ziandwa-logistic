<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget">
                <div class="widget-content widget-content-area">
                    <div>
                        <a href="{{ route('shipments-2.create') }}" class="btn btn-sm btn-primary mb-4">Tambah Pengiriman</a>
                    </div>
                    <div class="mb-4">
                        <form action="{{ route('shipments-2.index') }}" method="GET">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 mb-3">
                                <div class="form-group">
                                    <label for="name-search" class="form-label">Nama</label>
                                    <input type="text" id="name-search" class="form-control form-control-sm" value="{{ $request['name'] ?? '' }}" name="name" placeholder="Cari Nama...">
                                </div>
                                <div class="form-group">
                                    <label for="departure-date-search" class="form-label">Tanggal Pengiriman</label>
                                    <input type="date" id="departure-date-search" class="form-control form-control-sm" value="{{ $request['departure_date'] ?? '' }}" name="departure_date">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-address-search" class="form-label">Alamat</label>
                                    <input type="text" id="recipient-address-search" class="form-control form-control-sm" value="{{ $request['recipient_address'] ?? '' }}" name="recipient_address">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-full d-block">Cari</button>
                        </form>
                    </div>
                    <div id="shipments-table" class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments-2._list')
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
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script>
            const SHIPMENT_DELETE_URL = "/api/shipment-headers"
        </script>
        <script type="module" src="{{ asset('pages/shipments/js/index.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
