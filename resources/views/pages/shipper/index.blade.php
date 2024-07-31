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
                    <a href="{{ route('shipper.create') }}" class="btn btn-sm btn-primary mb-4">Tambah Data Shipper</a>
                </div>
                <div id="shippers-table" class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Shipper</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if (count($shippers) > 0)
                              @foreach ($shippers as $shipper)
                                  <tr>
                                      <td>{{ $shipper->document_number }}</td>
                                      <td>{{ $shipper->name }}</td>
                                      <td>
                                          <div class="action-btns">
                                              <a href="{{ route('shipper.show', $shipper->uuid) }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Detail">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                              </a>
                                              @if (auth()->user()->can('delete-shipper'))
                                                  @if (count($shipper->payments) == 0)
                                                      <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip me-2" data-shipper="{{ $shipper->uuid }}"  data-toggle="tooltip" data-placement="top" title="Hapus">
                                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                      </a>
                                                  @else
                                                      <a href="javascript:void(0);" class="action-btn bs-tooltip me-2"  data-toggle="tooltip" data-placement="top" title="Tidak Bisa Hapus">
                                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                      </a>
                                                  @endif
                                              @endif
                                              {{-- <a href="{{ route('payment.show', $shipper->paymentHeader->uuid) }}" class="action-btn btn-view bs-tooltip" data-toggle="tooltip" data-placement="top" title="Detail Pembayaran">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                              </a> --}}
                                          </div>
                                      </td>
                                  </tr>
                              @endforeach
                          @else
                              <tr>
                                  <td colspan="100" class="text-center">Tidak ada data shipper untuk saat ini, <a href="{{ route('shipper.create') }}" class="text-primary">klik</a> untuk menambah data</td>
                              </tr>
                          @endif
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
        const DELETE_SHIPPER_URL = "{{ route('shipper.destroy', '') }}"
    </script>
    <script type="module" src="{{ asset('pages/shipper/index-shipper.js') }}"></script>
  </x-slot>
  <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
