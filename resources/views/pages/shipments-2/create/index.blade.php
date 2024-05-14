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
            <form id="form" action="{{ route('shipments-2.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="widget mb-4">
                    <div class="widget-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Penerima</h4>
                            <button id="submit-form-button" type="submit" class="me-3 btn btn-primary">Simpan Pengiriman</button>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <div class="row gy-3 mb-3">
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="departure-date">Tanggal Pengiriman<sup class="text-danger">*</sup></label>
                                    <input type="date" id="departure-date" name="departure_date" class="form-control form-control-sm">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="recipient-name">Nama<sup class="text-danger">*</sup></label>
                                    <input type="text" id="recipient-name" name="recipient_name" class="form-control form-control-sm" placeholder="Nama Penerima">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="recipient-phone">Telepon</label>
                                    <input type="text" id="recipient-phone" name="recipient_phone" class="form-control form-control-sm input-only-phone-number" placeholder="Nomor WA Penerima">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="recipient-address">Alamat<sup class="text-danger">*</sup></label>
                                    <input type="text" id="recipient-address" name="recipient_address" class="form-control form-control-sm" placeholder="Alamat Penerima">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>

                        </div>
                        <div class="row gy-3">
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="harbor-name">Pelabuhan</label>
                                    <input type="text" id="harbor-name" name="harbor_name" class="form-control form-control-sm" placeholder="Nama Pelabuhan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="ship-name">Kapal<sup class="text-danger">*</sup></label>
                                    <input type="text" id="ship-name" name="ship_name" class="form-control form-control-sm" placeholder="Nama Kapal">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="destination-id">Pengiriman Via<sup class="text-danger">*</sup></label>
                                    <input type="text" id="destination-id" name="destination_id">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div id="destination-type-wrapper" class="col-xl-3 col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label for="destination-type">Tipe Pengiriman<sup class="text-danger">*</sup></label>
                                    <select id="destination-type" name="destination_type" placeholder="Pilih Tipe Pengiriman">
                                        <option value="">Pilih Tipe Pengiriman</option>
                                        <option value="normal">Normal</option>
                                        <option value="spesial">Spesial</option>
                                    </select>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div id="cost-wrapper" class="col-xl-3 col-lg-4 col-sm-12" style="display: none">
                                <div class="form-group">
                                    <label for="cost">Harga PerKG Vol<sup class="text-danger">*</sup></label>
                                    <input type="hidden" id="cost" class="form-control form-control-sm input-only-number" name="cost" autocomplete="off">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget mb-4">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-4" style="gap: 4px;">
                            <h5 class="fw-bold truncate">Data Bal</h5>
                        </div>
                        <div class="table-responsive">
                            <table id="table-bales" class="table table-bordered bg-white mb-0">
                                <thead>
                                    <tr>
                                        <th class="rounded-0 fw-bold" style="min-width: 70px !important; width: 70px !important; max-width: 70px !important;">No.</th>
                                        <th class="rounded-0 fw-bold" style="width: 232px; min-width: 150px;">Panjang</th>
                                        <th class="rounded-0 fw-bold" style="width: 232px; min-width: 150px;">Lebar</th>
                                        <th class="rounded-0 fw-bold" style="width: 232px; min-width: 150px;">Tinggi</th>
                                        <th class="rounded-0 fw-bold" style="min-width: 120px;">Volume</th>
                                        <th class="rounded-0 fw-bold" style="min-width: 120px;">Total</th>
                                        <th class="rounded-0 fw-bold text-center" style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="add-bale-button-row">
                                        <td colspan="7" class="text-center">
                                            <button type="button" id="add-bale-button" class="w-100 btn btn-primary">
                                                <span>Tambah Bal</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-4" style="gap: 4px;">
                            <h5 class="fw-bold truncate">Data Kendaraan</h5>
                        </div>
                        <div class="table-responsive">
                            <table id="table-vehicles" class="table table-bordered bg-white mb-0">
                                <thead>
                                    <tr>
                                        <th class="rounded-0 fw-bold" style="min-width: 70px !important; width: 70px !important; max-width: 70px !important;">No.</th>
                                        <th class="rounded-0 fw-bold" style="width: 250px; min-width: 200px;">Deskripsi</th>
                                        <th class="rounded-0 fw-bold" style="width: 250px; min-width: 200px;">Harga</th>
                                        <th class="rounded-0 fw-bold text-center" style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="add-vehicle-button-row">
                                        <td colspan="4" class="text-center">
                                            <button type="button" id="add-vehicle-button" class="w-100 btn btn-primary">
                                                <span>Tambah Kendaraan</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script>
            const baseUrl = @json(config('app.base_url'));
            const apiUrl = @json(config('app.api_url'));
            const GET_DESTINATIONS = `${apiUrl}/destinations`;
            const CREATE_SHIPMENT_URL = `{{ route('shipments-2.store') }}`;
        </script>
        <script type="module" src="{{ asset('pages/shipments/js/create.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
