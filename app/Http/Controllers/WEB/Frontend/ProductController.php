<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ChildCategory;
use App\Models\FooterLink;
use App\Models\Footer;
use App\Models\ProductVariant;
use App\Models\productColorVariation;
use App\Models\ProductReview;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductGallery;
use App\Models\ProductStock;

use DB;

class ProductController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($slug)
    {

        $firstColumns  = FooterLink::where('column', 1)->get();
        $secondColumns = FooterLink::where('column', 2)->get();
        $thirdColumns  = FooterLink::where('column', 3)->get();
        $title         = Footer::first();

        $product = Product::with('variantItems', 'category', 'subCategory', 'childCategory', 'brand', 'gallery', 'variations', 'p_stock')

            ->whereSlug($slug)->firstOrFail();

        $Specification = DB::table('product_specifications')
            ->join('products', 'products.id', 'product_specifications.product_id')
            ->join('product_specification_keys', 'product_specification_keys.id', 'product_specifications.product_specification_key_id')
            ->select('product_specifications.*', 'products.name', 'product_specification_keys.key')
            ->where('product_specifications.product_id', $product->id)->get();
        // dd($Specification);

        $relatedProducts = Product::with('variantItems', 'category', 'subCategory', 'childCategory', 'brand')
            ->where('category_id', $product->category_id) // Assuming category_id is the column name
            ->where('id', '<>', $product->id) // Exclude the current product
            ->get();

        $reviews =   ProductReview::with('user', 'product')
            ->where('product_id', $product->id)
            ->where('id', '<>', $product->id)
            ->limit(5)
            ->get();




        // dd($reviews);

        // dd($product);

        return view('frontend.product.show', compact('product', 'firstColumns', 'secondColumns', 'thirdColumns', 'title', 'Specification', 'relatedProducts', 'reviews'));
    }


    public function get_variation_price(Request $request)
    {
        $price_value = ProductVariant::find($request->value)->sell_price;

        return response()->json([
            'success' => true,
            'price'  =>  $price_value
        ]);
    }


    public function get_color_price(Request $request)
    {

        $variant_data = productColorVariation::where(['product_id' => $request->product_id, 'color_id' => $request->variation_color_id])->first();
        $image_array = $variant_data->var_images;

        $check_stock = ProductStock::where('size_id', $request->variation_size_id)->where('color_id', $request->variation_color_id)
            ->where('product_id', $request->product_id)
            ->first();

        $stockQty = $check_stock->quantity;
        $html = view('frontend.product.var_img', compact('image_array'))->render();

        return response()->json([
            'stock' => $stockQty,
            'pro_img' => $image_array,
            'var_images' => $html
        ]);
    }

    public function get_product_details(Request $request)
    {
        $product = Product::find($request->productId);
        $html = view('frontend.product.get_details', compact('product'))->render();

        return response()->json([
            'status' => "success",
            "data" => $product,
            "url" => route("front.product.show", $product->slug),
        ]);
    }


  

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function searchProduct(Request $request)
    {

        $query = trim((string) $request->get('query'));

        if ($query === '') {
            return redirect()->route('front.shop');
        }

        return redirect()->route('front.shop', ['search' => $query]);
    }


    public function single_product(Request $request, $slug)
    {
        $s_product = Product::where('slug', $slug)->first();
        $id = $s_product->id;
        $firstColumns  = FooterLink::where('column', 1)->get();
        $secondColumns = FooterLink::where('column', 2)->get();
        $thirdColumns  = FooterLink::where('column', 3)->get();
        $title         = Footer::first();

        $product = Product::with('variantItems', 'category', 'subCategory', 'childCategory', 'brand', 'gallery', 'variations')

            ->findOrFail($id);
        //dd($product);
        $Specification = DB::table('product_specifications')
            ->join('products', 'products.id', 'product_specifications.product_id')
            ->join('product_specification_keys', 'product_specification_keys.id', 'product_specifications.product_specification_key_id')
            ->select('product_specifications.*', 'products.name', 'product_specification_keys.key')
            ->where('product_specifications.product_id', $id)->get();
        // dd($Specification);

        $relatedProducts = Product::with('variantItems', 'category', 'subCategory', 'childCategory', 'brand')
            ->where('category_id', $product->category_id) // Assuming category_id is the column name
            ->where('id', '<>', $product->id) // Exclude the current product
            ->limit(5) // Limit to 5 results
            ->get();

        $reviews =   ProductReview::with('user', 'product')
            ->where('product_id', $product->id) // Assuming category_id is the column name
            ->where('id', '<>', $product->id) // Exclude the current product
            ->limit(5) // Limit to 5 results
            ->get();




        // dd($reviews);

        // dd($product);

        return view('frontend.product.show', compact('product', 'firstColumns', 'secondColumns', 'thirdColumns', 'title', 'Specification', 'relatedProducts', 'reviews'));
    }


    public function brandWiseProduct()
    {
        $products = Product::with('category', 'subCategory', 'childCategory', 'brand')
            ->whereHas('brand', function ($q) {
                $q->whereSlug(request('slug'));
            })
            ->get();


        return view('frontend.product.brand-wise-product', compact('products'));
    }

    public function compare(Request $request)
    {
        $productId1 = $request->input('product1');
        $productId2 = $request->input('product2');

        $product1 = Product::with(['variantItems', 'category', 'subCategory', 'childCategory', 'brand'])
            ->findOrFail($productId1);

        $product2 = Product::with(['variantItems', 'category', 'subCategory', 'childCategory', 'brand'])
            ->findOrFail($productId2);

        $specifications1 = $product1->specifications()->with('key')->get();
        $specifications2 = $product2->specifications()->with('key')->get();

        // dd($specifications1);

        return view('frontend.product.compare-product', compact('product1', 'product2', 'specifications1', 'specifications2'));
    }

    public function reviews(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        ProductReview::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Review submitted successfully. It will be visible after approval.');
    }
}
