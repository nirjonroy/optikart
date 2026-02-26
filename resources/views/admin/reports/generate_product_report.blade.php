<table class="table2excel table table-bordered" id="">
    <thead>
        <tr>
            <th>#SL. No</th>
            <th >Inv. No</th>
            <th >Product</th>
            <th >Unit Price</th>
            <th >Qty</th>
            <th >Total Price</th>
        </tr>
    </thead>
    <tbody style="color:black; font-size:11px">
        @php $total = 0; $total_quantity = 0;$total_unit_price = 0; @endphp
        @foreach($report_data as $key => $item)
        <tr>
            <th>{{ $key + 1 }}</th>
            <td style="color: red;">
                {{ $item->id }}
            </td>
            <td>{{ $item->name }}</td>
            <td style="">{{$item->unit_price}}</td>
            <td>{{ $item->total_qty }} </td>
            <td style="">{{$item->total_price}}</td>
        </tr>
        @php $total += $item->total_price; $total_quantity += $item->total_qty; $total_unit_price += $item->unit_price;  @endphp
        @endforeach
    </tbody>
    <tfoot>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $total_quantity }}</td>
        <td>{{ $total }}</td>
    </tfoot>
</table>

@if(!empty($report_data))
<p>{!! urldecode(str_replace("/?","?",$report_data->appends(Request::all())->render())) !!}</p>
@else
@endif
