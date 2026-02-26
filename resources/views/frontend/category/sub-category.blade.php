@extends('frontend.app')
@section('title', 'Sub Category List')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/silck/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/silck/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}">
@endpush
@section('content')

<style>
    .category:hover {
        background: #0f134f !important;
    }
    
    .category:hover p {
        color: #fff;
    }
    
    @media only screen and (min-width: 320px) and (max-width: 575px) {
        .col-lg-feaCat .p-4 {
            padding: 0.5rem !important;
        }
    }
    
</style>

<div class="container-fluid">
    <div class="main-wrapper">
        <section class="bodyTable">
            <div>
                <div class="catalogBrowser">
                    <div class="loaded">
                        <div>
                            <div class="frontPageBanners d-none">
                                <section class="storiesContainer">
                                    <div class="storiesContent">
                                        <div>
                                            <a href="sub-categories.html">
                                                <img src="assets/images/stories/_mpimage.webp" alt="">
                                            </a>
                                        </div>
                                    </div>

                                </section>
                            </div>
                            <section class="bodyWrapper">
                                <div class="categoryHeader">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item active" aria-current="page">
                                                {{ $categories[0]->category->name }}
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                    @forelse($categories as $key => $subCategory)
                                        <div class="col-lg-2 col-lg-feaCat col-md-2 col-sm-4  col-4 my-1 p-1">
                                            <a href="{{ route('front.subcategory', [
                                                'type'=>'childcategory', 
                                                'slug'=> $subCategory->slug 
                                            ] ) }}">
                                           <div class="category text-center p-4 rounded-3" style="background: #ffe8c5">
                                                @if($subCategory)
                                                     <img src="{{ asset($subCategory->image) }}" alt=""
                                                     class="" style="max-width: 75px;max-height: 48px;">
                                                     <p class="pt-3 mb-0 font-14 bold">{{ $subCategory->name }}</p>
                                                @endif
                                           </div>
                                           </a>
                                        </div>
                                    @empty
                                        <strong>No Categories are Available!</strong>
                                    @endforelse
                                </div>
                                </div>
                                
                                <div class="category-blocks-wrapper d-none">
                                    <div class="category-links-wrapper">
                                     @forelse($categories as $key => $subCategory)
                                        <a href="{{ route('front.subcategory', [
                                            'type'=>'childcategory', 
                                            'slug'=> $subCategory->slug 
                                        ] ) }}" class="category">
                                            <div>
                                                <div class="imageWrapper">
                                                    @if($subCategory)
                                                        <img src="{{ asset($subCategory->image) }}">
                                                    @else
                                                        <img src="{{ asset('frontend/nothing.png') }}">
                                                    @endif
                                                </div>
                                                <div class="name">
                                                    {{ $subCategory->name }}
                                                </div>
                                            </div>
                                        </a>
                                     @empty
                                     <strong class="text-center text-danger">No Categories are Available!</strong>
                                     @endforelse
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Modal -->
</div>    

@endsection

@push('js')
    <script src="{{ asset('frontend/silck/slick.min.js') }}"></script>
@endpush