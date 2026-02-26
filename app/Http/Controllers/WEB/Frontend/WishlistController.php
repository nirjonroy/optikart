<?php

namespace App\Http\Controllers\WEB\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $wishlists = Wishlist::with('product')->where(['user_id' => $user->id])->get();
        return view('frontend2.pages.wishlist', compact('wishlists'));
        // return response()->json([
        //     'status' => "success",
        //     "data" => $wishlists,
        // ]);
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->input("productId"),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Added to wishlist',
            ]);
        } catch (\throwable $th) {

            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function deleteWish(Request $request){
        $userId = $request->input("userId");
        $productId= $request->input("productId");

        $wish = Wishlist::where(['user_id' => $userId, 'product_id' => $productId])->first();
        $wish->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Removed from wishlist', 
        ]);

    }
}
