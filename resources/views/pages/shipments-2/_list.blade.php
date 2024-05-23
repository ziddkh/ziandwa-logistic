@if (count($shipments) > 0)
    @foreach ($shipments as $shipment)
        <tr>
            <td>{{ $shipment->shipment_number }}</td>
            <td>{{ $shipment->recipient_name }}</td>
            <td>
                <div class="action-btns">
                    <a href="{{ route('shipments-2.show', $shipment->uuid) }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                    @if (auth()->user()->can('delete-shipment'))
                        @if (count($shipment->paymentHeader->paymentDetails) == 0)
                            <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip me-2" data-shipment="{{ $shipment->uuid }}"  data-toggle="tooltip" data-placement="top" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </a>
                        @else
                            <a href="javascript:void(0);" class="action-btn bs-tooltip me-2"  data-toggle="tooltip" data-placement="top" title="Tidak Bisa Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </a>
                        @endif
                    @endif
                    <a href="{{ route('payment.show', $shipment->paymentHeader->uuid) }}" class="action-btn btn-view bs-tooltip" data-toggle="tooltip" data-placement="top" title="Detail Pembayaran">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="100" class="text-center">Tidak ada data ekspedisi untuk saat ini, <a href="{{ route('shipments-2.create') }}" class="text-primary">klik</a> untuk menambah data</td>
    </tr>
@endif
