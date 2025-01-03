<div class="container position-relative d-flex align-items-center justify-content-between">
    <a href="{{ route('client.index') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">ZenBlog</h1>
    </a>

    <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="{{ route('client.index') }}" class="active">Home</a></li>
            <li class="dropdown">
                <a href="#">
                    <span>Categories</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                </a>
                <ul>
                    @foreach ($headerData['categories'] as $value)
                        <li><a href="">{{ $value }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <div class="header-social-links">
        <a href="https://github.com/baocter2004/website-tin-tuc" class="twitter"><i class="bi bi-twitter-x"></i></a>
        <a href="https://github.com/baocter2004/website-tin-tuc" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://github.com/baocter2004/website-tin-tuc" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://github.com/baocter2004/website-tin-tuc" class="linkedin"><i class="bi bi-linkedin"></i></a>
    </div>

</div>
