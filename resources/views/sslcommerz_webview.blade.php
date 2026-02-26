<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body style="margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #e0eafc; font-family: Arial, sans-serif;">

    <div style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); padding: 25px; width: 280px; ">
        <h2 style="margin-bottom: 20px; text-align: center; color: #333;">Payment Details</h2>

        {{-- <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="font-weight: 600; color: #555;">Name:</span>
            <span style="color: #007bff;">John Doe</span>
        </div> --}}

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="font-weight: 600; color: #555;">Email:</span>
            <span style="color: #007bff;">{{ $user->email }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <span style="font-weight: 600; color: #555;">Phone:</span>
            <span style="color: #007bff;">{{ $user->phone }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <span style="font-weight: 600; color: #555;">Total Amount:</span>
            <span style="color: #28a745; font-weight: bold;">{{ $total_price }}</span>
        </div>

        <button style="width: 100%; padding: 12px 0; background-color: #007bff; color: #ffffff; border: none; border-radius: 6px; cursor: pointer; font-size: 16px;" id="sslczPayBtn"
        token="if you have any token validation" postdata=""
        order="{{json_encode([
            'amount' => $total_price,
            'cus_email' => $user->email,
            'cus_phone' => $user->phone,
            'cus_name' => $user->name,
            'currency' => 'BDT',
        ]) }}"
        endpoint="{{ route('user.checkout.sslcommerz-pay',['token' => $token]) }}">
            Next
        </button>
    </div>
{{--
<div class="tab-pane fade" id="v-sslcommerz-payment" role="tabpanel" aria-labelledby="v-sslcommerz-payment-tab">
    <button style="width:280px !important" class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
        token="if you have any token validation" postdata=""
        order="{{json_encode([
            'amount' => $total_price,
            'cus_email' => $user->email,
            'cus_phone' => $user->phone,
            'cus_name' => $user->name,
            'currency' => 'BDT',
        ]) }}"
        endpoint="{{ route('user.checkout.sslcommerz-pay',['token' => $token]) }}"> পেমেন্ট করতে এখানে ক্লিক করুন
    </button>
</div> --}}



@if ($sslcommerzPaymentInfo->mode == 'sandbox')
    <script>
        (function(window, document) {
            var loader = function() {
                var script = document.createElement("script"),
                    tag = document.getElementsByTagName("script")[0];
                script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
                    7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                loader);
        })(window, document);
    </script>
@else
    <script>
        (function (window, document) {
            var loader = function () {
                var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
                tag.parentNode.insertBefore(script, tag);
            };

            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);
    </script>
@endif
<script>
    // when load this page/ready this page click sslcommerz button don't need to show this page
    document.getElementById('sslczPayBtn').click();

</script>
</body>
</html>
