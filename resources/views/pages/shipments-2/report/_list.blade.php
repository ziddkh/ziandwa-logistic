@php
    $counter = 1;
@endphp
@foreach ($transactions as $transaction)
    @foreach ($transaction->transaction_details as $transaction_detail)
    <tr>
        <td>{{ $counter }}</td>
        <td>{{ $transaction->customer->name }}</td>
        <td>{{ $transaction_detail->delivery_date }}</td>
        <td>{{ $transaction_detail->kg_volume }} m<sup>3</sup></td>
        <td>Rp. {{ number_format($transaction_detail->price, 0, ',', '.') }}</td>
    </tr>
    @php
        $counter++;
    @endphp
    @endforeach
@endforeach
