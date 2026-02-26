        <tr>
            <td><img src="/uploads/custom-images2/{{$variation->thumb_image}}" height="50" width="50"/></td>
            <td>{{ $variation->name }}</td>
            <input type="hidden" value="{{ $variation->name }}" name="product_name[]">
            <input type="hidden" class="variation_data" value="1" name="variation_data[]" />
            <td></td>
            <td></td>
            <td>
                <input class="form-control qty quantity" name="quantity[]" type="number" value="1" required min="1"/>
                <input type="hidden" class="form-control" id="product_id" name="product_id[]" value="{{$pr_id}}" required/>
            </td>
            <td>
                <input class="form-control unit_price" name="unit_price[]" type="number" value="{{ $variation->price }}" required/>
            </td>
            <td>
                <input class="form-control discount_price" value="{{ !empty($variation->discount_price) ? $variation->discount_price : '0' }}" name="discount_price[]">
            </td>
            <td>
                <input class="form-control offer_price" name="offer_price[]" type="number" value="{{ !empty($variation->offer_price) ? $variation->offer_price : '0' }}" required/>
            </td>
            
            
            <td class="row_total"> {{$variation->price}}</td>
            <td>
                <a href="#" class="remove btn btn-sm btn-danger"> Delete </a>
            </td>
        </tr>