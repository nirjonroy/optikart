<?php

namespace App\Http\Controllers\WEB\Frontend\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\PopularPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');

        $blogsQuery = Blog::with('category', 'comments')->latest();

        if ($categorySlug) {
            $blogsQuery->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        $blogs = $blogsQuery->get();
        $recentBlogs = Blog::with('category', 'comments')->latest()->limit(5)->get();
        $popularBlogs = PopularPost::with('blog')->get();
        $activeCategory = $categorySlug ? BlogCategory::where('slug', $categorySlug)->first() : null;

        return view("frontend.blog.index", [
            'blogs' => $blogs,
            'recentBlogs' => $recentBlogs,
            'popularBlogs' => $popularBlogs,
            'activeCategory' => $activeCategory,
        ]);
        // return $popularBlogs[0]->blog->title;
    }


    public function show($slug)
    {
        $blog = Blog::with('category', 'comments')->where('slug', $slug)->first();
        return view("frontend.blog.show", [
            'blog' => $blog
        ]);
    }

    public function commentStore(Request $request)
    {
        try {
            $blogId = $request->input('blog_id');
            $name = $request->input('name');
            $email = $request->input('email');
            $commment = $request->input('comment');

            BlogComment::create([
                'blog_id' => $blogId,
                'name' => $name,
                'email' => $email,
                'comment' => $commment
            ]);

            return response()->json([
                'status' => "success",
                'message' => 'Comment submited successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "failed",
                'message' => 'Something went wrong',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
