<table>
    <thead>
        <tr>
            <th style="font-weight:bold;">ServiceType</th>
            <th style="font-weight:bold;">ReceiverName</th>
            <th style="font-weight:bold;">COD</th>
            <th style="font-weight:bold;">MobileNumber</th>
            <th style="font-weight:bold;">ShipperRef</th>
            <th style="font-weight:bold;">CountryCode</th>
            <th style="font-weight:bold;">CityCode</th>
            <th style="font-weight:bold;">Area</th>
            <th style="font-weight:bold;">Address</th>
            <th style="font-weight:bold;">Instructions</th>
            <th style="font-weight:bold;">Description</th>
            <th style="font-weight:bold;">PCs</th>
            <th style="font-weight:bold;">StoreName</th>

        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        @php
        $count = count($order->line_items);
        $cityCodes = [
        'AZ' => 'AUH',
        'DU' => 'DXB',
        'AJ' => 'AJM',
        'UQ' => 'UAQ',
        'SH' => 'SHJ',
        'RK' => 'RAK',
        ];
        $cityNames = [
        'AUH' => 'Abu Dhabi',
        'DXB' => 'Dubai',
        'AJM' => 'Ajman',
        'UAQ' => 'Umm Al Quwain',
        'SHJ' => 'Sharjha',
        'RAK' => 'Ras Al Khaimah',
        'FUJ' => 'Fujaira',
        ];
        @endphp
        <tr>

            <td>NDD</td>
            <td>{{ $order->shipping_address['name'] ?? '' }}</td>
            <td>{{$order->total_price }}</td>
            <td>{{$order->phone!=''?$order->phone:$order->shipping_address['phone']}}</td>
            <td>{{ $order->name }} </td>
            <td>UAE</td>
            <td> {{$cityCodes[$order->shipping_address['province_code']] }} </td>
            <td>{{$cityNames[$cityCodes[$order->shipping_address['province_code']]] }}</td>
            <td>{{$order->shipping_address['address1'] }}{{ $order->shipping_address['address2']}} {{
                $order->shipping_address['city']}}</td>
            <td>Handle With Care</td>
            <td>{{ $order->name }} -
                @foreach ($order->line_items as $line)
                {{ $line['name'] }}
                @endforeach
            </td>
            <td>{{ count($order->line_items) }}</td>
            <td>{{$order->store->name}}</td>
        </tr>
             @endforeach
    </tbody>
</table>