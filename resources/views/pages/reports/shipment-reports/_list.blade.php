@foreach ($shipmentsReports as $transaction)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $transaction->recipient_name }}</td>
        <td>{{ $transaction->departure_date }}</td>
        <td>{{ $transaction->shipmentItems->count() }}</td>
        <td>{{ $transaction->total_vol_weight }} m<sup>3</sup></td>
        <td>Rp. {{ number_format($transaction->paymentHeader->total_payment, 0, ',', '.') }}</td>
        <td>{{ $transaction->remarks }}</td>
    </tr>
@endforeach
