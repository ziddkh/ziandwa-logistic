<x-base-layout :scrollspy="false">
  <x-slot:pageTitle>{{ $title }}</x-slot>
  <x-slot:headerFiles>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/tomSelect/tom-select.default.min.css')}}">
    @vite(['resources/scss/light/plugins/tomSelect/custom-tomSelect.scss'])
    @vite(['resources/scss/dark/plugins/tomSelect/custom-tomSelect.scss'])
  </x-slot>


    <div class="row layout-top-spacing">
      <div class="col-xl-12 col-lg-12 col-sm-12">
        <form action="{{ route('shipper.store') }}" method="POST" autocomplete="off" id="create-form">
          @csrf
          <div class="widget mb-4">
            <div class="widget-header">
              <div class="d-flex justify-content-between align-items-center">
                  <h4>Tambah Shipper</h4>
                  <button id="submit-create-form-button" type="submit" class="me-3 btn btn-primary">Simpan</button>
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
                      <label for="name">Nama Shipper<sup class="text-danger">*</sup></label>
                      <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Nama Penerima">
                      <span class="invalid-feedback"></span>
                  </div>
                </div>
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
                      <label for="destination">Pengiriman Via<sup class="text-danger">*</sup></label>
                      <input type="text" id="destination" name="destination_id">
                      <span class="invalid-feedback"></span>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label for="destination-type">Tipe Pengiriman<sup class="text-danger">*</sup></label>
                        <select id="destination-type" name="destination_type" placeholder="Pilih Tipe Pengiriman">
                            <option value="">Pilih Tipe Pengiriman</option>
                            <option value="CYCY">CYCY</option>
                            <option value="DOOR">DOOR</option>
                        </select>
                        <span class="invalid-feedback"></span>
                    </div>
                </div>
                <div id="cost-wrapper" class="col-xl-3 col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label for="cost">Harga PerKG Vol<sup class="text-danger">*</sup></label>
                        <input type="text" id="cost" class="form-control form-control-sm input-only-number" name="destination_cost" autocomplete="off">
                        <span class="invalid-feedback"></span>
                    </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Items --}}
          <div class="widget mb-4">
            <div class="widget-content widget-content-area">
              <div class="table-responsive">
                <table id="table-item" class="table table-bordered bg-white mb-0">
                    <thead>
                        <tr>
                            <th class="rounded-0 fw-bold" style="min-width: 70px !important; width: 70px !important; max-width: 70px !important;">No.</th>
                            <th class="rounded-0 fw-bold" style="min-width: 120px;">Nama</th>
                            <th class="rounded-0 fw-bold" style="min-width: 120px;">Koli</th>
                            <th class="rounded-0 fw-bold" style="min-width: 120px;">Volume</th>
                            <th class="rounded-0 fw-bold" style="min-width: 120px;">Total</th>
                            <th class="rounded-0 fw-bold text-center" style="width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="add-item-row">
                            <td colspan="6" class="text-center">
                                <button type="button" id="add-item-button" class="w-100 btn btn-primary">
                                    <span>Tambah Data</span>
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
  <x-slot:footerFiles>
    <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
    <script src="{{asset('plugins/axios/axios.min.js')}}"></script>
    <script src="{{ asset('plugins/tomSelect/tom-select.base.js') }}"></script>
    <script>
      const GET_DESTINATIONS = "{{ route('api.destinations.index') }}";
      const CREATE_SHIPPER_URL = "{{ route('shipper.store') }}";
    </script>
    <script type="module" src="{{ asset('pages/shipper/create-shipper.js') }}"></script>
  </x-slot>
</x-base-layout>
