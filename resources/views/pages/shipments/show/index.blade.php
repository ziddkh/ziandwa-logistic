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
                            <h6 class="mb-1 fw-bold">{{ $transaction->customer->name }}</h6>
                            <p class="mb-1">Tujuan : <span>{{ $transaction->destination_location->name }}</span></p>
                            <p class="mb-1">Nomor Telepon : <span>{{ $transaction->customer->phone_number ?? '-' }}</span></p>
                            <p>Alamat : <span>{{ $transaction->customer->delivery_address ?? '-' }}</span></p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">{{ $transaction->code }}</h6>
                            <p>{{ $transaction->created_at }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end mb-3">
                        <button id="btn-create" class="btn btn-primary btn-sm">Tambah Paket</button>
                    </div>
                    <div id="table-packages" class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal Dikirim</th>
                                    <th scope="col">Kg Vol</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments.show._list')
                                <tr id="row-total">
                                    <td colspan="2" class="text-end fw-bold">Total</td>
                                    @php
                                        $totalPrice = 0;
                                        $totalKgVol = 0;
                                    @endphp
                                    @foreach ($transaction->transaction_details as $transaction_detail)
                                        @php
                                            $totalPrice += $transaction_detail->price;
                                            $totalKgVol += $transaction_detail->kg_volume;
                                        @endphp
                                    @endforeach
                                    <td class="fw-bold">{{ $totalKgVol }} m<sup>3</sup></td>
                                    <td class="fw-bold">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="action-modal" tabindex="-1" role="dialog" aria-labelledby="action-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="action-modal-label"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <form id="action-form" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="delivery-date">Tanggal Pengiriman</label>
                            <input type="date" id="delivery-date" name="delivery_date" class="form-control form-control-sm">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="length">Panjang</label>
                            <input type="text" id="length" name="length" class="form-control form-control-sm input-only-number">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="width">Lebar</label>
                            <input type="text" id="width" name="width" class="form-control form-control-sm input-only-number">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="height">Tinggi</label>
                            <input type="text" id="height" name="height" class="form-control form-control-sm input-only-number">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div>
                            <p class="mb-1">Volume: <span id="kg-volume">0.000</span>m<sup>3</sup></p>
                            <h4 class="fw-bold text-primary">Rp. <span id="price">0</span></h4>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancel" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                        <button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script>
            const GET_TRANSACTION_DETAIL_URL = "/api/transaction-details";
            const TRANSACTION = @json($transaction->id);
            const COST = @json($transaction->transaction_details[0]->cost);
        </script>
        <script type="module" src="{{ asset('pages/shipments/js/show.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
