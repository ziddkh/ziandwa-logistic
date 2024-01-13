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
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Tanggal Dikirim</th>
                                    <th>Kg Vol</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments.report._list')
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    @php
                                        $totalPrice = 0;
                                        $totalKgVol = 0;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        @foreach ($transaction->transaction_details as $transaction_detail)
                                            @php
                                                $totalPrice += $transaction_detail->price;
                                                $totalKgVol += $transaction_detail->kg_volume;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                    <td class="fw-bold">{{ $totalKgVol }} m<sup>3</sup></td>
                                    <td class="fw-bold">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</td>
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
