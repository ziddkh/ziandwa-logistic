<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss', 'resources/scss/dark/assets/components/modal.scss'])
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
                <div class="widget-content widget-content-area">
                    <div class="d-flex mb-3" style="gap: 8px;">
                        <h4 class="mb-0 fw-bold truncate">{{ $payment->payment_number }}</h4>
                        @switch(strtolower($payment->payment_status))
                        @case('belum dibayar')
                        <span class="badge badge-light-danger">{{ $payment->payment_status }}</span>
                        @break
                        @case('belum lunas')
                        <span class="badge badge-light-warning">{{ $payment->payment_status }}</span>
                        @break
                        @case('lunas')
                        <span class="badge badge-light-success">{{ $payment->payment_status }}</span>
                        @break
                        @endswitch
                    </div>
                    <table>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Kode Pengiriman</td>
                            <td class="py-1 text-dark">: {{ $payment->shipmentHeader->shipment_number }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Nama Penerima</td>
                            <td class="py-1 text-dark">: {{ $payment->shipmentHeader->recipient_name }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Nomor Penerima</td>
                            <td class="py-1 text-dark">: {{ $payment->shipmentHeader->recipient_phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Alamat Penerima</td>
                            <td class="py-1 text-dark">: {{ $payment->shipmentHeader->recipient_address }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Nama Kapal</td>
                            <td class="py-1 text-dark">: {{ $payment->shipmentHeader->shipmentItems[0]->ship_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Tanggal Kirim</td>
                            <td class="py-1 text-dark">: {{ Carbon\Carbon::parse($payment->shipmentHeader->departure_date)->translatedFormat('l, j F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 fw-bold text-dark" style="min-width: 160px;">Tanggal Sampai</td>
                            <td class="py-1 text-dark">: {{ Carbon\Carbon::parse($payment->shipmentHeader->expected_arrival_date)->translatedFormat('l, j F Y') }}</td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered bg-white mb-0">
                                    <thead>
                                        <tr>
                                            <th class="rounded-0 fw-bold text-center">Kg Vol</th>
                                            <th class="rounded-0 fw-bold text-center">Harga/M3</th>
                                            <th class="rounded-0 fw-bold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($payment->shipmentHeader->shipmentItems as $item)
                                                @if ($item->type === 'bale')
                                                    <tr>
                                                        <td class="text-center">{{ $item->vol_weight }}</td>
                                                        <td class="text-center">Rp. {{ number_format($payment->shipmentHeader->destination_cost, 0, ',', '.') }}</td>
                                                        <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-bordered bg-white mb-0">
                                    <thead>
                                        <tr>
                                            <th class="rounded-0 fw-bold text-center">Deskripsi</th>
                                            <th class="rounded-0 fw-bold text-center">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($payment->shipmentHeader->shipmentItems as $item)
                                                @if ($item->type === 'vehicle')
                                                    <tr>
                                                        <td class="text-center">{{ $item->description }}</td>
                                                        <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="d-flex justify-content-end">
                            <h6 class="mb-1 fw-bold text-primary">Subtotal :</h6>
                            <h6 class="fw-bold text-end" style="width: 200px;">Rp. {{ number_format($payment->total_payment, '0', ',', '.') }}</h6>
                        </div>
                        <div class="d-flex justify-content-end">
                            <h6 class="mb-1 fw-bold text-primary">Diskon :</h6>
                            <h6 class="fw-bold text-end" style="width: 200px;">Rp. {{ number_format($payment->discount, '0', ',', '.') }}</h6>
                        </div>
                        <div class="d-flex justify-content-end">
                            <h6 class="mb-1 fw-bold text-primary">Total :</h6>
                            <h4 class="fw-bold text-primary text-end" style="width: 200px;">Rp. {{ number_format($payment->grand_total_payment, '0', ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-content widget-content-area">
                    <div class="d-flex flex-column flex-sm-row justify-content-between mb-4" style="gap: 4px;">
                        <h5 class="fw-bold truncate">Riwayat Pembayaran</h5>
                        @if ($payment->payment_status !== 'Lunas' && auth()->user()->can('resolve-payment'))
                            <button id="btn-create-payment" class="btn btn-primary order-1 order-lg-2" style="width: fit-content;">Tambah Pembayaran</button>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="table-invoices" class="table table-bordered bg-white mb-0">
                            <thead>
                                <tr>
                                    <th class="rounded-0 fw-bold">Kode Invoice</th>
                                    <th class="rounded-0 fw-bold text-center">Tipe Pembayaran</th>
                                    <th class="rounded-0 fw-bold text-center">Status Pembayaran</th>
                                    <th class="rounded-0 fw-bold text-center">Total Pembayaran</th>
                                    <th class="rounded-0 fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($payment->paymentDetails) > 0)
                                    @foreach ($payment->paymentDetails as $paymentDetail)
                                        <tr>
                                            <td>{{ $paymentDetail->invoiceHeader->invoice_number }}</td>
                                            <td class="text-center">{{ $payment->payment_method }}</td>
                                            <td class="text-center">
                                                @switch($paymentDetail->payment_status)
                                                @case("Pending")
                                                        <span class="badge badge-light-warning">{{ $paymentDetail->payment_status }}</span>
                                                    @break
                                                    @case("Sudah Dibayar")
                                                        <span class="badge badge-light-success">{{ $paymentDetail->payment_status }}</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td class="text-center">Rp. {{ !!$payment->payment_amount ? number_format($payment->payment_amount, 0, ',', '.') : '0' }}</td>
                                            <td>
                                                <div class="action-btns d-flex justify-content-center" style="gap: 16px;">
                                                    <a href="{{ route('invoice.show', $paymentDetail->invoiceHeader->uuid) }}" class="action-btn btn-view bs-tooltip" data-toggle="tooltip" data-placement="top" title="Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                    </a>
                                                    @if ($paymentDetail->payment_status === 'Pending' && auth()->user()->can('resolve-payment'))
                                                        <a href="javascript:void(0);" class="action-btn btn-view bs-tooltip btn-confirmation-payment" data-url="{{ route('payment.confirmation-payment', $paymentDetail->uuid) }}" data-toggle="tooltip" data-placement="top" title="Konfirmasi Pembayaran">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="rounded-0 text-center">Belum ada riwayat pembayaran!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('pages.payments.detail._modal')
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>

        <script>
            const btnCreatePayment = $('#btn-create-payment')
            const modalCreatePayment = $('#create-payment-modal')
            const paymentMethod = $('#payment-method')
            const paymentAmount = $('#payment-amount')
            btnCreatePayment.on('click', function() {
                modalCreatePayment.modal('show')
            })

            paymentMethod.on('change', function () {
                if ($(this).val() === 'DP') {
                    paymentAmount.parent().show()
                } else {
                    paymentAmount.val(null)
                    paymentAmount.parent().hide()
                }
            })

            $('.input-price').on('input', function (e) {
                const value = $(this).val();
                const numericValue = value.replace(/[^0-9,]/g, '');
                const cleanedValue = numericValue.replace(/,+/g, ',');
                const parts = cleanedValue.split(',');
                if (parts.length > 2) {
                    const integerPart = parts.shift();
                    const decimalPart = parts.join('');
                    $(this).val(integerPart + ',' + decimalPart);
                } else {
                    $(this).val(cleanedValue);
                }
                const formattedValue = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(formattedValue);
            })

            modalCreatePayment.on('hidden.bs.modal', function () {
                paymentMethod.val(null).trigger('change')
                paymentAmount.parent().hide()
                paymentAmount.val(null)
            })
        </script>

        <script>
            const tableInvoices = $('#table-invoices')
            const btnConfirmationPayment = $('#btn-confirmation-payment')
            const modalConfirmationPayment = $('#confirmation-payment-modal')
            const formConfirmationPayment = $('#confirmation-payment-form')

            tableInvoices.on('click', '.btn-confirmation-payment', function () {
                const url = $(this).data('url')
                formConfirmationPayment.attr('action', url)
                modalConfirmationPayment.modal('show')
            })

            modalConfirmationPayment.on('hidden.bs.modal', function () {
                formConfirmationPayment.attr('action', null)
            })
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
