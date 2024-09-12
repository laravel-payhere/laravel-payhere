<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>{{ __('Redirecting to PayHere') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=ubuntu:400,500,700" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                fontFamily: {
                    sans: ["Figtree", "sans-serif"],
                },
                extend: {
                    colors: {
                        blue: {
                            700: "#2447d6",
                        },
                        yellow: {
                            500: "#fcac00",
                        },
                        black: "#09090b",
                    },
                },
            }
        }
    </script>
</head>
<body class="bg-black font-sans antialiased">
<div class="bg-gradient-to-b from-blue-700 to-black h-screen">
    <div class="absolute top-0 w-full flex justify-content-center items-center h-screen">
        <div class="flex flex-col gap-5 mx-auto max-w-7xl bg-black bg-opacity-20 px-24 py-24 rounded-2xl">
            <h1 class="text-white text-2xl font-medium">Redirecting to <span class="font-['Ubuntu']">Pay<span class="text-yellow-500">Here</span></span></h1>
            <p class="text-white">{{ __('You will be redirected to the payment gateway in a few seconds.') }}</p>
        </div>
    </div>
</div>
</body>
</html>
