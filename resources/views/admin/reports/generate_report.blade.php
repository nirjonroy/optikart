        <table class="table2excel table table-bordered" id="">
            <thead>
                <tr>
                    <th>#SL. No</th>
                    <th >Inv. No</th>
                    <th >Customer</th>
                    <th >Phone</th>
                    <th >Product</th>
                    <th >Qty</th>
                    <th >Total</th>
                </tr>
            </thead>
            <tbody style="color:black; font-size:11px">
                @php $total = 0; @endphp
                @foreach($report_data as $key => $item)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td style="color: red;">
                        {{ $item->order_id }}
                    </td>
                    <td>{{ $item->order->orderAddress->shipping_name }} </td>
                    <td>{{ $item->order->orderAddress->shipping_phone }} </td>
                    <td style="color: red;">
                        @php
                            $product_names = explode(',', $item->product_names);
                            echo implode(', ', $product_names);
                        @endphp
                    </td>
                    <td>{{ $item->total_qty }} </td>
                    <td style="">{{$item->total_payment}}</td>
                </tr>
                @php $total += $item->total_payment  @endphp
                @endforeach
            </tbody>
            <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total : </td>
                <td>{{ $total }}</td>
            </tfoot>
        </table>
        
        @if(!empty($report_data))
        <p>{!! urldecode(str_replace("/?","?",$report_data->appends(Request::all())->render())) !!}</p>
        @else
        @endif
