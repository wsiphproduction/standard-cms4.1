<ul class="nav nav-aside">

    <li class="nav-item">

        <a href="{{route('home')}}" target="_blank" class="nav-link">

            <i data-feather="external-link"></i>

            <span>View Website</span>

        </a>

    </li>

    <li class="nav-label mg-t-25">CMS</li>

    <li class="nav-item @if (url()->current() == route('dashboard')) active @endif">

        <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="home"></i><span>Dashboard</span></a>

    </li>

    

    @if (auth()->user()->has_access_to_pages_module() || auth()->user()->has_access_to('pages'))

        <li class="nav-item with-sub @if (request()->routeIs('pages*')) active show @endif">

            <a href="" class="nav-link"><i data-feather="layers"></i> <span>Pages</span></a>

            <ul>

                <li @if (\Route::current()->getName() == 'pages.edit' || \Route::current()->getName() == 'pages.index' || \Route::current()->getName() == 'pages.index.advance-search') class="active" @endif><a href="{{ route('pages.index') }}">Manage Pages</a></li>

                @if(auth()->user()->has_access_to_route('pages.create'))

                <li @if (\Route::current()->getName() == 'pages.create') class="active" @endif><a href="{{ route('pages.create') }}">Create a Page</a></li>

                @endif



            </ul>

        </li>

    @endif



    @if (auth()->user()->has_access_to_albums_module() || auth()->user()->has_access_to('albums'))

        <li class="nav-item with-sub @if (request()->routeIs('albums*')) active show @endif">

            <a href="#" class="nav-link"><i data-feather="image"></i> <span>Banners</span></a>

            <ul>

                @if(auth()->user()->has_access_to('albums.edit'))<li @if (url()->current() == route('albums.edit', 1)) class="active" @endif><a href="{{ route('albums.edit', 1) }}">Manage Home Banner</a></li> @endif

                @if(auth()->user()->has_access_to('albums.index'))<li @if (\Route::current()->getName() == 'albums.index' || (\Route::current()->getName() == 'albums.edit' && url()->current() != route('albums.edit', 1))) class="active" @endif><a href="{{ route('albums.index') }}">Manage Subpage Banners</a></li> @endif

                

                @if(auth()->user()->has_access_to('albums.create'))<li @if (\Route::current()->getName() == 'albums.create') class="active" @endif><a href="{{ route('albums.create') }}">Create an Album</a></li> @endif

            </ul>

        </li>

    @endif


    <!--
    @if (auth()->user()->has_access_to_dentist_module() || auth()->user()->has_access_to('dentists'))

        <li class="nav-item with-sub @if (request()->routeIs('dentists*')) active show @endif">

            <a href="#" class="nav-link"><i class="fa fa-tooth"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Dentists</span></a>

            <ul>
                @if(auth()->user()->has_access_to('dentists.index'))<li @if (\Route::current()->getName() == 'dentists.index') class="active" @endif><a href="{{ route('dentists.index') }}">Manage Dentists</a></li> @endif
                @if(auth()->user()->has_access_to('dentists.create'))<li @if (\Route::current()->getName() == 'dentists.create') class="active" @endif><a href="{{ route('dentists.create') }}">Register Dentist</a></li> @endif
            </ul>

        </li>

    @endif
    -->

    @if (auth()->user()->has_access_to_file_manager_module() || auth()->user()->has_access_to('file-manager'))

        <li class="nav-item @if (\Route::current()->getName() == 'file-manager.index') active @endif">

            <a href="{{ route('file-manager.index') }}" class="nav-link"><i data-feather="folder"></i> <span>Files</span></a>

        </li>

    @endif



    @if (auth()->user()->has_access_to_menu_module() || auth()->user()->has_access_to('menus'))

        <li class="nav-item with-sub @if (request()->routeIs('menus*')) active show @endif">

            <a href="" class="nav-link"><i data-feather="menu"></i> <span>Menu</span></a>

            <ul>

                <li @if (\Route::current()->getName() == 'menus.edit' || \Route::current()->getName() == 'menus.index') class="active" @endif><a href="{{ route('menus.index') }}">Manage Menu</a></li>

                <li @if (\Route::current()->getName() == 'menus.create') class="active" @endif><a href="{{ route('menus.create') }}">Create a Menu</a></li>

            </ul>

        </li>

    @endif

    @if (auth()->user()->has_access_to_news_module() || auth()->user()->has_access_to_news_categories_module() || auth()->user()->has_access_to('news'))

        <li class="nav-item with-sub @if (request()->routeIs('news*') || request()->routeIs('news-categories*')) active show @endif">

            <a href="" class="nav-link"><i data-feather="edit"></i> <span>News</span></a>

            <ul>

                @if (auth()->user()->has_access_to_news_module() || auth()->user()->has_access_to('news'))

                    @if(auth()->user()->has_access_to('news.index'))<li @if (\Route::current()->getName() == 'news.index' || \Route::current()->getName() == 'news.edit'  || \Route::current()->getName() == 'news.index.advance-search') class="active" @endif><a href="{{ route('news.index') }}">Manage News</a></li>@endif

                    @if(auth()->user()->has_access_to('news.create'))<li @if (\Route::current()->getName() == 'news.create') class="active" @endif><a href="{{ route('news.create') }}">Create a News</a></li>@endif

                @endif

                @if (auth()->user()->has_access_to_news_categories_module() || auth()->user()->has_access_to('news-categories'))

                    @if(auth()->user()->has_access_to('news-categories.index'))<li @if (\Route::current()->getName() == 'news-categories.index' || \Route::current()->getName() == 'news-categories.edit') class="active" @endif><a href="{{ route('news-categories.index') }}">Manage Categories</a></li>@endif

                    @if(auth()->user()->has_access_to('news-categories.create'))<li @if (\Route::current()->getName() == 'news-categories.create') class="active" @endif><a href="{{ route('news-categories.create') }}">Create a Category</a></li>@endif

                @endif

            </ul>

        </li>

    @endif



    <li class="nav-item with-sub @if (request()->routeIs('account*') || request()->routeIs('website-settings*') || request()->routeIs('audit*')) active show @endif">

        <a href="" class="nav-link"><i data-feather="settings"></i> <span>Settings</span></a>

        <ul>

            <li @if (\Route::current()->getName() == 'account.edit') class="active" @endif><a href="{{ route('account.edit') }}">Account Settings</a></li>



            @if (auth()->user()->has_access_to_website_settings_module())

                <li @if (\Route::current()->getName() == 'website-settings.edit') class="active" @endif><a href="{{ route('website-settings.edit') }}">Website Settings</a></li>

            @endif



            @if (auth()->user()->has_access_to_audit_logs_module())

                <li @if (\Route::current()->getName() == 'audit-logs.index') class="active" @endif><a href="{{ route('audit-logs.index') }}">Audit Trail</a></li>

            @endif

        </ul>

    </li>

    @if (auth()->user()->is_an_admin() || auth()->user()->has_access_to('users'))

        <li class="nav-item with-sub @if (request()->routeIs('users*')) active show @endif">

            <a href="" class="nav-link"><i data-feather="users"></i> <span>Users</span></a>

            <ul>

                <li @if (\Route::current()->getName() == 'users.index' || \Route::current()->getName() == 'users.edit') class="active" @endif><a href="{{ route('users.index') }}">Manage Users</a></li>

                <li @if (\Route::current()->getName() == 'users.create') class="active" @endif><a href="{{ route('users.create') }}">Create a User</a></li>

            </ul>

        </li>

    @endif

    @if (auth()->user()->is_an_admin())

        <li class="nav-item with-sub @if (request()->routeIs('role*') || request()->routeIs('access*') || request()->routeIs('permission*')) active show @endif">

            <a href="" class="nav-link"><i data-feather="user"></i> <span>Account Management</span></a>

            <ul>

                <li @if (request()->routeIs('role*')) class="active" @endif><a href="{{ route('role.index') }}">Roles</a></li>

                <li @if (request()->routeIs('access*')) class="active" @endif><a href="{{ route('access.index') }}">Access Rights</a></li>

                {{-- <li @if (request()->routeIs('permission*')) class="active" @endif><a href="{{ route('permission.index') }}">Permissions</a></li> --}}

            </ul>

        </li>
        
    @endif

</ul>

