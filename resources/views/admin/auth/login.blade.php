@include('admin.header')
<div id="app">
    <section class="section">
        <div class="auth-section-wrapper">
                <div class="login-thumb">
                    <img class="img" src="{{ asset('frontend/images/ecommerce.jpg') }}" alt="login-thumb"/>
                </div>
                <div class="form-area-wrapper">
                        <div class="form-content-wrapper">
                        <div class="logo">
                          <img src="{{ asset($setting->logo) }}" alt="logo"/>
                        </div>
                            <div class="card card-primary card-wrapper-auth">
                                <div class="card-body">
                                    <div class="tex-content">
                                    <h1>{{__('admin.Admin Dashboard')}}</h1>
                                    <p class="des">{{__('admin.Login Your  fashion shopping .')}} </p>
                                    </div>
                                    <form class="needs-validation" novalidate="" id="login_form_action" action="{{ route('admin.user.stuff.login') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="email">{{__('admin.Email')}}<sup>*</sup></label>
                                            <input id="email exampleInputEmail" type="email" class="form-control" name="email" tabindex="1" autofocus value="{{ old('email') }}">
                                        </div>

                                        <div class="form-group">
                                            <div class="d-block">
                                            <label for="password" class="control-label">{{__('admin.Password')}}<sup>*</sup></label>

                                            </div>
                                            <input id="password exampleInputPassword" type="password" class="form-control" name="password" tabindex="2">
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">{{__('admin.Remember Me')}}</label>
                                            </div>
                                        </div>

                                        <div class="form-group login-sub-btn">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            {{__('admin.Login')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="simple-footer">
                    {{ $setting->copyright }}
                </div>
        </div>
    </section>
  </div>
  
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
    // Function to show a toaster message
    function showToasterMessage(message, type) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 8000 // Display time in milliseconds
        };

        toastr[type](message);
    }
    </script>
  
  <script>
        $("form#login_form_action").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr("action");
        // $.ajax({
        //     url: url,
        //     type: "POST",
        //     data: form.serialize(),
        //     success: function (response) {
        //         if (response.status) {
        //             // Clear the cart or perform other actions

        //             // Show success message
        //             showToasterMessage(response.msg, "success");
                    
        //             // Redirect to a specific URL if needed
        //             window.location.href = response.url;
        //         } else {
        //             // Show error message
        //             showToasterMessage(response.msg);
        //         }
        //     },
        //     error: function (error) {
        //         // Show error message
        //         showToasterMessage("An error occurred. Please try again later.", "error");
        //     }
        // });
        
        $.ajax({
            url: url,
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                if (response.status) {
                    // Clear the cart or perform other actions
        
                    // Show success message
                    showToasterMessage(response.msg, "success");
        
                    // Redirect to a specific URL if needed
                    window.location.href = response.url;
                } else {
                    // Show error message from the server
                    showToasterMessage(response.error, "error");
                }
            },
            error: function (error) {
                // Show a generic error message if the server response doesn't include a specific error message
                var errorMessage = error.responseJSON && error.responseJSON.error ? error.responseJSON.error : "An error occurred. Please try again later.";
                showToasterMessage(errorMessage, "error");
            }
        });

        
    });
  </script>
  

@include('admin.footer')


