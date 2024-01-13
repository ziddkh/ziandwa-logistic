@if (count($transactions) > 0)
    @php
    $counter = 1;
    @endphp
    @foreach ($transactions as $transaction)
    @php
        $totalItem = 0;
    @endphp
    @foreach ($transaction->transaction_details as $transaction_detail)
        @php
            $totalItem++;
        @endphp
    @endforeach
    <tr>
        <td>{{ $counter }}</td>
        <td>{{ $transaction->customer->name }}</td>
        <td>{{ !!$transaction->customer->delivery_address ? $transaction->customer->delivery_address : '-' }}</td>
        <td>{{ $totalItem }} Koli</td>
        <td>-</td>
    </tr>
    @php
        $counter++;
    @endphp
    @endforeach

@else
    <tr>
        <td colspan="5" class="text-center">Tidak Ada Pengiriman Hari Ini</td>
    </tr>
@endif
