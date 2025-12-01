<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document Request System')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- NAVIGATION (optional) --}}
    <nav class="bg-[#4A7BA7] text-white px-6 py-4 shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-lg font-bold">Document Request System</div>

            <div>
                @auth
                    <span>{{ Auth::user()->name }}</span>
                @endauth
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="py-6">
        @yield('content')
    </main>

</body>
</html>
