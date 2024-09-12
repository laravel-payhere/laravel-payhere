<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>{{ __('Redirecting to PayHere') }}</title>
</head>
<body>
    <noscript>Your browser does not support JavaScript!</noscript>
    
    <p>Redirecting to PayHere...</p>
    
    <form id="checkoutForm" action="{{ $data['action'] }}" method="post">
        @foreach ($data['customer'] as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    
        @isset($data['recurring'])
            <input type="hidden" name="recurrence" value="{{ $data['recurring']['recurrence'] }}">
            <input type="hidden" name="duration" value="{{ $data['recurring']['duration'] }}">
        @endisset
    
        @isset($data['platform'])
            <input type="hidden" name="platform" value="{{ $data['platform'] }}">
        @endisset
    
        @isset($data['startup_fee'])
            <input type="hidden" name="startup_fee" value="{{ $data['startup_fee'] }}">
        @endisset
    
        @isset($data['custom_1'])
            <input type="hidden" name="custom_1" value="{{ $data['custom_1'] }}">
        @endisset
    
        @isset($data['custom_2'])
            <input type="hidden" name="custom_2" value="{{ $data['custom_2'] }}">
        @endisset
    
        @isset($data['title'])
            <input type="hidden" name="items" value="{{ $data['title'] }}">
        @endisset
    
        @foreach ($data['items'] as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    
        <input type="hidden" name="merchant_id" value="{{ $data['merchant_id'] }}">
        <input type="hidden" name="notify_url" value="{{ $data['notify_url'] }}">
        <input type="hidden" name="return_url" value="{{ $data['return_url'] }}">
        <input type="hidden" name="cancel_url" value="{{ $data['cancel_url'] }}">
        <input type="hidden" name="order_id" value="{{ $data['order_id'] }}">
        <input type="hidden" name="currency" value="{{ $data['currency'] }}">
        <input type="hidden" name="amount" value="{{ $data['amount'] }}">
        <input type="hidden" name="hash" value="{{ $data['hash'] }}">
    </form>
    <script>
        setTimeout(function () {
            document.getElementById('checkoutForm').submit();
        });
    </script>
</body>
</html>
