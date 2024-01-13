@foreach ($shipmentsReports as $transaction)
    @foreach ($transaction->shipmentItems as $transaction_detail)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $transaction->recipient_name }}</td>
        <td>{{ $transaction_detail->departure_date }}</td>
        <td>{{ $transaction_detail->vol_weight }} m<sup>3</sup></td>
        <td>Rp. {{ number_format($transaction_detail->price, 0, ',', '.') }}</td>
        <td>{{ $transaction_detail->description }}</td>
    </tr>
    @endforeach
@endforeach
