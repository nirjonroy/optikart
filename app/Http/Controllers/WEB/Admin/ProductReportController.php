<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReport;
use App\Models\User;
use App\Models\OrderProduct;
use DB;
class ProductReportController extends Controller
{
    public function index(){
        
        if(request()->ajax()) {
            
            $query = OrderProduct::Leftjoin("products as p", "order_products.product_id","p.id")  
                      ->Leftjoin("orders as o","o.id","order_products.order_id")              
                      ->select("p.id","p.name","order_products.unit_price",
                        DB::raw("SUM(order_products.qty) as total_qty"),
                        DB::raw("SUM(order_products.qty * order_products.unit_price) as total_price")
                       )
                      ->groupBy('p.id','p.name','order_products.unit_price'); 
                      
                   $query->where('o.order_status', request()->status);
                    
                    if (!empty(request()->input('query'))) {
                        $query->where(function($query) {
                            $query->where('o.order_id', 'like', '%' . request()->input('query') . '%')
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
                      
                    $report_data = $query->paginate(20);
                      
                    $fetch_report_data = view('admin.reports.generate_product_report', compact('report_data'))->render();
                   
                    return response()->json([
                        'status' => true,
                        'html'   => $fetch_report_data 
                    ]);
                      
        }
                
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["Admin", "Employee"]);
                })->get();        
        
        return view('admin.reports.product_report', compact('users'));
    }

    public function show($id){
        $report = ProductReport::with('user','product','seller')->find($id);
        $product = $report->product;
        $totalReport = ProductReport::where('product_id',$product->id)->count();
        return view('admin.show_product_report',compact('report','totalReport'));
    }

    public function destroy($id){
        $report = ProductReport::find($id);
        $report->delete();
        $notification=trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.product-report')->with($notification);
    }

    public function deactiveProduct($id){
        $report = ProductReport::find($id);
        $product = $report->product;
        $product->status = 0;
        $product->save();
        $notification=trans('admin_validation.Deactive Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
