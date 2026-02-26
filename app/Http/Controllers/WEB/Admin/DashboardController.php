<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductReport;
use App\Models\ProductReview;
use App\Models\Vendor;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Brand;
use App\Models\OrderDetails;
use DB;
use App\Models\OrderProduct;
use App\Models\OrderProductVariant;

use Carbon\Carbon;
class DashboardController extends Controller
{
    
    public function __construct() 
    {
      $this->middleware('auth');
    }

    public function dashobard(){
        if(!auth()->user()->can('admin.dashboard')){
            return redirect()->route('admin.login');
            // abort(403, 'Unauthorized action.');
        }
        
        $todayOrders            = Order::with('user','orderProducts','orderAddress')->orderBy('id','desc')->paginate(10);
        $today_orders           = Order::whereDate('created_at', date('Y-m-d'))->orderBy('id','desc')->get()->count();
        $total_orders           = Order::orderBy('id','desc')->get()->count();
        $today_pending_orders   = Order::whereDate('created_at', date('Y-m-d'))->where('order_status', '0')->get()->count();
        $total_pending_orders   = Order::where('order_status', '0')->get()->count();
        $today_completed_orders = Order::whereDate('created_at', date('Y-m-d'))->where('order_status', '3')->get()->count();
        $total_completed_orders = Order::where('order_status', '3')->get()->count();
        $today_declined_orders  = Order::whereDate('created_at', date('Y-m-d'))->where('order_status', '4')->get()->count();
        $total_declined_orders  = Order::where('order_status', '4')->get()->count();
        $setting = Setting::first();

        return view('admin.dashboard')->with([
            'todayOrders'            => $todayOrders,
            'today_orders'           => $today_orders,
            'total_orders'           => $total_orders,
            'today_pending_orders'   => $today_pending_orders,
            'total_pending_orders'   => $total_pending_orders,
            'today_completed_orders' => $today_completed_orders,
            'total_completed_orders' => $total_completed_orders,
            'today_declined_orders'  => $today_declined_orders,
            'total_declined_orders'  => $total_declined_orders,
            'setting'                => $setting
        ]);

    }

    public function order_report()
    {
        if(request()->ajax()) {
                
                   $query = OrderProduct::join('orders as o', 'order_products.order_id', 'o.id')
                            ->join('products as p', 'order_products.product_id', 'p.id')
                            ->join('order_addresses as oad','order_products.order_id', 'oad.order_id')
                            ->select(
                                'order_products.order_id',
                                DB::raw("SUM(order_products.qty) as total_qty"),
                                DB::raw("SUM(order_products.qty * order_products.unit_price) as total_payment"),
                                DB::raw("GROUP_CONCAT(order_products.product_name) as product_names")
                            )
                            ->groupBy('order_products.order_id');
           
                    if (!empty(request()->status)) {
                        $query->where('o.order_status', request()->status);
                    }
                    
                    if (!empty(request()->input('query'))) {
                        $query->where(function($query) {
                            $query->where('o.order_id', 'like', '%' . request()->input('query') . '%')
                                ->orWhere('oad.shipping_name', 'like', '%' . request()->input('query') . '%')
                                ->orWhere('oad.shipping_address', 'like', '%' . request()->input('query') . '%')
                                ->orWhere('oad.shipping_phone', 'like', '%' . request()->input('query') . '%')
                                ->orWhere('p.name', 'like', '%' . request()->input('query') . '%');
                        });
                    }
                    
                    if(!empty(request()->from && request()->to)) 
                    {
                         $query->whereBetween('o.created_at', [request()->from, request()->to]);
                    }        
                        
                    if(!empty(request()->assign))
                    {
                        $query->where('o.assign_user_id', request()->assign);
                    }
                    
                    $report_data = $query->paginate(50); 
                    $fetch_report_data = view('admin.reports.generate_report', compact('report_data'))->render();
                    return response()->json([
                        'status' => true,
                        'html'   => $fetch_report_data 
                    ]);
                }
       
            $setting = Setting::all();
            $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["Admin", "Employee"]);
                })->get();
 
        return view('admin.reports.order', compact('setting', 'users'));
    }
    
    
     public function filterOrder(Request $request)
    {    
        
        
      /*
      $details = OrderDetails::join('orders as o', 'order_details.order_id', 'o.id')
                                ->join('products as p', 'order_details.product_id', 'p.id')
                                ->join('variations as v', 'order_details.variation_id', 'v.id')
                                ->select('o.*', 'order_details.*', 'p.*', 'v.*')
                                ->where('o.date', '2023-03-15')
                                ->where('status', 'on_the_way')
                                ->paginate(20);
                                */
    
        $order_products = OrderProduct::join('orders as o', 'order_products.order_id', 'o.id')
                                ->join('products as p', 'order_products.product_id', 'p.id')
                                ->join('order_addresses as oad','order_products.order_id', 'oad.order_id')
                                // ->join('order_product_variants as v', 'order_products.variation_id', 'v.id')
                                ->select('o.*', 'order_products.*', 'p.*')
                                ->where(function($query){
                                   if(!empty(request()->status))
                                    {
                                        $query->where('o.order_status', request()->status);
                                    }  
                                    
                                    if(!empty(request()->input('query')))
                                    {
                                        $query->where('o.order_id', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('oad.shipping_name', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('oad.shipping_address', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('oad.shipping_phone', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('p.name', 'like', '%'.request()->input('query').'%');
                                    }        
                                    
                                    if(!empty(request()->from && request()->to))
                                    {
                                         $query->whereBetween('o.created_at', [request()->from, request()->to]);
                                    }        
                                    
                                    if(!empty(request()->assign))
                                    {
                                        $query->where('o.assign_id', request()->assign);
                                    }                                    
                                    
                                    
                                })
                                ->paginate(10)
                                ->appends($request->all()); 
                                
  
        // dd($order_products);
        $users = User::with('roles')->get();
        
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["Admin", "Employee"]);
                })->get();
                
        // $couriers = Courier::all();
        
        return view('admin.reports.order', compact( 'users', 'order_products'));        
      
    }

}
