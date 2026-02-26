<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderPayment;
use App\Models\Country;
use App\Models\CountryState;
use App\Models\City;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use App\Models\FlashSaleProduct;
use App\Models\FlashSale;
use App\Models\Shipping;
use App\Models\Setting;
use App\Models\ProductVariant;
use App\Models\productColorVariation;
use App\Models\ProductStock;
use Auth, DB, Session, Str;
use App\Models\BkashPayment;
use App\Models\SslcommerzPayment;
use App\Library\SslCommerz\SslCommerzNotification;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // $this->middleware("auth:api")->except(
        //     "molliePaymentSuccess",
        //     "instamojoResponse",
        //     "sslcommerz_success",
        //     "sslcommerz_failed"
        // );

        $bkash = BkashPayment::first();
        $this->base_url = $bkash->base_url;
        $this->bkash_username = $bkash->username;
        $this->bkash_password = $bkash->password;
        $this->bkash_app_key = $bkash->app_key;
        $this->bkash_app_secret = $bkash->app_secret;
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        // return $cart;

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        if (count($cart) <= 0) {
            return redirect()->route('front.home');
        }

        $user = Auth::user();
        $countries = Country::select('id', 'name')->orderBy('name')->get();
        $shippings = Shipping::with('city')->orderBy('id', 'asc')->get();
        $setting = Setting::first();
        $bkash_payment =  BkashPayment::firstWhere(['status' => 1]);
        $ssl_payment =  SslcommerzPayment::firstWhere(['status' => 1]);
        return view('frontend.cart.checkout', compact('cart', 'countries', 'user', 'shippings', 'setting', 'bkash_payment', 'ssl_payment', 'totalPrice'));
    }

    public function checkoutsing($product_id)
    {

        $user = Auth::user();
        $product = Product::find($product_id); // Fetch the product based on product ID
        $cart = [$product_id => [
            'name' => $product->name,
            'price' => $product->price,
            'variation_color_id' => $product->variation_color_id,
            'variation_color_id' => $item['variation_color_id'],
            'variation' => $item['variation'],
            'quantity' => 1, // Assuming you want to add only 1 quantity
            // Other product details
        ]];

        $countries = Country::select('id', 'name')->orderBy('name')->get();
        $shippings = Shipping::with('city')->orderBy('id', 'asc')->get();
        $setting = Setting::first();
        // return redirect()->route('front.checkout.index');
        return view('frontend.cart.index', compact('cart', 'countries', 'user', 'shippings', 'setting'));
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'billing_name' => '',
            'billing_email' => '',
            'billing_phone' => '',
            'billing_address' => '',
            'billing_country' => '',
            'billing_state' => '',
            'billing_city' => '',
            'billing_address_type' => '',
            'shipping_name' => 'required',
            'shipping_email' => '',
            'order_phone' => 'required|numeric',
            'shipping_address' => 'required',
            'shipping_country' => '',
            'shipping_state' => '',
            'shipping_city' => '',
            'shipping_address_type' => '',
            'payment_method' => 'required',
            'shipping_method' => 'required',
            'transection_id' => '',
            'ip_address' => '',
        ]);

        $phone = $request->order_phone;

        if (User::where('phone', $phone)->exists()) {
            $user = User::where('phone', $phone)->first();
        } else {
            $user = User::create([
                'name' => $request->shipping_name,
                'phone' => $request->order_phone,
                'address' => $request->shipping_address
            ]);
        }


        // $user = Auth::user();
        // if(empty($user))
        // {
        // 	$user = User::create([
        //       'name' => $request->shipping_name,
        //       'phone' => $request->order_phone,
        //       'address' => $request->shipping_address
        //     ]);
        // }

        if (!$user->email) {
            $user->email = $user->name . "_" . rand(111111, 999999) . "@gmail.com";
            $user->save();
        }

        $data['user_id'] = $user->id;
        $shipping_id = $inputs['shipping_method'];
        $couponCode = isset($coupon['code']) ? $coupon['code'] : null;
        $lastOrder = Order::latest()->first();
        $total = $this->calculateCartTotal(
            $user,
            1235,
            $shipping_id
        );

        //Session store
        $newOrderNumber = $lastOrder ? $lastOrder->order_id + 1 : 1;
        Session::forget(['total_order_amount', 'invoice_number', 'user']);
        Session::put('total_order_amount', $total['total_price']);
        Session::put('invoice_number', $newOrderNumber);
        Session::put('user', $user);

        $shipping_rule = Shipping::find($inputs['shipping_method'])->shipping_rule;

        $data = [];
        $data['order_id'] = $newOrderNumber;
        $data['user_id'] =  $user->id;
        $data['order_phone'] = $user->phone;
        $data['ip_address'] =  $request->ip_address;
        $data['product_qty'] = cartTotalAmount()['total_qty'];

        // $data['payment_method'] = 'cash_on_delivery';
        $data['payment_method'] = $inputs['payment_method'];
        $data['shipping_method'] = $shipping_rule;
        $data['ordered_delivery_date'] = $request->ordered_delivery_date;
        $data['ordered_delivery_time'] = $request->ordered_delivery_time;

        $data['total_amount'] = $total["total_price"];
        $data['coupon_coast'] = $total["coupon_price"];
        $data['shipping_cost'] = $total["shipping_fee"];
        $data['order_status'] = 0;
        $data['cash_on_delivery'] = 0;
        $data['additional_info'] = 0;
        $data['assign_id'] = User::inRandomOrder()->first()->id;

        // Order Assign Among Users Start

        $assign_user_id = 1;
        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.name', 'Employee');
        })->where('active_status', 1)
            ->select('id')
            ->pluck('id')->toArray();

        $ordering = count($users) - 1;
        if (count($users) == 1) {
            $assign_user_id = $users[0];
            $data['assign_user_id'] = $assign_user_id;
        } else if ($ordering > 0) {
            $order = Order::latest()->take($ordering)->get()->pluck('assign_user_id')->toArray();

            $output = array_merge(array_diff($order, $users), array_diff($users, $order));

            if (!empty($output)) {
                $assign_user_id = $output[0];
                $data['assign_user_id'] = $assign_user_id;
            } else {
                $data['assign_user_id'] = $assign_user_id;
            }
        }

        // Order Assign Among Users End.
        try {
            DB::beginTransaction();
            $order = Order::create($data);
            if ($order) {
                $cart = session()->get('cart', []);
                foreach ($cart as $key => $item) {
                    $unit_price = $item['price'];

                    $orderProduct = OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'seller_id' => 0,
                        'product_name' => $item['name'],
                        'product_image' => $item['image'],
                        'variation_color_id' => $item['variation_color'],
                        'variation' =>  $item['variation_size'],
                        'size_id' => $item['variation_size_id'],
                        'color_id' => $item['variation_color_id'],
                        'unit_price' => $unit_price,
                        'total_discount' => (int)$item['quantity'] * (int)$item['discount_price'],
                        'qty' => $item['quantity']
                    ]);

                    // dd($orderProduct);
                    $single_product = Product::find($item['product_id']);
                    $single_product->sold_qty = $single_product->sold_qty + $item['quantity'];
                    $single_product->qty = $single_product->qty - $item['quantity'];
                    $single_product->save();
                }

                $order->orderAddress()->create([
                    'billing_name' =>  $request->billing_name,
                    'billing_email' => $request->billing_email,
                    'billing_phone' =>  $request->billing_phone,
                    'billing_address' =>  $request->billing_address,
                    'billing_country' =>  $request->billing_country,
                    'billing_state' =>  $request->billing_state,
                    'billing_city' =>  $request->billing_city,
                    'billing_address_type' =>  $request->billing_address_type,
                    'shipping_name' => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' =>   $user->phone,
                    'shipping_address' =>  $request->shipping_address,
                    'shipping_country' =>  $request->shipping_country,
                    'shipping_state' =>  $request->shipping_state,
                    'shipping_city' =>  $request->shipping_city,
                    'shipping_address_type' =>  $request->shipping_address_type,
                    'payment_method' => $request->payment_method,
                    'shipping_method' => $request->shipping_method,
                    'transection_id' => $request->transection_id,
                ]);
                foreach ($cart as $key => $item) {

                    // dd($item['quantity']);
                    if ($item['variation_color_id'] > 0 || $item['variation_size_id'] > 0) {
                        $chekckVarSingle = Product::where('id',  $item['product_id'])->first();

                        $stockCheck = ProductStock::where('color_id', $item['variation_color_id'])->where('size_id', $item['variation_size_id'])->where('product_id', $item['product_id'])->first();
                        // dd( $stockCheck->quantity);
                        $ultimate_stock = $stockCheck->quantity - $item['quantity'];
                        $stockCheck->update([
                            'quantity' => $ultimate_stock,
                        ]);
                    } else {
                        $chekckVarSingle = Product::where('id',  $item['product_id'])->first();
                        $stockCheck = ProductStock::where('color_id', 1)->where('size_id', 1)->where('product_id', $item['product_id'])->first();
                        $ultimate_stock = $stockCheck->quantity - $item['quantity'];
                        $stockCheck->update([
                            'quantity' => $ultimate_stock,
                        ]);
                    }
                }
            }

            DB::commit();
            session()->put('cart', []);
            session()->put('coupon', []);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }
        if ($request->payment_method == 'cash_on_delivery') {
            return response()->json([
                'status' => true,
                'msg' => 'Order placed successfully',
                'url' => route('front.order-thanks-page', $user->phone),
                'invoiceId' => $order->id
            ], 200);
        } else if ($request->payment_method == 'ssl_commerz') {
            return response()->json([
                'status' => true,
                'msg' => 'Order placed successfully! Please complete payment!',
                'url' => route('user.checkout.sslcommerz-web-view')
            ], 200);
        } else if ($request->payment_method == 'bkash') {
            return response()->json([
                'status' => true,
                'msg' => 'Order placed successfully! Please complete your bkash payment!',
                'url' => route('user.checkout.bkash-url-pay')
            ], 200);
        } else {
            dd($request->all());
        }
    }

    public function storelandData(Request $request)
    {
        // dd($request->all());
        $inputs = $request->validate([
            'billing_name' => '',
            'billing_email' => '',
            'billing_phone' => '',
            'billing_address' => '',
            'billing_country' => '',
            'billing_state' => '',
            'billing_city' => '',
            'billing_address_type' => '',
            'shipping_name' => '',
            'shipping_email' => '',
            'shipping_phone' => 'required',
            'shipping_address' => 'required',
            'shipping_country' => '',
            'shipping_state' => '',
            'shipping_city' => '',
            'shipping_address_type' => '',
            'payment_method' => '',
            'shipping_method' => '',
            'transection_id' => ''
        ]);

        // dd($request->variation_color);
        // dd($request->variation_size);

        $user = Auth::user();

        if ($user == null) {
            $user = User::create([
                'name'  =>   $inputs['shipping_name'],
                // 'email'  =>   $inputs['shipping_email'],
                'phone'  =>   $inputs['shipping_phone'],
                'address'  =>   $inputs['shipping_address'],
            ]);
        }


        $checkinguser = User::where('phone', $inputs['shipping_phone'])->first();

        if ($checkinguser == null) {

            $ord_phn = $user->phone;
        } else {
            $ord_phn = $checkinguser->phone;
        }

        $shipping_rule = Shipping::find($inputs['shipping_method'])->shipping_rule;
        $shipping_id = $inputs['shipping_method'];

        $couponCode = isset($coupon['code']) ? $coupon['code'] : null;
        $total = $this->calculateCartTotal(
            $user,
            1235,
            $shipping_id
        );

        $data = [];
        $data['order_id'] = rand(100, 10000);

        $data['user_id'] =  $user->id;
        $data['product_qty'] = $request->product_qty;
        $data['payment_method'] = $request->payment_method;
        $data['shipping_method'] = $shipping_rule;
        $data['ordered_delivery_date'] = $request->ordered_delivery_date;
        $data['ordered_delivery_time'] = $request->ordered_delivery_time;
        $data['total_amount'] = $request->total_amount;
        // $data['coupon_coast'] = $total["coupon_price"];
        // $data['shipping_cost'] = $total["shipping_fee"];
        $data['order_status'] = 0;
        $data['cash_on_delivery'] = 0;
        $data['additional_info'] = 0;
        $data['assign_id'] = User::inRandomOrder()->first()->id;

        // Order Assign Among Users Start

        $assign_user_id = 1;
        $users = User::whereHas('roles', function ($query) {
            $query->where('roles.name', 'Employee');
        })->where('active_status', 1)
            ->select('id')
            ->pluck('id')->toArray();

        $ordering = count($users) - 1;
        if (count($users) == 1) {
            $assign_user_id = $users[0];
        } else if ($ordering > 0) {
            $order = Order::latest()->take($ordering)->get()->pluck('assign_user_id')->toArray();

            $output = array_merge(array_diff($order, $users), array_diff($users, $order));

            if (!empty($output)) {
                $assign_user_id = $output[0];
                $data['assign_user_id'] = $assign_user_id;
            } else {
                $data['assign_user_id'] = $assign_user_id;
            }
        }


        // Order Assign Among Users End.
        try {
            DB::beginTransaction();
            $order = Order::create($data);
            if ($order) {

                $cart = session()->get('cart', []);
                $orderProduct = OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'seller_id' => 0,
                    'product_name' => $request['product_name'],
                    'unit_price' => $request['price'],
                    'qty' => $request->product_qty,
                    'variation_color_id' => $request->variation_color,
                    'variation' => $request->variation_size
                ]);



                //    $single_product = Product::find($orderProduct->product_id);
                //    $single_product->sold_qty = $orderProduct;
                //   $orderProduct->save();


                $order->orderAddress()->create([
                    'billing_name' =>  $request->billing_name,
                    'billing_email' => $request->billing_email,
                    'billing_phone' =>  $request->billing_phone,
                    'billing_address' =>  $request->billing_address,
                    'billing_country' =>  $request->billing_country,
                    'billing_state' =>  $request->billing_state,
                    'billing_city' =>  $request->billing_city,
                    'billing_address_type' =>  $request->billing_address_type,
                    'shipping_name' => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' =>  $request->shipping_phone,
                    'shipping_address' =>  $request->shipping_address,
                    'shipping_country' =>  $request->shipping_country,
                    'shipping_state' =>  $request->shipping_state,
                    'shipping_city' =>  $request->shipping_city,
                    'shipping_address_type' =>  $request->shipping_address_type,
                    'payment_method' => $request->payment_method,
                    'shipping_method' => $request->shipping_method,
                    'transection_id' => $request->transection_id,
                ]);
            }

            DB::commit();

            session()->put('cart', []);
            session()->put('coupon', []);

            return response()->json([
                'success' => true,
                'msg' => 'Order placed successfully',
                'url' => route('front.order-thanks-page', $ord_phn)
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function stateByCountry($id)
    {
        $states = CountryState::where(['status' => 1, 'country_id' => $id])->get();
        $html = "<option value=''>Please Select One</option>";
        foreach ($states as $state) {
            $html .= "<option value='" . $state->id . "'>" . $state->name . "</option>";
        }
        return response()->json(['states' => $states, 'html' => $html]);
    }

    public function cityByState($id)
    {
        $cities = City::where(['status' => 1, 'country_state_id' => $id])->get();
        $html = "<option value=''>Please Select One</option>";
        foreach ($cities as $city) {
            $html .= "<option value='" . $city->id . "'>" . $city->name . "</option>";
        }

        return response()->json(['cities' => $cities, 'html' => $html]);
    }

    public function calculateCartTotal(
        $user,
        $request_coupon,
        $request_shipping_method_id
    ) {
        $total_price = 0;
        $coupon_price = 0;
        $shipping_fee = 0;
        $productWeight = 0;

        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            $notification = trans("Your shopping cart is empty");

            return response()->json(["status" => false, "msg" => $notification]);
        }

        foreach ($cart as $index => $cartProduct) {
            $variantPrice = 0;

            if (!empty($cartProduct['check_variation'])) {

                $item = ProductVariant::where('product_id', $cartProduct['product_id'])->where('size_id', $cartProduct['variation_size_id'])->first();

                if ($item) {
                    $variantPrice = $item->sell_price;
                }
            } else {
            }

            $product = Product::select(
                "id",
                "price",
                "offer_price",
                "weight"
            )->find($cartProduct['product_id']);

            $price = $product->offer_price
                ? $product->offer_price
                : $product->price;

            $price = $variantPrice > 0 ? $variantPrice : $price;
            $weight = $product->weight;
            $weight = $weight * $cartProduct['quantity'];
            $productWeight += $weight;
            $isFlashSale = FlashSaleProduct::where([
                "product_id" => $product->id,
                "status" => 1,
            ])->first();

            $today = date("Y-m-d H:i:s");

            if ($isFlashSale) {
                $flashSale = FlashSale::first();
                if ($flashSale->status == 1) {
                    if ($today <= $flashSale->end_time) {
                        $offerPrice = ($flashSale->offer / 100) * $price;
                        $price = $price - $offerPrice;
                    }
                }
            }

            $price = $price * $cartProduct['quantity'];
            $total_price += $price;
        }


        // calculate coupon coast

        if ($request_coupon) {
            $coupon = Coupon::where([
                "code" => $request_coupon,
                "status" => 1,
            ])->first();

            if ($coupon) {
                if ($coupon->expired_date >= date("Y-m-d")) {
                    if ($coupon->apply_qty < $coupon->max_quantity) {
                        if ($coupon->offer_type == 1) {
                            $couponAmount = $coupon->discount;

                            $couponAmount =
                                ($couponAmount / 100) * $total_price;
                        } elseif ($coupon->offer_type == 2) {
                            $couponAmount = $coupon->discount;
                        }

                        $coupon_price = $couponAmount;
                        $qty = $coupon->apply_qty;
                        $qty = $qty + 1;
                        $coupon->apply_qty = $qty;
                        $coupon->save();
                    }
                }
            }
        }

        $shipping = Shipping::find($request_shipping_method_id);

        if (!$shipping) {
            return response()->json(
                ["message" => trans("Shipping method not found")],
                403
            );
        }

        if ($shipping->shipping_fee == 0) {
            $shipping_fee = 0;
        } else {
            $shipping_fee = $shipping->shipping_fee;
        }

        $total_price = $total_price - $coupon_price + $shipping_fee;

        $total_price = str_replace(
            ['\'', '"', ",", ";", "<", ">"],
            "",
            $total_price
        );

        $total_price = number_format($total_price, 2, ".", "");

        $arr = [];
        $arr["total_price"] = $total_price;
        $arr["coupon_price"] = $coupon_price;
        $arr["shipping_fee"] = $shipping_fee;
        $arr["shipping"] = $shipping;
        return $arr;
    }

    public function storeOrder() {}

    //Bkash Payment
    public function authHeaders()
    {
        return array(
            'Content-Type:application/json',
            'Authorization:' . Session::get('bkash_token'),
            'X-APP-Key:' . $this->bkash_app_key,
        );
    }

    public function curlWithBody($url, $header, $method, $body_data_json)
    {
        $curl = curl_init($this->base_url . $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body_data_json);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function grant()
    {
        $header = array(
            'Content-Type:application/json',
            'username:' . $this->bkash_username,
            'password:' . $this->bkash_password,
        );
        $header_data_json = json_encode($header);

        $body_data = array('app_key' => $this->bkash_app_key, 'app_secret' => $this->bkash_app_secret);
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/token/grant', $header, 'POST', $body_data_json);

        $token = json_decode($response)->id_token;

        return $token;
    }

    public function pay(Request $request)
    {
        Session::forget('payment_amount');
        Session::put('payment_amount', Session::get('total_order_amount'));
        return view('CheckoutURL.pay');
    }

    public function create(Request $request)
    {
        Session::forget('bkash_token');
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header = $this->authHeaders();

        $body_data = array(
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => 'https://www.fashion2.wowdmacademy.com/user/checkout/bkash/checkout-url/callback',
            'amount' => Session::get('payment_amount'),
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => Session::get('invoice_number')
        );
        $body_data_json = json_encode($body_data);
        $response = $this->curlWithBody('/tokenized/checkout/create', $header, 'POST', $body_data_json);
        // dd($response);
        Session::forget('paymentID');
        Session::forget(['total_order_amount', 'invoice_number']);
        Session::put('paymentID', json_decode($response)->paymentID);

        return redirect((json_decode($response)->bkashURL));
    }

    public function execute($paymentID)
    {

        $header = $this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID
        );
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/execute', $header, 'POST', $body_data_json);
        return $response;
    }

    public function query($paymentID)
    {

        $header = $this->authHeaders();

        $body_data = array(
            'paymentID' => $paymentID,
        );
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/status', $header, 'POST', $body_data_json);
        return $response;
    }

    public function callback(Request $request)
    {
        $allRequest = $request->all();
        // dd($allRequest);
        if (isset($allRequest['status']) && $allRequest['status'] == 'failure') {
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Failure'
            ]);
        } else if (isset($allRequest['status']) && $allRequest['status'] == 'cancel') {
            return view('CheckoutURL.fail')->with([
                'response' => 'Payment Cancell'
            ]);
        } else {

            $response = $this->execute($allRequest['paymentID']);

            $arr = json_decode($response, true);

            if (array_key_exists("statusCode", $arr) && $arr['statusCode'] != '0000') {
                return view('CheckoutURL.fail')->with([
                    'statusMessage' => $arr['statusMessage'],
                ]);
            } else if (array_key_exists("message", $arr)) {
                // if execute api failed to response
                sleep(1);
                $queryResponse = $this->query($allRequest['paymentID']);
                // dd($queryResponse);
                if ($queryResponse['transactionStatus'] == 'Completed' && $queryResponse['statusMessage'] == 'Successful') {
                    try {
                        $order = Order::firstWhere(['order_id' => $queryResponse['merchantInvoice']]);
                        if ($order) {
                            $order->transection_id = $queryResponse['trxID'];
                            $order->payment_status = 1;
                            if ($order->save()) {
                                $order_payment = OrderPayment::create([
                                    'order_no' => $queryResponse['merchantInvoice'],
                                    'amount' => $queryResponse['amount'],
                                    'payment_method' => 'bkash',
                                    'transaction_type' => 'bkash_payment',
                                    'transaction_id' => $queryResponse['trxID'],
                                    'transaction_date' => $queryResponse['paymentExecuteTime'],
                                    'account_no' => $queryResponse['payerReference'],
                                    'currency' => $queryResponse['currency'],
                                    'status' => $queryResponse['transactionStatus'],
                                ]);

                                if ($order_payment) {
                                    return to_route('front.order-thanks-page', $order->order_phone);
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        return view('CheckoutURL.fail')->with([
                            'statusMessage' => 'Payment Transaction Failed!',
                        ]);
                    }
                }
                // return view('CheckoutURL.success')->with([
                //     'response' => $queryResponse
                // ]);
            }

            return view('CheckoutURL.success')->with([
                'response' => $response
            ]);
        }
    }

    public function getRefund(Request $request)
    {
        return view('CheckoutURL.refund');
    }

    public function refund(Request $request)
    {
        Session::forget('bkash_token');
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header = $this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'amount' => $request->amount,
            'trxID' => $request->trxID,
            'sku' => 'sku',
            'reason' => 'Quality issue'
        );

        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund', $header, 'POST', $body_data_json);
        // your database operation
        return view('CheckoutURL.refund')->with([
            'response' => $response,
        ]);
    }


    public function getRefundStatus(Request $request)
    {
        return view('CheckoutURL.refund-status');
    }

    public function refundStatus(Request $request)
    {
        Session::forget('bkash_token');
        $token = $this->grant();
        Session::put('bkash_token', $token);

        $header = $this->authHeaders();

        $body_data = array(
            'paymentID' => $request->paymentID,
            'trxID' => $request->trxID,
        );
        $body_data_json = json_encode($body_data);

        $response = $this->curlWithBody('/tokenized/checkout/payment/refund', $header, 'POST', $body_data_json);

        return view('CheckoutURL.refund-status')->with([
            'response' => $response,
        ]);
    }

    //SSLCommerz Payment
    public function sslcommerzWebView(Request $request)
    {
        $sslcommerzPaymentInfo = SslcommerzPayment::first();
        $user = Session::get("user");
        $coupon = $request->coupon;
        $token = Str::random(32);
        Session::put("coupon", $request->coupon);
        $total_price = Session::get('total_order_amount');
        return view("sslcommerz_webview", compact("total_price", "sslcommerzPaymentInfo", "token", "user"));
    }

    public function sslcommerz(Request $request)
    {
        $user = Session::get("user");
        $coupon = Session::get("coupon");
        $total_price = Session::get('total_order_amount');
        $sslcommerzPaymentInfo = SslcommerzPayment::first();

        $post_data = [];
        $post_data["total_amount"] = $total_price; # You cant not pay less than 10
        $post_data["currency"] = $sslcommerzPaymentInfo->currency_code;
        $post_data["tran_id"] = strtoupper(uniqid());

        // # CUSTOMER INFORMATION

        $post_data["cus_name"] = $user->name;
        $post_data["cus_email"] = $user->email;
        $post_data["cus_add1"] = "";
        $post_data["cus_add2"] = "";
        $post_data["cus_city"] = "";
        $post_data["cus_state"] = "";
        $post_data["cus_postcode"] = "";
        $post_data["cus_country"] = "Bangladesh";
        $post_data["cus_phone"] = $user->phone;
        $post_data["cus_fax"] = "";

        # SHIPMENT INFORMATION

        $post_data["ship_name"] = "";
        $post_data["ship_add1"] = "";
        $post_data["ship_add2"] = "";
        $post_data["ship_city"] = "";
        $post_data["ship_state"] = "";
        $post_data["ship_postcode"] = "";
        $post_data["ship_phone"] = "";
        $post_data["ship_country"] = "";
        $post_data["shipping_method"] = "NO";
        $post_data["product_name"] = "Test Product";
        $post_data["product_category"] = "Package";
        $post_data["product_profile"] = "Package";

        config([
            "sslcommerz.apiCredentials.store_id" =>
            $sslcommerzPaymentInfo->store_id,
        ]);

        config([
            "sslcommerz.apiCredentials.store_password" =>
            $sslcommerzPaymentInfo->store_password,
        ]);

        config([
            "sslcommerz.success_url" => "/user/checkout/sslcommerz-success",
        ]);

        config(["sslcommerz.failed_url" => "/user/checkout/sslcommerz-failed"]);

        $sslc = new SslCommerzNotification(config("sslcommerz"));
        $payment_options = $sslc->makePayment($post_data, "checkout", "json");

        if (!is_array($payment_options)) {
            print_r($payment_options);

            $payment_options = [];
        }
    }

    public function sslcommerz_success(Request $request)
    {
        // dd($request->all());
        $tran_id = $request->input("tran_id");
        $amount = $request->input("amount");
        $currency = $request->input("currency");
        $sslcommerzPaymentInfo = SslcommerzPayment::first();

        config([
            "sslcommerz.apiCredentials.store_id" =>
            $sslcommerzPaymentInfo->store_id,
        ]);

        config([
            "sslcommerz.apiCredentials.store_password" =>
            $sslcommerzPaymentInfo->store_password,
        ]);

        config([
            "sslcommerz.success_url" => "/user/checkout/sslcommerz-success",
        ]);

        config(["sslcommerz.failed_url" => "/user/checkout/sslcommerz-failed"]);
        $sslc = new SslCommerzNotification(config("sslcommerz"));
        $invoice_no = Session::get('invoice_number');
        $order = Order::firstWhere(['order_id' => $invoice_no]);
        $payment_id = $request->get("payment_id");
        $validation = $sslc->orderValidate(
            $request->all(),
            $tran_id,
            $amount,
            $currency
        );

        if ($validation == true) {
            try {
                if ($order) {
                    // $order->transection_id = $payment_id;
                    $order->transection_id = $tran_id;
                    $order->payment_status = 1;
                    if ($order->save()) {
                        $order_payment = OrderPayment::create([
                            'order_no' => $invoice_no,
                            'amount' => $amount,
                            'payment_method' => 'ssl_commerz',
                            'transaction_type' => $request->card_type,
                            'transaction_id' => $tran_id,
                            'transaction_date' => $request->tran_date,
                            'account_no' => $request->bank_tran_id,
                            'currency' => $request->currency,
                            'status' => $request->status,
                        ]);

                        // dd($order_payment);

                        if ($order_payment) {
                            return to_route('front.order-thanks-page', $order->order_phone);
                        }
                        // return response()->json(
                        //         ["message" => trans("Order Successfully")]
                        //     );
                    }
                }
            } catch (\Exception $e) {
                return response()->json(
                    ["message" => $e->getMessage()],
                    403
                );
            }
        } else {
            // return response()->json(
            //     ["message" => trans("Payment Failed")],
            //     403
            // );

            return view('CheckoutURL.fail')->with([
                'statusMessage' => 'Payment Transaction Failed!',
                'order_inv' => $order,
            ]);
        }
    }

    public function sslcommerz_failed(Request $request)
    {
        return response()->json(["message" => trans("Payment Failed")], 403);
    }
}
