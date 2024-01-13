<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('pages/payments/scss/index.css') }}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        @vite(['resources/scss/light/assets/elements/custom-pagination.scss', 'resources/scss/dark/assets/elements/custom-pagination.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget" style="margin-bottom: 20px;">
                <div class="widget-content widget-content-area p-0">
                    <div style="padding: 20px;">
                        <h4 class="mb-2 fw-bold truncate">Cari Pembayaran</h4>
                        <h6 class="mb-0 truncate" style="color: #888ea8;">Cek pembayaran dengan kode pengiriman</h6>
                        <hr>
                        <form id="form-search-payment">
                            <div class="d-flex align-items-start" style="gap: 8px;">
                                <div class="input-find-shipment-wrapper">
                                    <div class="d-flex align-items-center mb-1" style="position: relative;">
                                        <input type="search" name="search" class="form-control form-control-sm" placeholder="Masukkan Kode Pengiriman. Cth: 2023" style="padding-left: 42px;">
                                        <svg style="position: absolute; left: 16px;" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    </div>
                                    <small class="text-muted truncate">TSL/SHP/YYYYMMDD/<span class="text-primary">KODE</span></small>
                                </div>
                                <button id="btn-search" type="submit" class="btn btn-primary" style="min-width: fit-content;">Cari</button>
                            </div>
                        </form>
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
            $('#form-search-payment').on('submit', async function (e) {
                e.preventDefault();
                let search = $('input[name="search"]').val();
                await axios.get(`/api/payments/${search}`)
                    .then((response) => {
                        window.location.href = response.data.redirect_url
                    })
                    .catch((error) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Maaf',
                            text: 'Data Pengiriman tidak ditemukan!',
                        })
                        $('input[name="search"]').val('');
                        console.log(error);
                    })
            })
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
