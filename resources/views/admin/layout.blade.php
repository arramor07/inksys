<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InkTech Admin</title>

    {{-- Your CSS / Tailwind / Bootstrap here --}}
</head>

<body class="bg-black text-white">

    <div class="flex">

        {{-- Sidebar --}}
        @include('admin.sidebar')

        {{-- Page content --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>

    </div>

</body>
</html>
