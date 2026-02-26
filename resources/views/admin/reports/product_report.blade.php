@extends('admin.master_layout')
@section('title')
<title>Order Reports</title>
<style>
    @media print {
        .section-header,
  		.main-sidebar,
        .print-area,
      .dataTables_length,
        .main-footer,
      	.print-btn,
      	.dataTables_filter,
      	.pagination,
      	#btnExport,
        .additional_info {
            display:none!important;
        }
        .status_section {
            display:none!important;
        }
      #sidebar-wrapper{
      		display: none !important;
      } 
      
      .main-content{
      padding-left: 0px !important;
      
      }
      
        }
        
        nav {
             float: right;
        }
        
</style>

@endsection
@section('admin-content')

<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Order Reports</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
              <div class="breadcrumb-item">Order Reports</div>
            </div>
          </div>
    
         <div class="section-body">
            <div class="row mt-4">
                <div class="col">
                  <div class="card">
                    <div class="card-body">
                        
                      <div class="col-md-12 card no-print print-area" style="box-shadow: none;">
                        <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="order_report_form" method="GET" action="">
                            <div class="col-md-4">
                                <label for="query" class="visually-hidden">Search (Name, Phone, Address)</label>
                                <input type="search" class="form-control" id="query" placeholder="Search..." name="query" value="{{ old('query') }}">
                            </div>
                          
                            <div class="col-md-4">
                                    <label for="status-select" class="me-2">Status</label>
                                    <select class="form-select form-control" id="status-select" name="status">
                                      <option value="0">Pending Order</option>
                                      <option value="1">Processing Orders</option>
                                      <option value="2">Courier Orders</option>
                                      <option value="5">On Hold Orders</option>
                                      <option value="3">Completed Orders</option>
                                      <option value="4">Cancell Orders</option>
                                      <option value="6">Return Orders</option>
                                    </select>
                            </div>                            
                             <div class="col-md-4">
                                    <label for="status-select" class="me-2">Assign By</label>
                                    <select class="form-select form-control" id="assign" name="assign">
                                        <option selected value="">Choose...</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" >{{$user->name}}</option>
                                        @endforeach
                                    </select>
                            </div>                                   
                            <div class="col-md-4">
                                    <label for="status-select" class="me-2">From:</label>
                                    <input type="date" name="from" id="from" class="form-control"/>
                            </div>                            
                            <div class="col-md-4">
                                    <label for="status-select" class="me-2">To:</label>
                                    <input type="date" name="to" id="to" class="form-control"/>
                            </div>
                            
                            <div class="col-auto">
                                <input type="submit" class="form-control btn btn-sm btn-primary report_submit" style="margin-top: 30px;" value="Submit">
                            </div>
                        </form>                            
                    </div>  
                        

                      <div class="table-responsive table-invoice">
                        <button type="button" class="btn btn-primary" id="btnExport" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end" style="float:right; margin-left: 4%;margin-bottom: 20px;">Export Report
                      </button>
                        <button class="btn btn-info print-btn" style="float: right;margin-left: 2%;">Print</button>
                        
                        <div class="report_data">
                            
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
          </div>
        </section>
    </div>  

<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script>
    $(document).ready(function () {
        
        fetchReport();
        
        $(document).on('click', ".pagination a", function(e) {
          e.preventDefault();
          $('li').removeClass('active');
          $(this).parent('li').addClass('active');
          var page = $(this).attr('href').split('page=')[1];
          fetchReport(page);
        });
        
        $(document).on('submit', 'form#order_report_form', function(e) {
            e.preventDefault();
            fetchReport();
        });
        
        function fetchReport(page=null){
            var query=$('input#query').val();
            var status = $('select[name="status"]').val();
            var assign = $('select[name="assign"]').val();
            var from = $('input[name="from"]').val();
            var to = $('input[name="to"]').val();
            
            $.ajax({
               type:'GET',
               url: '{{ route("admin.product-report") }}?page='+page,
               data:{ query,status,assign,from,to },
               success:function(res){
                  $('div.report_data').html(res.html);
               }
            });
        }
        
        $("#btnExport").click(function () {
            let table = document.getElementsByTagName("table");
            console.log(table);
            debugger;
            TableToExcel.convert(table[0], {
                name: 'UserManagement.xlsx',
                sheet: {
                    name: 'Usermanagement'
                }
            });
        });
    });
</script>
<script>
$(document).ready(function(){
    
    $(".print-btn").click(function(){
        print();
    })    

});
  
</script>

@endsection