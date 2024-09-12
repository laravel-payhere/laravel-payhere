<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ __('Redirecting to PayHere') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
<div class="absolute top-0 w-full flex justify-content-center items-center h-screen">
    <div class="mx-auto max-w-7xl flex items-center gap-5">
        <svg width="100" height="100" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="28.5" cy="28" r="28" fill="#41D195" fill-opacity="0.12"/>
            <path d="M28 14.6667C20.6533 14.6667 14.6666 20.6533 14.6666 28C14.6666 35.3467 20.6533 41.3333 28 41.3333C35.3466 41.3333 41.3333 35.3467 41.3333 28C41.3333 20.6533 35.3466 14.6667 28 14.6667ZM34.3733 24.9333L26.8133 32.4933C26.6266 32.68 26.3733 32.7867 26.1066 32.7867C25.84 32.7867 25.5866 32.68 25.4 32.4933L21.6266 28.72C21.24 28.3333 21.24 27.6933 21.6266 27.3067C22.0133 26.92 22.6533 26.92 23.04 27.3067L26.1066 30.3733L32.96 23.52C33.3466 23.1333 33.9866 23.1333 34.3733 23.52C34.76 23.9067 34.76 24.5333 34.3733 24.9333Z" fill="#41D195"/>
        </svg>
        <h1 class="text-black text-3xl font-medium">Payment success!</h1>
    </div>
</div>
</body>
</html>
