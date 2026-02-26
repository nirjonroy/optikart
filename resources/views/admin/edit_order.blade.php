@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Products')}}</title>
@endsection
@section('admin-content')

        <style>
            .remove i {
                color: #ffffff;
            }
            .text-area-test {
                min-height: 60px !important;    
            }
            /* The actual timeline (the vertical ruler) */
.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
}

/* Container around content */
.container-two {
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.container-two::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -17px;
  background-color: white;
  border: 4px solid #FF9F55;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  left: 0;
}

/* Place the container to the right */
.right {
  left: 50%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
.right::after {
  left: -16px;
}

/* The actual content */
.content {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }
  
  /* Full-width containers */
  .container-two {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  .container-two::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
  left: 0%;
  }
}
        </style>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Edit Order</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">{{__('admin.Edit Product')}}</div>
            </div>
          </div>

          <div class="section-body">
            <!--<a href="{{ route('admin.product.index') }}" class="btn btn-primary"><i class="fas fa-list"></i> {{__('admin.Products')}}</a>-->
            <div class="row mt-4">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.order.update',$order->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">                     
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4">
                                  <div class="form-group col-12">
                                    <label>Order Status <span class="text-danger">*</span></label>                                    
                                    <select name="order_status" class="form-control select2" id="brand">
                                      <option {{ $order->order_status == 0 ? 'selected' : '' }} value="0">Pending Order</option>
                                      <option {{ $order->order_status == 1 ? 'selected' : '' }} value="1">Processing Orders</option>
                                      <option {{ $order->order_status == 2 ? 'selected' : '' }} value="2">Courier Orders</option>
                                      <option {{ $order->order_status == 5 ? 'selected' : '' }} value="5">On Hold Orders</option>
                                      <option {{ $order->order_status == 3 ? 'selected' : '' }} value="3">Completed Orders</option>
                                      <option {{ $order->order_status == 4 ? 'selected' : '' }} value="4">Cancell Orders</option>
                                      <option {{ $order->order_status == 6 ? 'selected' : '' }} value="6">Return Orders</option>
                                    </select>
                                </div>                                 
                                </div> 
                                
                                <div class="col-md-8">
                                <div class="mb-3">
                                    <label>Product Search Here</label>  
                                    <input type="text" id="search2"  class="form-control" placeholder="product search here">
                                  </div>
                                </div>
                                
                                  </div>                                
                                  
                                </div>
                              </div>
                          <div class="row">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-12">
                              <table class="table table-centered table-nowrap mb-0" id="product_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 7%;">Image</th>
                                        <th style="width: 20%;">Product</th>                                      
                                        <th style="width: 8%">Size</th>
                                        <th style="width: 8%">Color</th>
                                        <th style="width: 7%;">Quantity</th>
                                        <th style="width: 8%;">Sell Price</th>
                                        <th style="width: 8%;">Original Price</th>
                                        <th style="width: 8%;">Discount</th>
                                        <th style="width: 8%;">Offer Price</th>
                                        <th style="width: 8%;">Subtotal</th>
                                        <th style="width: 8%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data">
                                    @foreach($order->orderProducts as $products)
                                        <tr>
                                          	<td> <img class="rounded-circle" src="{{ asset($products->product_image) }}" alt="" width="100px" height="100px"></td>
                                            <td>{{ $products->product_name }}</td>
                                            <input type="hidden" value="{{ $products->product_name }}" name="product_name[]">
                                               
                                            <td>
                                                 @if($products->product->type != 'single')
                                                <select class="form-control variation_data" id="variable_id">
                                                    @foreach($products->product->variations ?? [] as $v)
                                                        <option value="{{ $v->size->id }}" {{ $v->size->title == $products->variation ? 'selected' : '' }}>
                                                            {{ $v->size->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @else
                                                {{ $products->variation }}
                                                @endif
                                                <input type="hidden" class="variation" value="{{ $products->variation }}" name="variation[]">
                                                <input type="hidden" class="variation_data" value="{{ $products->size_id }}" name="variation_data[]" />
                                            </td>

                                            <td>
                                                
                                                @if($products->product->type != 'single')
                                                @if(count($products->product->colorVariations))
                                                    <select class="form-control color_id" name="variation_color_id[]">
                                                        @foreach($products->product->colorVariations ?? [] as $cvar)
                                                            <option value="{{ $cvar->color->name }}" data-color="{{ $cvar->color->id }}" {{ $cvar->color->name == $products->variation_color_id ? 'selected' : '' }}>
                                                                {{ $cvar->color->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="hidden" class="form-control color_id" value="default" name="variation_color_id[]">
                                                @endif
                                                
                                                    @if(count($products->product->colorVariations))
                                                        @foreach($products->product->colorVariations ?? [] as $cvar)
                                                            @if($cvar->color->name == $products->variation_color_id)
                                                            <input type="hidden" class="color_id" value="{{ $cvar->color->id }}" name="color_id[]">
                                                            @endif
                                                        @endforeach
                                                    @else
                                                    <input type="hidden" class="color_id" value="1" name="color_id[]">
                                                    @endif
                                                
                                                @else
                                                {{ $products->variation_color_id }}
                                                @endif
                                                
                                            </td>
                                            
                                            <td>
                                                <input class="form-control quantity" name="quantity[]" type="number" value="{{ $products->qty }}" required min="1" data-qty="{{$products->product->qty}}"/>
                                     			<input name="order_id[]" type="hidden" value="{{ $products->id }}">
                                                <input type="hidden" id="product_id" name="product_id[]" value="{{ $products->product_id }}" required/>
                                                <input type="hidden" name="variation_id[]" value=""/>
                                                <input type="hidden" name="order_product_id[]" value="{{ $products->id }}"/>
                                            </td>
                                          <td>
                                            <input type="number" class="form-control unit_price" id="unit_price" name="unit_price[]" value="{{ $products->unit_price }}" />
                                          </td>
                                          <td>
                                            <input type="number" class="form-control original_price" id="original_price" name="original_price[]" value="{{ $products->product->price }}" />
                                          </td>
                                          <td>
                                            <input type="number" class="form-control discount_price" name="discount_price[]" value="{{ $products->total_discount }}" />
                                          </td>
                                          <td>
                                            <input type="number" class="form-control offer_price" id="offer_price" name="offer_price[]" value="{{ $products->offer_price }}" />
                                          </td>
                                          
                                            <td class="row_total">{{$products->unit_price * $products->qty}}</td>
                                            <td><a class="remove btn btn-sm btn-danger"> <i class="fa fa-trash"></i></a></td>
                                        </tr> 
                                   @endforeach
                                  
                                </tbody>
                                
                                <tfoot>
                                    <tr style="border-top: 2px solid black;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="text" class="form-control total_qty" id="total_qty" value="{{ $order->product_qty }}" disabled>
                                            <input type="hidden" id="total_qty" name="product_qty" value="{{ $order->product_qty }}">
                                        </td>
                                        <td></td>
                                        <td>
                                             <input type="text" class="form-control total_discount" id="total_discount" disabled>
                                             <input type="hidden" class="form-control total_discount" id="total_discount" name="total_discounts">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control total_amount" id="total_amount" value="{{ $order->total_amount }}">
                                        <!--<input type="text" class="form-control total_amount" value="" id="total_amount" name="total_amount" disabled>-->
                                        <input type="hidden" class="form-control total_amount" id="total_amount" name="total_amount" value="{{ $order->total_amount }}">

                                        
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                              
                            <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" id="short_name" class="form-control"  name="short_name" value="{{ $order->orderAddress->shipping_name }}">
                                </div>    
                            </div>
                              
                              <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label>Customer Phone <span class="text-danger">*</span></label>
                                    <input type="text" id="shipping_phone" class="form-control"  name="shipping_phone" value="{{ $order->orderAddress->shipping_phone }}">
                                </div>    
                              </div>
                              
                              <div class="col-md-4">
                              <div class="form-group col-12">
                                    <label>Customer Address <span class="text-danger">*</span></label>
                                    <textarea name="shipping_address" id="" cols="30" rows="10" class="form-control text-area-test">{{ $order->orderAddress->shipping_address }}</textarea>
                                </div>                
                             
                              </div>
                              
                              <div class="col-md-4">
                              <div class="form-group col-12">
                                    <label>Shipping Method <span class="text-danger">*</span></label>
                                    <select class="form-control select2" name="shipping_charge_id" id="shipping_charge">
                                        <option value="" data-charge="0">Select One</option>
                                        @foreach($shippings as $charge)
                                        <option value="{{ $charge->id }}" {{ $charge->shipping_rule==$order->shipping_method ?'selected':'' }} data-rule="{{ $charge->shipping_rule }}" data-charge="{{ $charge->shipping_fee }}"> {{ $charge->shipping_rule }} </option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                              
                              
                              <!--<div class="col-md-4">-->
                              <!--<div class="form-group col-12">-->
                              <!--      <label>Customer Name <span class="text-danger">*</span></label>-->
                              <!--      <input type="text" id="short_name" class="form-control"  name="short_name" value="{{ $order->orderAddress->shipping_name }}">-->
                                
                              <!--  	 <label>Customer Phone <span class="text-danger">*</span></label>-->
                              <!--      <input type="text" id="short_name" class="form-control"  name="shipping_phone" value="{{ $order->orderAddress->shipping_phone }}">-->
                              <!--  </div>-->
                              <!--</div>-->
                              
                              <!--<div class="col-md-4">-->
                              <!--<div class="form-group col-12">-->
                              <!--      <label>Shipping Method <span class="text-danger">*</span></label>-->
                              <!--      <select class="form-control select2" name="shipping_charge_id" id="shipping_charge">-->
                              <!--          <option value="" data-charge="0">Select One</option>-->
                              <!--          @foreach($shippings as $charge)-->
                              <!--          <option value="{{ $charge->id }}" {{ $charge->shipping_rule==$order->shipping_method ?'selected':'' }} data-rule="{{ $charge->shipping_rule }}" data-charge="{{ $charge->shipping_fee }}"> {{ $charge->shipping_rule }} </option>-->
                              <!--          @endforeach-->
                              <!--      </select>-->
                              <!--  </div>-->
                              <!--</div>-->
                              
                              <!--<div class="col-md-4">-->
                               
                              <!--<div class="form-group col-12">-->
                              <!--      <label>Customer Address <span class="text-danger">*</span></label>-->
                              <!--      <textarea name="shipping_address" id="" cols="30" rows="10" class="form-control text-area-5">{{ $order->orderAddress->shipping_address }}</textarea>-->
                              <!--  </div>                             -->
                             
                              <!--</div>    -->
                              
                              
                              <div class="col-md-4">
                                  <div class="form-group col-12">
                                    <label  class="form-label">Courier</label>
                                    <select class="form-control" name="courier_id">
                                        <option value="0" data-charge="0">Select One</option>
                                        @foreach($couriers as $courier)
                                        <option value="{{ $courier->id }}" {{ $courier->id==$order->courier_id ? 'selected' : '' }}> {{ $courier->name }} </option>
                                        @endforeach
                                    </select>
                                    </div> 
                              </div> 
                              
                              <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label  class="form-label">Courier Tracking ID</label>
                                    <input type="text" class="form-control" value="{{ $order->courier_tracking_id}}" name="courier_tracking_id" />
                                </div>                              
                             </div>
                             
                             <div class="col-md-4">
                                <div class="form-group col-12">
                                    <label  class="form-label">Advance Amount</label>
                                    <input type="text" class="form-control" name="advance_amount" value="{{ $order->advance_amount }}" />
                                </div>                              
                             </div>
                             
                             <div class="col-md-4">
                               
                              <div class="form-group col-12">
                                    <label>Order Note</label>
                                    <textarea name="note" id="" cols="30" rows="10" class="form-control text-area-test">{{ $order->note }}</textarea>
                                </div>                           
                             
                              </div>
                             <div class="row for_redx {{ $order->courier_id != 1 ? 'd-none' : '' }}">
                             <div class="col-md-12">
                                 <h5 class="text-danger mt-3">These fields only for Redx Courier Service</h5>
                             </div> 
                             
                             <div class="col-md-4">
                                <label  class="form-label">Choose Area</label>
                             	<select class="form-control select2" id="area_select">
                                  <option value="">Select One</option>
                                  @if($areas!==null)
                                      @foreach($areas as $key=>$area)
                                      <option value="{{ $area['id'] }}" {{ $order->area_id ==  $area['id'] ? 'selected' : '' }}>{{ $area['name'] }}</option>
                                      @endforeach
                                  @endif
                                </select> 
                            </div>                            
                            <div class="col-md-4">
                                  <label  class="form-label">Area ID</label>
                                  <input type="text" readonly class="form-control" id="area_id" name="redx_area_id" value="{{ $order->area_id}}"/>
                            </div>                                                      
                            <div class="col-md-4">
                                  <label  class="form-label">Area Name</label>
                                  <input type="text" readonly class="form-control" id="area_name" name="area_name" value="{{ $order->area_name}}"/>
                            </div>
                          </div>                           
                          <div class="row for_pathao {{ $order->courier_id != 2 ? 'd-none' : '' }}">
                            <div class="col-md-12">
                                <h5 class="text-danger mt-3">These fields only for Pathao Courier Service</h5>
                            </div>  
                            <div class="col-md-3">
                                <label  class="form-label">Choose City</label>
                             	<select class="form-control select2" id="city_select" name="city">
                                  <option value="">Select One</option>
                                  @if($cities!==null)
                                      @foreach($cities as $key=>$city)
                                      <option value="{{ $city['city_id'] }}" {{ $order->city ==  $city['city_id'] ? 'selected' : '' }}>{{ $city['city_name'] }}</option>
                                      @endforeach
                                  @endif
                                </select> 
                            </div>                           
                            <div class="col-md-3">
                                <label  class="form-label">Choose Zone</label>
                             	<select class="form-control select2" id="zone_select" name="state">
                                  <option value="{{ $order->state }}">Select One</option>
                                </select> 
                            </div>                         
                            <div class="col-md-3">
                                <label  class="form-label">Choose Area</label>
                             	<select class="form-control select2" name="pathao_area_id">
                                  <option value="{{ $order->area_id }}">Select One</option>
                                </select> 
                            </div>                                                     
                            <div class="col-md-3">
                                  <label  class="form-label">Item Weight</label>
                                  <input type="number" class="form-control" id="weight" step="0.5" min="0.5" max="10" name="weight" value="{{ $order->weight != null ? $order->weight : '0.5' }}"/>
                            </div>
                          </div>
                        </div>
                            </div>
                          </div>
                          </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary">{{__('admin.Update')}}</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                  </div>
            <div class="row mt-4">
                  <div class="col-lg-12 mt-3">
                      
                      <div class="card">
                    <div class="card-body">
                            <div class="table-responsive table-invoice">
                     <table class="table table-striped" id="dataTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 120px;">Order Id</th>
                                        <th>Product</th>
                                        <th style="width: 120px;">Customer</th>
                                         <th style="width: 120px;">IP Address</th>
                                        <th style="width: 150px;">Status</th>
                                        <th style="width: 150px;">Assign User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($orderbyNumber as $orbynum)
                                    
                                    <tr>
                                        <td>{{ $orbynum->order_id }}</td>
                                        <td>
                                           @foreach($orbynum->orderProducts as $products) 
                                            {{ $products->product_name }},
                                           @endforeach   
                                       </td>
                                       <td>
                                          
                                        </td>
                                      <td>{{ $orbynum->ip_address }}</td>
                                      <td>
                                            @if ($orbynum->order_status == 1)
                                            <span class="badge badge-success">Process</span>
                                            @elseif ($orbynum->order_status == 2)
                                            <span class="badge badge-success">Courier</span>
                                            @elseif ($orbynum->order_status == 3)
                                            <span class="badge badge-success">Completed</span>
                                            @elseif ($orbynum->order_status == 4)
                                            <span class="badge badge-danger">Cancell</span>
                                            @elseif($orbynum->order_status == 5)
                                            <span class="badge badge-danger">On Hold</span>
                                            @elseif($orbynum->order_status == 6)
                                            <span class="badge badge-danger">Return</span>
                                            @else
                                            <span class="badge badge-danger">{{__('admin.Pending')}}</span>
                                            @endif
                                        </td>
                                      <td> {{ $orbynum->assign?$orbynum->assign->name:''}} </td>
                                    </tr> 
                                    @endforeach
                                 </tbody>
                            </table>
                            </div>
                            </div>
                            </div>
                            
                        </div>
                        </div>      
                  
                </div>
          </div>
        </section>
      </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>

var path2 = "{{ route('admin.addProduct') }}";
  const products=[];
  
  $( "#search2" ).autocomplete({
        selectFirst: false, //here
        minLength: 3,
        source: function( request, response ) {
          $.ajax({
            url: path2,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
                if (data.length ==0) {
                    toastr.error('Product Or Stock Not Found');
                }
                else if (data.length ==1) {
                    if(products.indexOf(data[0].id) ==-1){
                        newProductEntry(data[0]);
                        products.push(data[0].id);
                    }
                    $('#search2').val('');
                }else if (data.length >1) {
                    response(data);
                }
            }
          });
        },
        select: function (event, ui) {
           if(products.indexOf(ui.item.id) ==-1){
                landingProductEntry(ui.item);
                products.push(ui.item.id);
            }
           $('#search2').val('');
           return false;
        }
      });
      
      function newProductEntry(item)
      {
         $.ajax({
            url: '{{ route("admin.addNewProductEntryedit")}}',
            type: 'GET',
            dataType: "json",
            data: {id:item.id},
            success: function( res ) {
                if (res.html) {
                    $('tbody#data').append(res.html);
                    calculateSum();
                }
            }
          }); 
      }

      

      function productEntry(item){
        $.ajax({
            url: '{{ route("admin.orderProductEntry")}}',
            type: 'GET',
            dataType: "json",
            data: {id:item.id},
            success: function( res ) {
                if (res.html) {
                   $('tbody#data').append(res.html);
                    calculateSum();
                }
            }
          });
        }
  
    $(document).ready(function() {
      
    calculateSum();
  });
    
    $(document).on('click', '.remove', function() {
        var delete_tr = $(this).closest('tr');
        delete_tr.remove();
        calculateSum();
    });
  
    $(document).on('blur',".quantity, .unit_price,.discount_price",function(e) {    
     calculateSum();    
    });
  
    $(document).on('change',"#shipping_charge",function(e) {
        calculateSum();    
    });
    
    $(document).on('change','select.color_id',function() {
        
        var tblrow = $(this).closest('tr');
        var color_id = tblrow.find('td select.color_id option:selected').data('color');
        var pro_id = tblrow.find('td input#product_id').val();
        tblrow.find('td input.color_id').val(color_id);
        });
  
    function calculateSumOld() {
        var adv_amount = $('input[name="advance_amount"]').val();
        let tblrows = $("#product_table tbody tr");
        let sub_total= 0;
        let row_discount=0;
        // let shipping = $('#cost').val();
        let total_qty = 0;
        // let shipping=Number(tblrows.find('td input.shipping_cost').val());
        let shipping=Number($("#shipping_charge option:selected").data('charge'));        
        tblrows.each(function (index) {
            let tblrow = $(this);
            let qty=Number(tblrow.find('td input.quantity').val());
            
            let unitPrice=Number(tblrow.find('td input.unit_price').val());
            let offerPrice=Number(tblrow.find('td input.offer_price').val());
            let original_price=Number(tblrow.find('td input.original_price').val());
            let discount=Number(tblrow.find('td input.discount_price').val());
            // if(offerPrice > 0){
            //     var amount=offerPrice;
            // } else {
            //     var amount=unitPrice;
            // }
            let amount=original_price;
            
            let row_total = parseFloat(qty *amount);
            row_discount+=Number(qty *discount);
            row_total-=row_discount;
            sub_total +=row_total;
            tblrow.find('td.row_total').text(row_total.toFixed(2));
            total_qty += qty;
        });
        
        sub_total+=shipping;
        
        sub_total = sub_total-adv_amount;
        
        $('input#total_amount').val(sub_total);
        $('input#total_qty').val(total_qty.toFixed(2));
        $('input#total_discount').val(row_discount.toFixed(2));
    }
    
    function calculateSum() {
        var adv_amount = $('input[name="advance_amount"]').val();
        let tblrows = $("#product_table tbody tr");
        let sub_total= 0;
        let row_discount=0;
        // let shipping = $('#cost').val();
        let total_qty = 0;
        // let shipping=Number(tblrows.find('td input.shipping_cost').val());
        let shipping=Number($("#shipping_charge option:selected").data('charge'));        
        tblrows.each(function (index) {
            let tblrow = $(this);
            let qty=Number(tblrow.find('td input.quantity').val());
            
            let unitPrice=Number(tblrow.find('td input.unit_price').val());
            let offerPrice=Number(tblrow.find('td input.offer_price').val());
            let original_price=Number(tblrow.find('td input.original_price').val());
            let discount=Number(tblrow.find('td input.discount_price').val());
            // if(offerPrice > 0){
            //     var amount=offerPrice;
            // } else {
            //     var amount=unitPrice;
            // }
            let amount=original_price;
            
            let row_total = parseFloat(qty *amount);
            
            row_discount+=Number(qty *discount);
            let total_discount=Number(qty *discount);
            // alert(row_discount);
            // row_total-=row_discount;
            row_total-=total_discount;
            sub_total +=row_total;
            tblrow.find('td.row_total').text(row_total.toFixed(2));
            total_qty += qty;
        });
        
        sub_total+=shipping;
        sub_total+-row_discount;
        
        sub_total = sub_total-adv_amount;
        
        $('input#total_amount').val(sub_total);
        $('input#total_qty').val(total_qty.toFixed(2));
        $('input#total_discount').val(row_discount.toFixed(2));
    }
  
    $(function(){
        $(document).on('change', 'select[name="courier_id"]', function(e){
    	let courier_id = $(this).val();
    	if(courier_id == 1)
        {
          	$(document).find('div.for_redx').removeClass('d-none');
          	$(document).find('div.for_pathao').addClass('d-none');
        }  
    	else if(courier_id == 2)
        {
          	$(document).find('div.for_pathao').removeClass('d-none');
          	$(document).find('div.for_redx').addClass('d-none');
        }
        else {
            $(document).find('div.for_pathao').addClass('d-none');
          	$(document).find('div.for_redx').addClass('d-none');
        }
  });
  
  $(document).on('blur', 'input[name="advance_amount"]', function() {
      
      let adv_amount = $(this).val();
      let total_val = $('#total_amount').val();
      if(adv_amount != null || adv_amount != '') {
          var ultimate_amount = total_val - adv_amount;
      } else {
          ultimate_amount = total_val;
      }
      $('input#total_amount').val(ultimate_amount);
  });
  
  $(document).on('change', '#city_select', function(e){
    let city = $(this).val();
    var url = "{{ route('admin.zonesByCity', ":city") }}";
	url = url.replace(':city', city);
    $.ajax({
        url,
        type: 'GET',
        dataType: "json",
        success: function(res){
          if(res.success)
          {
            let html = "<option value=''>Select One</option>";
            for(let i = 0; i < res.zones.length; i++)
            {
               html += "<option value='"+res.zones[i].zone_id+"' >"+res.zones[i].zone_name+"</option>";
            }
            
            $('#zone_select').html(html);
            
          }
        }
      
    });
    
  });
  
   $(document).on('change','select#variable_id',function(e) {
       
        var tblrow = $(this).closest('tr');
        // var size_id = Number(tblrow.find('td select#variable_id option:selected').attr('value'));
        
        var pro_id = tblrow.find('td input#product_id').val();
        var size_id = Number(tblrow.find('td select#variable_id option:selected').attr('value'));
        var color_id = Number(tblrow.find('td input.color_id').val());
        
        $.ajax({
            url: '{{ route("admin.get_variant_price")}}',
            type: 'GET',
            dataType: "json",
            data: {size_id, pro_id},
            success: function( res ) {
                if(res.status) {
                    tblrow.find('td input.variation').val(res.size_name);
                    tblrow.find('td input.variation_data').val(size_id);
                    tblrow.find('td input.offer_price').val(res.price);
                    var offerPrice=tblrow.find('td input.offer_price').val();
                    var unitPrice=tblrow.find('td input.unit_price').val();
                    if(offerPrice > 0 ){
                        var op=offerPrice;
                    } else {
                        var op=unitPrice;
                    }
                    // var op = Number(tblrow.find('td input.unit_price').val());
                    var qty = Number(tblrow.find('td input.quantity').val());  
                    var tPrice = Number(op * qty);
                    tblrow.find('td.row_total').text(tPrice.toFixed(2));
                }
            }
          });
        
        let tblrows = $("#product_table tbody tr");
   	
        let sub_total=0;
        let row_discount=0;
        let total_qty = 0;
        let charge=Number($("#shipping_charge option:selected").data('charge'));
        tblrows.each(function (index) {
            let tblrow = $(this);
            let qty=Number(tblrow.find('td input.quantity').val());
            let amount=Number(tblrow.find('td input.unit_price').val());
          	let discount=Number(tblrow.find('td input.offer_price').val());
          	if(discount > 0) {
          	    var row_total=Number(qty *discount);
          	} else {
          	    var row_total=Number(qty *amount);
          	    $('input.offer_price').val(0);
          	}
            tblrow.find('.row_total').text(row_total.toFixed(2));
            sub_total+=row_total;
            total_qty+=qty;
        });
        sub_total+=charge;
        $('input#purchase_total').val(sub_total.toFixed(2));
        $('input#discount_amount').val(row_discount.toFixed(2));
        $('input#shipping_charge').val(charge.toFixed(2));
        $('input#total_qty').val(total_qty);    
    });
  
  
   $(document).on('change', '#zone_select', function(e){
    let zone = $(this).val();
    var url = "{{ route('admin.areasByZone', ":zone") }}";
	url = url.replace(':zone', zone);
    $.ajax({
        url,
        type: 'GET',
        dataType: "json",
        success: function(res){
          if(res.success)
          {
            let html = "<option value=''>Select One</option>";
            for(let j = 0; j < res.areas.length; j++)
            {
               html += "<option value='"+res.areas[j].area_id+"' >"+res.areas[j].area_name+"</option>";
            }
            
            $('select[name="pathao_area_id"]').html(html);
            
          }
        }
      
    });
    
  });
  
//   $(document).ready(function() {
//     $('.select2').select2();
//   });

  $(document).on('change',"#area_select",function(e) {
    let area_id = $(this).val();
    
    let area_name = $("#area_select option:selected").text();
    $("#area_id").val(area_id);
    $("#area_name").val(area_name);
  });
  
  
    });
</script>
@endsection
