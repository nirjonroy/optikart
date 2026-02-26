@extends('admin.master_layout')
@section('title')
<title>{{__('admin.Products Inventory')}}</title>
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
            <h1>{{__('admin.Products Inventory')}}</h1>

          </div>

          <div class="section-body">
            <div class="row mt-4">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="form-group">
                            <div class="col-md-12 d-flex">
                                <input class="form-control" type="text" name="q">
                                <input type="submit" class="btn btn-success" style="margin-left: 2%;">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                      <div class="table-responsive table-invoice">
                        <table class="table table-striped" id="">
                            <thead>
                                <tr>
                                    <th width="5%">{{__('admin.SN')}}</th>
                                    <th width="45%">{{__('admin.Name')}}</th>

                                    <th width="15%">Color</th>
                                    <th width="15%">Size</th>
                                    <th width="15%">QTY</th>
                                    <th width="15%">{{__('admin.Action')}}</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach ($stock_products as $index => $product)
                                    <tr>
                                        <td>{{ ++$index }}</td>
                                        <td>
                                          {{ $product->pname }}
                                        </td>
                                        <td>{{ $product->s_name }}</td>
                                        <td>{{ $product->c_name }}</td>
                                        <td>{{ $product->quantity }}</td>

                                        <td>
                                            <a class="btn btn-success btn-sm" href="{{ route('admin.stock-history', $product->id) }}"><i class="fa fa-plus" aria-hidden="true"></i></i> </a>
                                        </td>
                                    </tr>
                                  @endforeach
                            </tbody>
                        </table>
                        <p>{!! urldecode(str_replace("/?","?",$stock_products->appends(Request::all())->render())) !!}</p>
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="canNotDeleteModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                        <div class="modal-body">
                            {{__('admin.You can not delete this product. Because there are one or more order has been created in this product.')}}
                        </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('admin.Close')}}</button>
                  </div>
              </div>
          </div>
      </div>
<script>
    function deleteData(id){
        $("#deleteForm").attr("action",'{{ url("admin/product/") }}'+"/"+id)
    }
    function changeProductStatus(id){
        var isDemo = "{{ env('APP_VERSION') }}"
        if(isDemo == 0){
            toastr.error('This Is Demo Version. You Can Not Change Anything');
            return;
        }
        $.ajax({
            type:"put",
            data: { _token : '{{ csrf_token() }}' },
            url:"{{url('/admin/product-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);

            }
        })
    }
</script>
@endsection
