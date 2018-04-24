@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.css')}} ">
    @stack('css')
    @yield('css')
@endsection


@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <img src="{{ asset('img/logo_laravel_menu.png') }}" alt="" width="50px" height="50px">
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <img src="{{ asset('img/logo_laravel_menu.png') }}" alt="" width="50px" height="50px">
                    {!! config('adminlte.logo') !!}
                </span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                      <!-- User Account: style can be found in dropdown.less -->
                      <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img class="foto_perfil img-circle" onerror="this.src='{{ asset('img/user.png') }}'"  src="{{ asset('img/user/') }}/{{ hash('sha256',Auth::user()->id_usuario) }}.png" width="32px" height="32px" alt="{{ Auth::user()->tx_name }}">
                            <span class="hidden-xs">{{ Auth::user()->tx_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                            <img class="foto_perfil img-circle" onerror="this.src='{{ asset('img/user.png') }}'"  src="{{ asset('img/user/') }}/{{ hash('sha256',Auth::user()->id_usuario) }}.png" alt="{{ Auth::user()->tx_name }}">
                            <p>
                                <small>{{ ucwords(Auth::user()->tx_funcao) }}</small>
                            </p>
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">                       
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>                                          
                            </div>                                                      
                          </li>
                        </ul>
                      </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                    <li>
                        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                            @if(config('adminlte.logout_method'))
                                {{ method_field(config('adminlte.logout_method')) }}
                            @endif
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@endsection

@section('adminlte_js')
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@endsection
