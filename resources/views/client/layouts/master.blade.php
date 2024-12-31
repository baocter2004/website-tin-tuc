<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    @include('client.layouts.partials.css')
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        @include('client.layouts.partials.header')
    </header>

    <main class="main">

        @yield('content')

    </main>

    <footer id="footer" class="footer dark-background">

        @include('client.layouts.partials.footer')

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    @include('client.layouts.partials.script')

</body>

</html>
