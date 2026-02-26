@extends('admin.master_layout')
@section('title')
<title>Create Landing Page</title>
@endsection
@section('admin-content')

<style>
    nav {
        float: right;
    }
</style>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Create A Landing Page</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">Create A Landing Page</div>
            </div>
          </div>
          <div class="col-xl-4" style="margin-bottom: 20px;padding: 0px;">
                        <div class="text-xl-end mt-xl-0 mt-2">
                            <a href="{{ route('admin.landing.create')}}" class="btn btn-primary"><i class="fas fa-plus"></i> {{__('admin.Add New')}}</a>       
                        </div>
                    </div>
          <div class="card">
                    <div class="card-body">
          <div class="table-responsive table-invoice">
                     <table class="table table-striped" id="">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Page Title</th>
                                <th>View Page</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key=> $item)
                            <tr>
                                <td> {{$key+1}} </td>
                                
                                <td> {{$item->title1}} </td>
                             
                                <td>
                                    <a href="{{ route('user.landing_index', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                              
                                <td>
                                    
                                    <a href="{{route('admin.landing_edit', $item->id)}}" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    
                                    <a href="{{ route('admin.landing_pages.destroy', [$item->id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                
                                </td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <p>{!! urldecode(str_replace("/?","?",$items->appends(Request::all())->render())) !!}</p>
            </div> </div>     
        </section>
        </div>
@endsection