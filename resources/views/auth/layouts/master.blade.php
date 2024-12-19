<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> @yield('title') </title>
    <meta name="description" content=" @yield('title') ">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('auth.layouts.partials.css')
</head>

<body class="bg-dark">

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                @include('auth.layouts.partials.logo')
                @yield('content')
            </div>
        </div>
    </div>

    @include('auth.layouts.partials.script')

</body>

</html>
