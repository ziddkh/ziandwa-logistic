<div class="modal fade" id="action-bale-modal" tabindex="-1" role="dialog" aria-labelledby="action-bale-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="action-bale-modal-label"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="action-bale-form" autocomplete="off">
                @csrf
                <input type="hidden" name="type" value="bale">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="ship-name">Kapal</label>
                        <input type="text" id="ship-name" name="ship_name" class="form-control form-control-sm" placeholder="Nama Kapal">
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
                        <p class="mb-1">Volume: <span id="vol-weight">0.000</span>m<sup>3</sup></p>
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
