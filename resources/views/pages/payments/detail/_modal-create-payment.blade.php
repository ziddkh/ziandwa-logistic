<div class="modal fade" id="create-payment-modal" tabindex="-1" role="dialog" aria-labelledby="create-payment-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create-payment-modal-label">Tambah Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="create-payment-form" method="POST" action="{{ route('payment.generate-invoice', $payment->uuid) }}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <p>Total Pembayaran</p>
                            <h4 class="fw-bold text-primary">Rp. {{ number_format($payment->grand_total_payment, '0', ',', '.') }}</h4>
                        </div>
                        <div class="col-12 col-md-8">
                            @if (empty($payment->payment_method))
                                <div class="form-group mb-3">
                                    <label for="payment-method">Tipe Pembayaran</label>
                                    <select name="payment_method" id="payment-method" class="form-control form-control-sm">
                                        <option selected disabled>Pilih Tipe Pembayaran</option>
                                        <option value="Cash">Cash</option>
                                        <option value="DP">DP</option>
                                        <option value="Bayar Nanti">Bayar Nanti</option>
                                    </select>
                                </div>
                            @endif
                            <div class="form-group mb-3" style="display: none;">
                                <label for="payment-amount">DP</label>
                                <input type="text" name="payment_amount" id="payment-amount" class="form-control form-control-sm input-price">
                            </div>
                        </div>
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
