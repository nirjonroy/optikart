<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Brand;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\ChildCategory;
use App\Models\CollectionBanner;
use App\Models\FlashSaleProduct;
use App\Models\FooterLink;
use App\Models\Footer;
use App\Models\HomeBottomSetting;
use DB;
use App\Models\CustomPage;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $slider = Slider::where('status', 1)
            ->orderBy('serial')
            ->get();
        $home_bottom_settings = HomeBottomSetting::all();
        $offer = AboutUs::find('2');
        $feateuredCategories = featuredCategories();
        $popularCats = popularCategories();

        $popularProducts = [];

        foreach ($popularCats as $pCats) {
            $poProducts = Product::where('category_id', $pCats->category_id)->where('is_recommended', 1)->orderBy("priority", "DESC")->limit(12)->get();
            $popularProducts[$pCats->category_id] = $poProducts;
        }

        $bestSellerProducts = collect($popularProducts)
            ->flatMap(function ($group) {
                return $group;
            })
            ->unique('id')
            ->take(12);

        if ($bestSellerProducts->isEmpty()) {
            $bestSellerProducts = Product::orderBy('sold_qty', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(12)
                ->get();
        }

        $products = Product::with(['category', 'subCategory', 'childCategory'])
            ->latest()
            ->take(25)
            ->get();
        $comp_pro = Product::latest()->get();

        $products = Product::with('category', 'subCategory', 'childCategory', 'brand')
            ->whereHas('brand', function ($q) {
                $q->whereSlug(request('slug'));
            })
            ->get();
        $cat_wise_prod = Category::with('subCategories', 'products', 'activeSubCategories')
            ->has('products')
            ->where('status', 1)
            ->latest()
            ->get();

        $about = DB::table('about_us')->first();

        $flashSell = FlashSaleProduct::with('product')->limit(10)->where('status', 1)->latest()->get();
        $firstColumns  = FooterLink::where('column', 1)->get();
        $secondColumns = FooterLink::where('column', 2)->get();
        $thirdColumns  = FooterLink::where('column', 3)->get();

        $title  = Footer::first();
        $brands = Brand::where('status', 1)->get();

        $cart = session()->get('cart', []);


        $trendingProduct = Product::orderBy('sold_qty', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        $onSale = Product::orderBy('sold_qty', 'desc')
            ->get();
        $hotDeals = Product::with("gallery")->selectRaw('*, (price - offer_price) as diff')
            ->orderBy('diff', 'desc')->limit(3)->get();



        // Step 1: Get the top 3 products with the highest discount percentage
        $topDiscountedProducts = Product::selectRaw('*, ((price - offer_price) / price) * 100 as discount_percentage')
            ->where('offer_price', '>', 0)  // Only consider products with an offer price
            ->orderBy('discount_percentage', 'desc')  // Order by the highest discount percentage
            ->take(3)  // Limit to top 3 products
            ->get();

        // Step 2: Find the minimum discount percentage from the top 3 products
        $minDiscountPercentage = $topDiscountedProducts->min('discount_percentage');
        // floor
        $minDiscountPercentage = floor($minDiscountPercentage);
        // Step 3: Get 3 products that have a discount percentage greater than or equal to the minimum
        $productsWithMinDiscount = Product::selectRaw('*, ((price - offer_price) / price) * 100 as discount_percentage')
            ->where('offer_price', '>', 0)
            ->having('discount_percentage', '>=', $minDiscountPercentage)  // Filter by the minimum discount percentage dynamically
            ->orderBy('discount_percentage', 'desc')
            ->take(3)
            ->get();

        $newProducts = Product::orderBy('created_at', 'desc')->limit(12)->get();
        $bestSellers = Product::orderBy('sold_qty', 'desc')->limit(3)->get();
        $hotDeals = Product::selectRaw('*, (price - offer_price) as diff')->orderBy('diff', 'desc')->limit(3)->get();
        $flashSell3 = FlashSaleProduct::with('product')->limit(3)->where('status', 1)->latest()->get();
        $flashSell3 = $flashSell3->map(function ($flashSell3) {
            return $flashSell3->product;
        });

        $data = [
            [
                "title" => "$minDiscountPercentage%+ OFF",
                "products" => $productsWithMinDiscount,
            ],
            [
                "title" => "New Products",
                "products" => $newProducts,
            ],
            [
                "title" => "Best Sellers",
                "products" => $bestSellers,
            ],
            [
                "title" => "Hot Deals",
                "products" => $hotDeals,
            ],
            [
                "title" => "Flash Sell",
                "products" => $flashSell3,
            ],
        ];

        $collectionBanners = CollectionBanner::where('status', 1)->get();
        $collectionBanner1 = CollectionBanner::where('status', 1)->first();
        $collectionBanner2 = CollectionBanner::where('status', 1)->skip(1)->first();
        $collectionBanner3 = CollectionBanner::where('status', 1)->skip(2)->first();

        $latestBlogs = Blog::with('category', 'comments')->latest()->limit(5)->get();
        $testimonials = Testimonial::all();


        // return view('frontend.home.index', compact(
        return view('frontend.home.index', compact(
            'slider',
            'feateuredCategories',
            'products',
            'firstColumns',
            'secondColumns',
            'thirdColumns',
            'title',
            'brands',
            'flashSell',
            'cat_wise_prod',
            'cart',
            'comp_pro',
            'about',
            'popularCats',
            'popularProducts',
            'bestSellerProducts',
            'offer',
            'home_bottom_settings',
            'trendingProduct',
            'collectionBanner1',
            'collectionBanner2',
            'collectionBanner3',
            'collectionBanners',
            'latestBlogs',
            'hotDeals',
            'onSale',
            'newProducts',
            'data',
            'testimonials',


        ));
    }
    public function showProModal()
    {
        $productId = request()->productId;
        $product = Product::find($productId);
        $html = view('frontend.partials.commonModal', compact('product'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    public function subCategoriesByCategory(Request $request)
    {
        if ($request->type == 'subcategory') {
            $id = Category::whereSlug($request->slug)->first()->id;
            $categories = SubCategory::where(['category_id' => $id])->get();
            if ($categories->count() <= 0) {
                return redirect()->route('front.shop', ['slug' => $request->slug]);
            }

            return view('frontend.category.sub-category', compact('categories'));
        } else if ($request->type == 'childcategory') {
            $id = SubCategory::whereSlug($request->slug)->first()->id;
            $categories = ChildCategory::where(['sub_category_id' => $id])->get();
            if ($categories->count() <= 0) {
                return redirect()->route('front.shop', ['slug' => $request->slug]);
            }

            return view('frontend.category.child-category', compact('categories'));
        }
    }

    public function shop(Request $request, $slug = null)
    {
        $feateuredCategories = featuredCategories();
        $searchTerm = trim((string) $request->input('search', $request->input('query', '')));
        $data = null;

        if (!empty($slug)) {
            $data = Category::whereSlug($slug)->first();

            if (!$data) {
                $data = SubCategory::whereSlug($slug)->first();
            }

            if (!$data) {
                $data = ChildCategory::whereSlug($slug)->first();
            }
        }

        if ($data instanceof Category || $data instanceof SubCategory || $data instanceof ChildCategory) {
            $productsQuery = $data->products()
                ->with(['category', 'subCategory', 'childCategory', 'brand'])
                ->where('status', 1);
        } else {
            $productsQuery = Product::with(['category', 'subCategory', 'childCategory', 'brand'])
                ->where('status', 1);
        }

        if ($searchTerm !== '') {
            $productsQuery->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $searchTerm . '%');
            });
        }

        $productsQuery->latest();

        if (!($data instanceof Category) && !($data instanceof SubCategory) && !($data instanceof ChildCategory)) {
            $productsQuery->take(60);
        }

        $products = $productsQuery->get();

        if ($products->isEmpty()) {
            $minPrice = $maxPrice = 0;
            $filteredProducts = collect();
        } else {
            $minPrice = $products->min('price');
            $maxPrice = $products->max('price');

            $minPriceFilter = $request->input('min_price', $minPrice);
            $maxPriceFilter = $request->input('max_price', $maxPrice);

            $filteredProducts = $products->whereBetween('price', [$minPriceFilter, $maxPriceFilter]);

            if ($request->boolean('in_stock')) {
                $filteredProducts = $filteredProducts->where('qty', '>', 0);
            }

            if ($request->boolean('out_of_stock')) {
                $filteredProducts = $filteredProducts->where('sold_qty', '==', 'qty');
            }

            switch ($request->input('sort')) {
                case 'latest':
                    $filteredProducts = $filteredProducts->sortByDesc('created_at');
                    break;
                case 'price_low':
                    $filteredProducts = $filteredProducts->sortBy(function ($product) {
                        return $product->offer_price > 0 ? $product->offer_price : $product->price;
                    });
                    break;
                case 'price_high':
                    $filteredProducts = $filteredProducts->sortByDesc(function ($product) {
                        return $product->offer_price > 0 ? $product->offer_price : $product->price;
                    });
                    break;
            }

            $filteredProducts = $filteredProducts->values();
        }

        return view('frontend.shop.index', compact('filteredProducts', 'minPrice', 'maxPrice', 'feateuredCategories'));
    }









    public function mostSellingProducts()
    {
        $products = Product::with(['category', 'subCategory', 'childCategory'])
            ->leftJoin('order_products as op', 'products.id', '=', 'op.product_id')
            ->selectRaw('products.*, COALESCE(sum(op.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total', 'desc')
            ->take(50)
            ->get();

        return view('frontend.shop.most-selling', compact('products'));
    }



    public function flashSellProducts(Request $request)
    {
        $feateuredCategories = featuredCategories();
        $data = null;


        $products = Product::with(['category', 'subCategory', 'childCategory'])->take(30)->get();
        //dd($flashProd);
        // Apply price range filter

        $minPrice = $products->min('price');
        $maxPrice = $products->max('price');

        $minPriceFilter = $request->input('min_price', $minPrice);
        $maxPriceFilter = $request->input('max_price', $maxPrice);

        $filteredProducts = $products->whereBetween('price', [$minPriceFilter, $maxPriceFilter]);

        // Apply availability filter
        $inStock = $request->input('in_stock');
        $outOfStock = $request->input('out_of_stock');

        if ($request->input('in_stock')) {
            $filteredProducts = $filteredProducts->where('qty', '>', 0);
        }

        if ($request->input('out_of_stock')) {
            $filteredProducts = $filteredProducts->where('sold_qty', '==', 'qty');
        }

        $flashSell = FlashSaleProduct::with('product')->where('status', 1)->latest()->get();

        // return view('frontend.shop.flash-sell', compact('flashSell', 'filteredProducts', 'minPrice', 'maxPrice'));
        return view('frontend2.pages.flash-sell', compact('flashSell', 'filteredProducts', 'minPrice', 'maxPrice', 'feateuredCategories'));
    }




    public function customPages($slug)
    {
        $customPage = CustomPage::where('slug', $slug)->first();

        // dd($customPage);
        return view('frontend2.pages.custom-page', compact('customPage'));
    }
}
