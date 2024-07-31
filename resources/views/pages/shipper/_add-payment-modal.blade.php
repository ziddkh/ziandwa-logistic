<div class="modal fade" id="modal-add-payment" tabindex="-1" role="dialog" aria-labelledby="create-payment-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-payment-modal-label">Tambah Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="form-add-payment" method="POST" action="{{ route('api.shipper-payment.store') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="shipper_id" value="{{ $shipper->id }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div>
                            <p class="mb-0">Total Pembayaran</p>
                            <h4 class="fw-bold text-primary">Rp. {{ number_format($shipper->total_price, '0', ',', '.') }}</h4>
                        </div>
                        <div class="form-group mb-3">
                            <label for="payment-method">Tipe Pembayaran</label>
                            <select name="payment_method" id="payment-method" class="form-control form-control-sm">
                                <option selected disabled>Pilih Tipe Pembayaran</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->value }}">{{ $paymentMethod->value }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div id="wrapper-payment-amount" class="form-group mb-3" style="display: none;">
                            <label for="payment-amount">Total Bayar</label>
                            <input type="text" name="payment_amount" id="payment-amount" class="form-control form-control-sm input-price">
                            <span class="invalid-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-cancel" class="btn btn btn-light-dark" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Batal</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary">Buat Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
