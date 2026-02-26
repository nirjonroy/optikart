@extends('admin.master_layout')
@section('admin-content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Generate Pathao Access Token</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">{{__('admin.Dashboard')}}</a></div>
            </div>
          </div>

<div class="section-body">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <br>
                <form action="{{route('admin.generatePathaoAccessToken')}}" method="POST" id="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                    <strong for="client_id">Client ID</strong>
                                    <input type="text" id="client_id" class="form-control" name="client_id" placeholder="Client ID..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="client_secret">Client Secret</strong>
                                <input type="text" id="client_secret" class="form-control" name="client_secret" placeholder="Client Secret..." required>
                            </div>
                        </div>
                      	
                      	<div class="col-md-6">
                            <div class="form-group">
                                <strong for="client_email">Client Email</strong>
                                <input type="email" class="form-control" name="client_email" placeholder="Client Email..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="client_password">Client Password</strong>
                                <input type="password" id="client_password" class="form-control" name="client_password" required placeholder="Client Password...">
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="SUBMIT" class="btn btn-success">
                    <hr>
                </form>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> <!-- end row -->
</div>
@endsection 

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">

  
</script>

@endpush