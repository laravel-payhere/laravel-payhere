<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Redirecting to PayHere...') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Figtree:400&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-family: 'Figtree', sans-serif;
            --background-color: #ffffff;
            --text-color: #000000;
            --accent-color: #6b7280;
            --progress-bg-color: #deecff;
            --progress-value-color: #2A41EF;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --background-color: #111827;
                --text-color: #e5e7eb;
                --progress-bg-color: #283487;
                --progress-value-color: #5978fb;
            }
        }

        html, body {
            font-family: var(--font-family);
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--background-color);
            color: var(--text-color);
        }

        .container {
            max-width: 768px;
            margin: 0 auto;
            padding: 1rem;
        }

        h1 {
            font-size: 26px;
            font-weight: 500;
        }

        p {
            font-size: 18px;
        }

        em {
            color: var(--accent-color);
            font-size: 15px;
        }

        .progress-bar {
            height: 4px;
            background-color: var(--progress-bg-color);
            width: 100%;
            overflow: hidden;
        }

        .progress-bar-value {
            width: 100%;
            height: 100%;
            background-color: var(--progress-value-color);
            animation: indeterminateAnimation 1s infinite linear;
            transform-origin: 0 50%;
        }

        @keyframes indeterminateAnimation {
            0% {
                transform: translateX(0) scaleX(0);
            }
            40% {
                transform: translateX(0) scaleX(0.4);
            }
            100% {
                transform: translateX(100%) scaleX(0.5);
            }
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 18px;
            }

            p {
                font-size: 14px;
            }

            em {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <noscript>Your browser does not support JavaScript!</noscript>
    <div>
        <h1>Redirecting...</h1>
        <p>You will be redirected to the payment gateway in a few seconds.</p>
        <div class="progress-bar" role="progressbar" aria-valuetext="Redirecting...">
            <div class="progress-bar-value"></div>
        </div>
        <div style="margin-top: 10px">
            <em>Please do not refresh the page or click the "Back" or "Close" button of your browser.</em>
        </div>
    </div>
    <form id="checkout-form" action="{{ $data['action'] }}" method="post">
        <input type="hidden" name="merchant_id" value="{{ $data['merchant_id'] }}">
        <input type="hidden" name="notify_url" value="{{ $data['notify_url'] }}">
        <input type="hidden" name="return_url" value="{{ $data['return_url'] }}">
        <input type="hidden" name="cancel_url" value="{{ $data['cancel_url'] }}">
        <input type="hidden" name="order_id" value="{{ $data['order_id'] }}">
        <input type="hidden" name="currency" value="{{ $data['currency'] }}">
        <input type="hidden" name="amount" value="{{ $data['amount'] }}">
        <input type="hidden" name="hash" value="{{ $data['hash'] }}">
        
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
        
        @foreach ($data['items'] as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</div>
<script>
    setTimeout(function () {
        document.getElementById('checkout-form').submit();
    }, 1000);
</script>
</body>
</html>