<!DOCTYPE html>
<html lang="en">

<head>
    {{-- meta --}}
    @include('layouts._auth.meta')
    {{-- style --}}
    @include('layouts._auth.style')
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                            </div>
                            {{-- content --}}
                            @yield('content')
                        </div>
                    </div>
                </div>

            </div>

        </div>
        @include('layouts._auth.script')
</body>

</html>
