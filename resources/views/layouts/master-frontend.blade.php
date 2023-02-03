<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    @include('layouts._frontEnd.meta')
    <title>Toko Online</title>
    {{-- style --}}
    @include('layouts._frontEnd.style')
    @stack('css')

</head>

<body>
    {{-- header --}}
    @include('layouts._frontEnd.header')
    @yield('content')
    {{-- footer --}}
    @include('layouts._frontEnd.footer')
    {{-- script --}}
    @include('layouts._frontEnd.script')
    @stack('js')
    @include('sweetalert::alert')
</body>

</html>
