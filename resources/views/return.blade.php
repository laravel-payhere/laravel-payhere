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
<body class="antialiased">
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 selection:bg-red-500 selection:text-white">
    <div class="w-full sm:w-3/4 xl:w-1/3 mx-auto p-6">
        <div class="px-6 py-4 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex items-center focus:outline focus:outline-2 focus:outline-red-500">
            <div>
                <svg width="60" height="60" viewBox="0 0 57 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="28.5" cy="28" r="28" fill="#41D195" fill-opacity="0.12"/>
                    <path d="M28 14.6667C20.6533 14.6667 14.6666 20.6533 14.6666 28C14.6666 35.3467 20.6533 41.3333 28 41.3333C35.3466 41.3333 41.3333 35.3467 41.3333 28C41.3333 20.6533 35.3466 14.6667 28 14.6667ZM34.3733 24.9333L26.8133 32.4933C26.6266 32.68 26.3733 32.7867 26.1066 32.7867C25.84 32.7867 25.5866 32.68 25.4 32.4933L21.6266 28.72C21.24 28.3333 21.24 27.6933 21.6266 27.3067C22.0133 26.92 22.6533 26.92 23.04 27.3067L26.1066 30.3733L32.96 23.52C33.3466 23.1333 33.9866 23.1333 34.3733 23.52C34.76 23.9067 34.76 24.5333 34.3733 24.9333Z" fill="#41D195"/>
                </svg>
            </div>
            <div class="ml-6">
                <h2 class="text-xl font-semibold text-gray-900">Payment successful</h2>

                <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Your payment is currently being verified.
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
