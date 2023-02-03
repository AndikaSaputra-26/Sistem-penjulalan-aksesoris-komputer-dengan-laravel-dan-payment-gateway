<!DOCTYPE html>
<html lang="en">
<head>
{{-- meta --}}
@include('layouts._dashboard.meta')
{{-- style --}}
@include('layouts._dashboard.style')
@stack('css')
</head>
<body id="page-top">
    <div id="wrapper">
        {{-- sidebar --}}
        @include('layouts._dashboard.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- topbar --}}
                @include('layouts._dashboard.topbar')
                @yield('content')
            </div>
            {{-- footer --}}
            @include('layouts._dashboard.footer')
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    {{-- logout modal --}}
    @include('layouts._dashboard.logoutModal')
    @include('layouts._dashboard.edit-profile')
    {{-- script --}}
    @include('layouts._dashboard.script')
    @stack('js')
    @include('sweetalert::alert')
</body>

</html>
