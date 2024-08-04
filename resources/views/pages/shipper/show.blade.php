<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/tomSelect/tom-select.default.min.css') }}">
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
                            <h6 class="mb-1 fw-bold">{{ $shipper->name }}</h6>
                            <p class="mb-1">Tujuan : <span>{{ $shipper->destination_name }}</span></p>
                            <p class="mb-1">Tipe Pengiriman : <span>{{ $shipper->destination_type ?? '-' }}</span></p>
                            <p class="mb-1">Kapal : <span>{{ $shipper->ship_name ?? '-' }}</span></p>
                            <p class="mb-1">Pelabuhan : <span>{{ $shipper->harbor_name ?? '-' }}</span></p>
                            <p class="mb-1">Tanggal Pengiriman :
                                <span>{{ Carbon\Carbon::parse($shipper->departure_date)->translatedFormat('l, j F Y') ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">{{ $shipper->document_number }}</h6>
                            <p>{{ $shipper->created_at->locale('id')->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        @if (auth()->user()->can('edit-shipment'))
                            <button id="btn-edit-information" class="btn btn-primary btn-sm">Edit Informasi
                                Pengiriman</button>
                        @endif
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end mb-3">
                        @if (auth()->user()->can('edit-shipment'))
                            <button id="btn-create-item" class="btn btn-secondary btn-sm me-3">Tambah Item</button>
                        @endif
                    </div>
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <h6 class="fw-bold">List Data</h6>
                            <div id="table-items" class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 72px; min-width: 72px;">#</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Colly</th>
                                            <th scope="col">Kg Vol</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col" class="text-center"
                                                style="width: 120px; min-width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shipper->items as $item)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                    <input id="identifier" type="hidden" value="{{ $item->uuid }}">
                                                </td>
                                                <td>{{ $item->recipient_name }}</td>
                                                <td>{{ $item->colly }}</td>
                                                <td>{{ $item->vol_weight }} m<sup>3</sup></td>
                                                <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if (auth()->user()->can('edit-shipper'))
                                                        <div class="action-btns mx-auto" style="width: fit-content;">
                                                            <a href="javascript:void(0)"
                                                                class="action-btn btn-edit bs-tooltip me-2"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-edit-2">
                                                                    <path
                                                                        d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                            <a href="javascript:void(0);"
                                                                class="action-btn btn-delete bs-tooltip"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Hapus">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash-2">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                    <line x1="10" y1="11" x2="10"
                                                                        y2="17"></line>
                                                                    <line x1="14" y1="11" x2="14"
                                                                        y2="17"></line>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">Total Harga</h6>
                            <h4 class="fw-bold text-primary">Rp.
                                {{ number_format($shipper->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="widget">
                <div class="widget-content widget-content-area">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-start">
                            <h6 class="mb-1 fw-bold">Pembayaran</h6>
                        </div>
                        <div class="text-end">
                            @if (auth()->user()->can('create-shipper-payment'))
                                <button id="btn-add-payment" class="btn btn-primary btn-sm">Tambah Pembayaran</button>
                            @endif
                        </div>
                    </div>
                    <div class="row row-cols-1 g-4">
                        <div class="col">
                            <div id="table-items" class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 72px; min-width: 72px;">#</th>
                                            <th scope="col">Tipe Pembayaran</th>
                                            <th scope="col">Status Pembayaran</th>
                                            <th scope="col">Total Bayar</th>
                                            <th scope="col">Sisa Bayar</th>
                                            <th scope="col" class="text-center"
                                                style="width: 120px; min-width: 120px;">Aksi</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($shipper->payments as $payment)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                    <input id="identifier" type="hidden" value="{{ $payment->id }}">
                                                </td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ $payment->payment_status }}</td>
                                                <td>Rp. {{ number_format($payment->payment_amount, 0, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($payment->remaining_payment_amount, 0, ',', '.') }}</td>
                                                <td>
                                                    @if (auth()->user()->can('view-shipper-invoice') || auth()->user()->can('approve-shipper-payment'))
                                                        <div class="action-btns mx-auto" style="width: fit-content;">
                                                            @if (auth()->user()->can('approve-shipper-payment') && $payment->payment_status !== "Lunas")
                                                                <a href="{{ route('shipper-payment.approve', str_replace('/', '-', $payment->payment_number)) }}" class="btn-approve-shipper-payment action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Konfirmasi Pembayaran">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                                                </a>
                                                            @endif
                                                            @if (auth()->user()->can('view-shipper-invoice'))
                                                                <a href="{{ route('shipper.show-invoice', ['uuid' => $shipper->uuid, 'invoice_number' => str_replace('/', '-', $payment->invoice->document_number)]) }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Detail">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Belum ada pembayaran</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <div class="text-end">
                            <h6 class="mb-1 fw-bold text-primary">Total Harga</h6>
                            <h4 class="fw-bold text-primary">Rp.
                                {{ number_format($shipper->total_price, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.shipper._show-shipper-information-modal')
    @include('pages.shipper._add-payment-modal')

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
        <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script>
            // const apiUrl = @json(config('app.api_url'));
            const shipper = @json($shipper);
            // const TRANSACTION = @json($shipper->id);
            // const COST = @json($shipper->destination_cost);
        </script>
        <script type="module" src="{{ asset('pages/shipper/show-shipper.js') }}"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
