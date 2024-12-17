<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="ela-news">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('admin.layouts.partials.css')
</head>

<body>
    <!-- Left Panel -->
    @include('admin.layouts.partials.left-panel')
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <header id="header" class="header">
            @include('admin.layouts.partials.top-left')

            @include('admin.layouts.partials.top-right')
        </header>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <!-- content -->
            <div class="animated fadeIn">
                <h1 class="text-center mt-3 mb-3">
                    @yield('title')
                </h1>
                @yield('content')
            </div>
            <!-- .content -->
        </div>
        <!-- /.content -->
        <div class="clearfix"></div>
        <!-- Footer -->
        <footer class="site-footer">
            @include('admin.layouts.partials.footer')
        </footer>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

    @include('admin.layouts.partials.script')
</body>

</html>
