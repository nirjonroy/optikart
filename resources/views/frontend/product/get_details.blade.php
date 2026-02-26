<div class="sizes" id="sizes" style="margin-bottom: 5px;">
    @foreach ($product->variations as $v)
        @if (!empty($v->size->title))
            <div class="size" data-proid="{{ $v->product_id }}" data-varprice="{{ $v->sell_price }}"
                data-varsize="{{ $v->size->title }}" value="{{ $v->id }}" data-varSizeId="{{ $v->size_id }}">
                @if ($v->size->title == 'free')
                    {{ $v->size->title }}
                    <input type="hidden" id="size_value" name="variation_id">
                    <input type="hidden" id="size_variation_id" name="size_variation_id">
                    <input type="hidden" name="pro_price" id="pro_price">
                    <input type="hidden" name="variation_size_id" id="variation_size_id">
                @else
                    {{ $v->size->title }}
                    <input type="hidden" id="size_value" name="variation_id">
                    <input type="hidden" id="size_variation_id" name="size_variation_id">
                    <input type="hidden" name="pro_price" id="pro_price">
                    <input type="hidden" name="variation_size_id" id="variation_size_id">
                @endif
            </div>
        @endif
    @endforeach
</div>

<div class="colors" id="colors">
    @if (!empty($product->prod_color == 'varcolor'))

        @foreach ($product->colorVariations as $v)
            @if (!empty($v->color->code))
                <div class="color" style="background: {{ $v->color->code }}" data-proid="{{ $v->product_id }}"
                    data-colorid="{{ $v->color_id }}" data-varcolor="{{ $v->color->name }}"
                    value="{{ $v->id }}" data-variationColorId="{{ $v->color_id }}">
                    <input type="hidden" id="color_val" name="color_id">
                    <!--<img src="{{ asset($v->var_images) }}" width="50px" height="50px" /> -->
                    <input type="hidden" id="color_value" name="variationColor_id">
                    <input type="hidden" id="variation_color_id" name="variation_color_id">
                </div>
            @else
                Color Not Available
            @endif
        @endforeach
    @else
        <input type="hidden" id="variation_color" name="variation_color" value="default">
        <input type="hidden" id="variation_color_id" name="variation_color_id" value="1">
    @endif

</div>
