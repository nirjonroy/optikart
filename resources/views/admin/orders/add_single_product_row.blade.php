        <tr>
            <td><img src="/uploads/custom-images2/{{$variation->thumb_image}}" height="50" width="50"/></td>
            <td>{{ $variation->name }}</td>
            <input type="hidden" value="{{ $variation->name }}" name="product_name[]">
            <td></td>
            <td></td>
            <td>
                <input class="form-control qty quantity" name="quantity[]" data-qty="{{ $stock_qty }}" type="number" value="1" required min="1"/>
                <input type="hidden" class="form-control" name="product_id[]" value="{{$pr_id}}" required/>
            </td>
            <td>
                <input class="form-control price" name="price[]" type="number" value="{{ $variation->price }}" required/>
                <input type="hidden" class="form-control" name="variation[]" value="1">
                <input type="hidden" value="1" class="color_id" name="variation_color[]">
            </td>
            <td>
                <input class="form-control" value="{{ $variation->discount_price != '0' ? $variation->discount_price : '0' }}" name="discount_price[]">
            </td>
            <td>
                <input class="form-control offer_price" name="offer_price[]" type="number" value="{{ !empty($variation->offer_price) ? $variation->offer_price : '0' }}" required/>
            </td>
            
            
            <td class="row_total"> {{$variation->price}}</td>
            <td>
                <a href="#" class="remove btn btn-sm btn-danger"> Delete </a>
            </td>
        </tr>