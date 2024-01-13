<div class="modal fade" id="edit-information-modal" tabindex="-1" role="dialog" aria-labelledby="edit-information-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-information-modal-label">Edit Infomrasi Pengiriman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="edit-information-form" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="recipient-name">Nama</label>
                        <input type="text" id="recipient-name" name="recipient_name" class="form-control form-control-sm" placeholder="Nama Penerima">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="recipient-phone">Telepon</label>
                        <input type="text" id="recipient-phone" name="recipient_phone" class="form-control form-control-sm input-only-number" placeholder="Nomor WA Penerima">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="recipient-address">Alamat</label>
                        <input type="text" id="recipient-address" name="recipient_address" class="form-control form-control-sm" placeholder="Alamat Penerima">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="harbor-name">Pelabuhan</label>
                        <input type="text" id="harbor-name" name="harbor_name" class="form-control form-control-sm" placeholder="Nama Pelabuhan">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="departure-date">Tanggal Pengiriman</label>
                        <input type="date" id="departure-date" name="departure_date" class="form-control form-control-sm">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="destination-id">Pengiriman Via<sup class="text-danger">*</sup></label>
                        <input type="text" id="destination-id" name="destination_id">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="destination-type">Tipe Pengiriman<sup class="text-danger">*</sup></label>
                        <select id="destination-type" placeholder="Pilih Tipe Pengiriman">
                            <option value="">Pilih Tipe Pengiriman</option>
                            <option value="normal">Normal</option>
                            <option value="spesial">Spesial</option>
                        </select>
                        <span class="invalid-feedback"></span>
                    </div>
                    <div id="cost-wrapper" class="form-group" style="display: none">
                        <label for="destination-cost">Harga PerKG Vol<sup class="text-danger">*</sup></label>
                        <input type="hidden" id="destination-cost" class="form-control form-control-sm input-only-number" name="destination_cost" autocomplete="off">
                        <span class="invalid-feedback"></span>
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
