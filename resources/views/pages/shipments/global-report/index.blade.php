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
                    <div class="text-left">
                        @if (!!$transaction)
                            <p class="mb-1">Kapal : {{ $transaction->ship_name ?? '-' }}</p>
                            <p class="mb-1">Tanggal Dikirim : <span>{{ $transaction->transaction_details->first()->delivery_date }}</span></p>
                            <p class="mb-1">Dari : Jakarta</span></h6>
                        @else
                            <p class="mb-1">Kapal : -</p>
                            <p class="mb-1">Tanggal Dikirim : -</span></p>
                            <p class="mb-1">Dari : -</span></p>
                        @endif
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Alamat</th>
                                    <th>Jumlah Barang</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments.global-report._list')
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
