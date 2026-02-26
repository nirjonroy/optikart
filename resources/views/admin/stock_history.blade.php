@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Stock History')}}</title>
@endsection
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{__('admin.Stock History')}}</h1>

          </div>

          <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.add-stock', $stock_products->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">{{__('admin.Product')}}</label>
                                    <input type="text" name="product" class="form-control" value="{{$stock_products->pname}}" readonly>
                                    <input type="hidden" name="product_id" class="form-control" value="{{ $stock_products->id }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <input type="text" name="" class="form-control" value="{{$stock_products->s_name}}" readonly>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="">Color</label>
                                    <input type="text" name="" class="form-control" value="{{$stock_products->c_name}}" readonly>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('admin.Stock In Quantity')}}</label>
                                    <input type="number" name="" value="{{$stock_products->quantity}}" class="form-control" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Add new stock</label>
                                    <input type="number" name="quantity" value="0" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">{{__('admin.Add Stock')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div>

      

<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/delete-stock/") }}'+"/"+id)
    }
</script>
@endsection
