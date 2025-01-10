<div class="top-right">
    <div class="header-menu">
        <div class="header-left">
            <button class="search-trigger"><i class="fa fa-search"></i></button>
            <div class="form-inline">
                <form class="search-form" method="GET" action="">
                    <input class="form-control mr-sm-2" name="searchKey" type="text" placeholder="Search ..." aria-label="Search">
                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                </form>
            </div>

            <div class="dropdown for-notification">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <span class="count bg-danger">3</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="notification">
                    <p class="red">You have 3 Notification</p>
                    <a class="dropdown-item media" href="#">
                        <i class="fa fa-check"></i>
                        <p>Server #1 overloaded.</p>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <i class="fa fa-info"></i>
                        <p>Server #2 overloaded.</p>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <i class="fa fa-warning"></i>
                        <p>Server #3 overloaded.</p>
                    </a>
                </div>
            </div>

            <div class="dropdown for-message">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                    <span class="count bg-primary">4</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="message">
                    <p class="red">You have 4 Mails</p>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar"
                                src="/assets/admin/images/avatar/1.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jonathan Smith</span>
                            <span class="time float-right">Just now</span>
                            <p>Hello, this is an example msg</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar"
                                src="/assets/admin/images/avatar/2.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jack Sanders</span>
                            <span class="time float-right">5 minutes ago</span>
                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar"
                                src="/assets/admin/images/avatar/3.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Cheryl Wheeler</span>
                            <span class="time float-right">10 minutes ago</span>
                            <p>Hello, this is an example msg</p>
                        </div>
                    </a>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar"
                                src="/assets/admin/images/avatar/4.jpg"></span>
                        <div class="message media-body">
                            <span class="name float-left">Rachel Santos</span>
                            <span class="time float-right">15 minutes ago</span>
                            <p>Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        @if (Auth::user())
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="user-avatar" src="{{ Storage::url(Auth::user()->image) }}" width="100px"
                        alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{ route('admin.users.show', Auth::user()->id) }}"><i
                            class="fa fa- user"></i>My Profile</a>

                    <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span
                            class="count">13</span></a>

                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                    <form action="{{ route('auth.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">
                            <i class="fa fa-power -off"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>
