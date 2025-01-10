<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="menu-icon fa fa-tachometer"></i>Dashboard
                    </a>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-users"></i>Users
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.users.index') }}">List</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.users.create') }}">Create</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.users.trash') }}">Trash</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-cogs"></i>Categories
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.categories.index') }}">List</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.categories.create') }}">Create</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.categories.trash') }}">Trash</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-book"></i>Articles
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.articles.index') }}">List</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.articles.create') }}">Create</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.articles.trash') }}">Trash</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-paragraph"></i>Paragraphs
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.paragraphs.index') }}">List</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.paragraphs.create') }}">Create</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.paragraphs.trash') }}">Trash</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-tag"></i>Tags
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.tags.index') }}">List</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.tags.create') }}">Create</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.tags.trash') }}">Trash</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-comments"></i>Comments
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.comments.index') }}">List</a></li>
                        <li><i class="fa fa-trash"></i><a href="{{ route('admin.comments.trash') }}">Trash</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
