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
                            50: "#f0f5fe",
                            100: "#dce8fd",
                            200: "#c1d7fc",
                            300: "#97bff9",
                            400: "#659df5",
                            500: "#4179f0",
                            600: "#2c59e4",
                            700: "#2447d6",
                            800: "#233aaa",
                            900: "#223586",
                            950: "#192252",
                        },
                        yellow: {
                            50: "#fffdea",
                            100: "#fff7c5",
                            200: "#fff085",
                            300: "#ffe146",
                            400: "#ffcf1b",
                            500: "#fcac00",
                            600: "#e28400",
                            700: "#bb5c02",
                            800: "#984708",
                            900: "#7c3a0b",
                            950: "#481d00",
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
        <div class="flex flex-col gap-5 mx-auto max-w-7xl bg-black bg-opacity-20 px-32 py-24 rounded-2xl">
            <h1 class="text-white text-2xl font-medium">Redirecting to <span class="font-['Ubuntu']">Pay<span class="text-yellow-500">Here</span></span></h1>
            <p class="text-white">{{ __('You will be redirected to the payment gateway in a few seconds.') }}</p>
        </div>
    </div>
</div>
</body>
</html>
