<div class="modal fade" id="action-vehicle-modal" tabindex="-1" role="dialog" aria-labelledby="action-vehicle-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="action-vehicle-modal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="action-vehicle-form" autocomplete="off">
                @csrf
                <input type="hidden" name="type" value="vehicle">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="ship-name">Kapal</label>
                        <input type="text" id="ship-name" name="ship_name" class="form-control form-control-sm" placeholder="Nama Kapal">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Deskripsi</label>
                        <input type="text" id="description" name="description" class="form-control form-control-sm">
                        <span class="invalid-feedback"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="price">Harga</label>
                        <input type="text" id="price" name="price" class="form-control form-control-sm input-only-number">
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
