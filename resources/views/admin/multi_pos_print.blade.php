<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #invoice-POS {
        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        padding: 4mm;
        margin: 0 auto;
        width: 90mm;
        background: #FFF;
}

@media print {
        .no-print {
            display: none;
        }
    }

#invoice-POS ::selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS ::moz-selection {
  background: #f31544;
  color: #FFF;
}
#invoice-POS h1 {
  font-size: 1.5em;
  color: #222;
}
#invoice-POS h2 {
  font-size: 1.5em;
}
#invoice-POS h3 {
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
#invoice-POS p {
  font-size: 0.9em;
    color: #000;
    line-height: 1.2em;
    margin: 0px;
}
#invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
  /* Targets all id with 'col-' */
  /*border-bottom: 1px solid #EEE;*/
}
#invoice-POS #top {
  /*min-height: 100px;*/
}
#invoice-POS #mid {
  min-height: 80px;
}
#invoice-POS #bot {
  min-height: 50px;
}
#invoice-POS #top .logo {
  height: 60px;
  width: 60px;
  background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
  background-size: 60px 60px;
}
#invoice-POS .clientlogo {
  float: left;
  height: 60px;
  width: 60px;
  background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
  background-size: 60px 60px;
  border-radius: 50px;
}
#invoice-POS .info {
  display: block;
  margin-left: 0;
}
#invoice-POS .title {
  float: right;
}
#invoice-POS .title p {
  text-align: right;
}
#invoice-POS table {
  width: 100%;
  border-collapse: collapse;
}
#invoice-POS .tabletitle {
  font-size: 0.5em;
  background: #EEE;
  line-height: 0px;
}
#invoice-POS .service {
  border-bottom: 1px solid #EEE;
}
#invoice-POS .item {
  width: 24mm;
}
#invoice-POS .itemtext {
  font-size: 1em;
}
#invoice-POS #legalcopy {
  margin-top: 5mm;
}

.tracking_code p{
    font-size: 1em !important;
    color: #000 !important;
    line-height: 0rem !important;
    font-weight: 900 !important;
}


    </style>
    
</head>
 <body>

@php use App\Models\Setting; $site_name = Setting::first()->site_name; @endphp

<div class="row">
    <div class="col-md-12 text-center no-print">
        <button class="btn btn-secondary btn-sm no-print" style="margin-top: 10px;" id="printBtn"><i class="fa fa-print"></i> Print Invoice</button>
    </div>
</div>


@foreach($items as $order)
<div id="invoice-POS">
        <center id="top">
          <div class="info">
            <h2>{{ $site_name }}</h2>
            <span class="tracking_code" style="">{!! clean(nl2br($order->courier_tracking_id)) !!}</span>
          </div><!--End Info-->
        </center><!--End InvoiceTop-->

        <div id="mid">
          <div class="info">
            <h2>Contact Info</h2>
            <p>
                Name    : {{ $order->orderAddress->shipping_name }}</br>
                Address : {{ $order->orderAddress->shipping_address }}</br>
                Phone   : {{ $order->orderAddress->shipping_phone }}</br>
                OrderId: #{{ $order->order_id }}
            </p>
          </div>
        </div><!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item" style="width: 58%;"><h2>Item</h2></td>
                        <td class="Hours" style="width: 23%;"><h2>Qty</h2></td>
                        <td class="Hours" style="width: 23%;"><h2>V</h2></td>
                        <td class="Rate"><h2>Total</h2></td>
                    </tr>
                    @php 
                     $total_discount = 0;
                     $total_price = 0;
                    @endphp
                    @foreach ($order->orderProducts as $index => $orderProduct)

                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">
                            {{ $orderProduct->product_name }}
                        </p></td>
                        <td class="tableitem"><p class="itemtext">{{ $orderProduct->qty }}</p></td>
                        <td class="tableitem"><p class="itemtext">{{ $orderProduct->variation_color_id != 'default' ?  $orderProduct->variation_color_id : '' }}-{{ $orderProduct->variation }}</p></td>
                        
                        @php
                            $total = ($orderProduct->product->price * $orderProduct->qty);
                            $total_discount += $orderProduct->total_discount;
                            $total_price = $total_price + $total;
                        @endphp
                        <td class="tableitem"><p class="itemtext">{{ $total }}</p></td>
                    </tr>
                    
                    @endforeach
                    
                    
                    
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Sub Total</h2></td>
                        <td class="payment"><h2>{{ $total_price }}</h2></td>
                    </tr>
                    
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Discount(-)</h2></td>
                        <td class="payment"><h2>{{ $total_discount }}</h2></td>
                    </tr>
                    
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Advance(-)</h2></td>
                        <td class="payment"><h2>{{ $order->advance_amount != '' ? $order->advance_amount : '0' }}</h2></td>
                    </tr>
                    
                    <tr class="tabletitle">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Shipping(+)</h2></td>
                        <td class="payment"><h2>{{ $order->shipping_cost }}</h2></td>
                    </tr>
                    
                    
                    <tr class="tabletitle" style="border-top: 1px solid black;">
                        <td></td>
                        <td></td>
                        <td class="Rate"><h2>Total</h2></td>
                        <td class="payment"><h2>{{ $order->total_amount }}</h2></td>
                    </tr>
                    
                    
                </table>
            </div>
        </div>
      </div>

@endforeach


    <script>
          let printBtn = document.querySelector('#printBtn');
          printBtn.addEventListener('click', function(){
              print();
          })
      </script>
      
      

</body>
</html>
