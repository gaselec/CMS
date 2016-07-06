<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('portal.home') }}" class="logo">gas-<em>elec</em></a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle hidden-lg hidden-md hidden-sm" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                @if (!Auth::guard('customer')->check())
                    <li><a href="{{ url('/portal/login') }}">Login</a></li>
                    <li><a href="{{ url('/portal/register') }}">Register</a></li>
                @else



                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::guard('customer')->user()->firstName }} {{ Auth::guard('customer')->user()->surname }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <!-- <img src="{{ asset("/bower_components/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" /> -->
                                <p>
                                    {{ Auth::guard('customer')->user()->fullName }}
                                    <small>{{ Auth::guard('customer')->user()->email }}</small>
                                </p>
                            </li>
                            <!-- Menu Body
                            <li class="user-body">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </li> -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat"><i class="fa fa-lock"></i> My Settings</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/portal/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>