<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
        @vite(['resources/scss/light/plugins/tomSelect/custom-tomSelect.scss'])
        @vite(['resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <form id="form" autocomplete="off">
                @csrf
                <div class="widget mb-4">
                    <div class="widget-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Customer</h4>
                            <button id="submit-form-button" type="submit" class="me-3 btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row gy-3 mb-3">
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="delivery-date">Tanggal Pengiriman<sup class="text-danger">*</sup></label>
                                    <input type="date" id="delivery-date" name="delivery_date" class="form-control form-control-sm">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="name">Nama<sup class="text-danger">*</sup></label>
                                    <input type="text" id="name" name="name" placeholder="Cari Customer">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="phone-number">Telepon</label>
                                    <input type="text" id="phone-number" name="phone_number" class="form-control form-control-sm input-only-phone-number">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="delivery-address">Daerah</label>
                                    <input type="text" id="delivery-address" name="delivery_address" class="form-control form-control-sm">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row gy-3">
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="ship-name">Nama Kapal<sup class="text-danger">*</sup></label>
                                    <input type="text" id="ship-name" name="ship_name" class="form-control form-control-sm">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="destination-location-id">Pengiriman Via<sup class="text-danger">*</sup></label>
                                    <input type="text" id="destination-location-id" name="destination_location_id" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div id="destination-type-wrapper" class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="destination-type">Tipe Pengiriman<sup class="text-danger">*</sup></label>
                                    <select id="destination-type" placeholder="Pilih Tipe Pengiriman" name="destination_type">
                                        <option value="">Pilih Tipe Pengiriman</option>
                                        <option value="normal">Normal</option>
                                        <option value="spesial">Spesial</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="items-wrapper"></div>
            </form>
            <button type="button" id="add-item-button" class="mx-auto  btn btn-primary d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                <span class="ms-2">Tambah Barang</span>
            </button>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script>
            const GET_CUSTOMERS_URL = "{{ route('api.customers.getCustomers') }}";
            const GET_CUSTOMER_URL = "{{ route('api.customers.getCustomer') }}";
            const GET_DESTINATION_LOCATIONS = "{{ route('api.destination-locations.getDestinationLocations') }}"
            const GET_DESTINATION_LOCATION = "{{ route('api.destination-locations.getDestinationLocation') }}"
            const CREATE_SHIPMENT_URL = "{{ route('shipments.store') }}";
        </script>
        <script type="module" src="{{ asset('pages/shipments/js/create.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
