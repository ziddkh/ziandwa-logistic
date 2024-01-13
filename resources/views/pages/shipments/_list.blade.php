@if (count($transactions) > 0)
    @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->code }}</td>
            <td>{{ $transaction->customer->name }}</td>
            <td>
                <div class="action-btns">
                    <a href="{{ route('shipments.show', $transaction->id) }}" class="action-btn btn-view bs-tooltip me-2" data-toggle="tooltip" data-placement="top" title="Detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                    <a href="javascript:void(0);" class="action-btn btn-delete bs-tooltip" data-transaction="{{ $transaction->id }}"  data-toggle="tooltip" data-placement="top" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="100" class="text-center">Tidak ada data ekspedisi untuk saat ini, <a href="{{ route('shipments.create') }}" class="text-primary">klik</a> untuk menambah data</td>
    </tr>
@endif
