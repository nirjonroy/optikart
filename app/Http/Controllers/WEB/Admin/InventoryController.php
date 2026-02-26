<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Setting;
use App\Models\ProductStock;
use DB;

class InventoryController extends Controller
{
    public function index(){
      if(!auth()->user()->can('product.inventory.index')){
            abort(403, 'Unauthorized action.');
        }
        
        $products = Product::where(['vendor_id' => 0])->orderBy('id','desc')->get();

        $setting = Setting::first();
        
        $q = request()->q;

        $stock_products = DB::table('product_stocks')
            ->join('products', 'products.id', 'product_stocks.product_id')
            ->join('sizes', 'sizes.id', 'product_stocks.size_id')
            ->join('colors', 'colors.id', 'product_stocks.color_id')
            ->select('products.name as pname', 'product_stocks.quantity', 'product_stocks.id', 'sizes.title as s_name', 'colors.name as c_name')
            ->where('products.name', 'like', '%' . $q . '%')
            ->orderBy('products.id', 'DESC')
            ->paginate(20);
        
        return view('admin.inventory', compact('stock_products'))->with(['products' => $products, 'setting' => $setting]);
    }

    public function show_inventory($id){
      if(!auth()->user()->can('product.inventory.show')){
            abort(403, 'Unauthorized action.');
        }
        $product = Product::where('id', $id)->first();

        $histories = Inventory::where('product_id', $id)->orderBy('id','desc')->get();
        
         $stock_products = DB::table('product_stocks')
        ->join('products', 'products.id', 'product_stocks.product_id')
        // ->join('variations', 'variations.id', 'product_stocks.variation_id')
        ->join('sizes', 'sizes.id', 'product_stocks.size_id')
        ->join('colors', 'colors.id', 'product_stocks.color_id')
        ->select('products.name as pname', 'product_stocks.quantity', 'product_stocks.id', 'product_stocks.product_id', 'sizes.title as s_name', 'colors.name as c_name')
        ->where('product_stocks.id', $id)
        ->orderBy('products.id', 'DESC')
        ->first();
        // dd($stock_products);
        return view('admin.stock_history', compact('stock_products'))->with(['product' => $product, 'histories' => $histories]);
    }

    public function update_stock(Request $request, $id)
    {
        if (!auth()->user()->can('product.inventory.addStock')) {
            abort(403, 'Unauthorized action.');
        }
    
        // Validate the form data
        $request->validate([
            'quantity' => 'required|numeric',
        ]);
    
        // Find the product stock by ID
        $productStock = ProductStock::findOrFail($id);
    
        // Update the stock quantity
        $productStock->quantity += $request->input('quantity');
        $productStock->save();
    
        // Redirect back with success message
        $notification = trans('Added Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    public function delete_stock($id){

      if(!auth()->user()->can('product.inventory.deleteStock')){
            abort(403, 'Unauthorized action.');
        }

        $inventory = Inventory::find($id);
        $product = Product::where('id', $inventory->product_id)->first();
        $update_qty = $product->qty - $inventory->stock_in;
        $product->qty = $update_qty < 0 ? 0 : $update_qty;
        $product->save();
        $inventory->delete();

        $notification=trans('Deleted Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}
