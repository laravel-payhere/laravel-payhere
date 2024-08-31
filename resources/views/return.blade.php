<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Payment successful') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Figtree:400&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-family: 'Figtree', sans-serif;
            --background-color: #ffffff;
            --text-color: #000000;
            --accent-color: #6b7280;
            --button-bg-color: #000000;
            --button-text-color: #ffffff;
            --button-hover-bg-color: #111827;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --background-color: #111827;
                --text-color: #e5e7eb;
                --button-bg-color: #e5e7eb;
                --button-text-color: #000000;
                --button-hover-bg-color: #d1d5db;
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
            text-align: center;
        }

        .container {
            max-width: 768px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            font-size: 36px;
            font-weight: 500;
        }

        h2 {
            font-size: 32px;
            font-weight: 500;
        }

        p {
            font-size: 18px;
        }

        em {
            color: var(--accent-color);
            font-size: 16px;
        }

        a {
            background: var(--button-bg-color);
            color: var(--button-text-color);
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        a:hover {
            background: var(--button-hover-bg-color);
        }

        @media only screen and (max-width: 600px) {
            h1 {
                font-size: 32px;
            }

            h2 {
                font-size: 28px;
            }

            em {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <svg class="check-circle" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="150" height="150" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M8.5 11.5L11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
    </svg>
    <h2>{{ __('Payment successful') }}</h2>
    <em>{{ __("We've received your payment, and it is being verified.") }}</em>
    <div style="margin-top: 3rem">
        <a href="/" aria-label="Take me to home">
            {{ __('Take me to home') }}
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 12H5m14 0-4 4m4-4-4-4"/>
            </svg>
        </a>
    </div>
</div>
</body>
</html>