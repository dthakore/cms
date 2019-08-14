<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    {{-- theme css --}}
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <!-- page level plugin styles -->
    <link rel="stylesheet" href="{{ asset('styles/climacons-font.css') }}">
    <!-- /page level plugin styles -->

    <!-- build:css({.tmp,app}) styles/app.min.css -->

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/dist/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/lib/sweet-alert.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/roboto.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/panel.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/urban.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/urban.skins.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <style>
        footer.content-footer {
            position: inherit !important;
        }
        .filing_vp{
            background-color: #30eeec;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .to_file_reply{
            background-color: #08ee8b;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .for_rejoinder{
            background-color: #6aee1c;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .for_arguments{
            background-color: #d3ee06;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .for_judgment{
            background-color: #eecd1a;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .closed{
            background-color: #ff8e12;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }
        .disposed{
            background-color: #ff104f;
            color: white;
            font-weight: 600;
            width: max-content;
            border-radius: 10px;
            padding-left: 10px;
            padding-right: 10px;
            margin-left: 10px;
        }

        .next-date{
            color: darkgreen;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }
        td > a {
            margin-left: 0px !important;
        }
        .dashboard-headings{
            font-size: 20px;
            padding-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 1px solid lightgrey;
            margin-bottom: 15px;
        }
        .ago{
            color: #9fb09f !important;
        }







    </style>
@yield('style')
    <!-- Styles -->
</head>
<body>


<div class="app layout-fixed-header">

    <!-- sidebar panel -->
    <div class="sidebar-panel offscreen-left">

        <div class="brand">

            <!-- logo -->
            <div class="brand-logo">
                <a href="{{url('/')}}"><img src="{{ url('/images/header.jpg') }}" width="120"></a>
            </div>
            <!-- /logo -->

            <!-- toggle small sidebar menu -->
            <a href="javascript:;" class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle="layout-small-menu">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </a>
            <!-- /toggle small sidebar menu -->

        </div>

        <!-- main navigation -->
        <nav role="navigation">

            <ul class="nav">
                @if($user = Auth::user())
                    @if(auth()->user()->hasRole(['admin', 'super_admin']))
                        <li>
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if(auth()->user()->hasRole(['super_admin']))
                            <li>
                                <a href="{{ url('admin/adminlist') }}">
                                    <i class="fa fa-users"></i>
                                    <span>Admin List</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ url('admin/clients') }}">
                                <i class="fa fa-users"></i>
                                <span>Clients</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/cases') }}">
                                <i class="fa fa-list"></i>
                                <span>Cases</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('admin/search/entry') }}">
                                <i class="fa fa-search"></i>
                                <span>Case entries</span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ url('/case/search') }}">
                                <i class="fa fa-search"></i>
                                <span>Search Cases</span>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
        </nav>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar panel -->
    <div class="main-panel">
        <!-- top header -->
        <header class="header navbar">
            <div class="brand visible-xs">
                <!-- toggle offscreen menu -->
                <div class="toggle-offscreen">
                    <a href="#" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <!-- /toggle offscreen menu -->
                <!-- logo -->
                <div class="brand-logo">
                    <img src="{{url('images/logo-dark.png')}}" height="15" alt="">
                </div>
                <!-- /logo -->

                <!-- toggle chat sidebar small screen-->
                <div class="toggle-chat">
                    <a href="javascript:;" class="hamburger-icon v2 visible-xs" data-toggle="layout-chat-open">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <!-- /toggle chat sidebar small screen-->
            </div>

            <ul class="nav navbar-nav hidden-xs">
                <li>
                    <p class="navbar-text">
                        {{ config('app.name', 'Laravel') }}
                    </p>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right hidden-xs">

                @if($user = Auth::user())
                    <li>
                        <a href="javascript:;" data-toggle="dropdown">
                            <img src="{{ url("images/avatar.jpg") }}" class="header-avatar img-circle ml10" alt="user" title="user">
                            <span class="pull-left">{{  Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('update/password') }}/{{\Illuminate\Support\Facades\Auth::user()->id}}">
                                   Update password
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>

                    </li>
                @endif

            </ul>
        </header>
        <!-- /top header -->

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <footer class="content-footer">

        <nav class="footer-right">
            <ul class="nav">
                <li>
                    <a href="javascript:;" class="scroll-up">
                        <i class="fa fa-angle-up"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <nav class="footer-left">
            <ul class="nav">
                <li>
                    <a href="javascript:;">Copyright <i class="fa fa-copyright"></i> <span>Chaitanya Associates</span> {{ \Carbon\Carbon::now()->format('Y') }}. All rights reserved</a>
                </li>
            </ul>
        </nav>

    </footer>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>


<script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('scripts/extentions/modernizr.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('vendor/jquery.easing/jquery.easing.js') }}"></script>
<script src="{{ asset('vendor/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('vendor/onScreen/jquery.onscreen.js') }}"></script>
<script src="{{ asset('vendor/jquery-countTo/jquery.countTo.js') }}"></script>
<script src="{{ asset('vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
<script src="{{ asset('scripts/ui/accordion.js') }}"></script>
<script src="{{ asset('scripts/ui/animate.js') }}"></script>
<script src="{{ asset('scripts/ui/link-transition.js') }}"></script>
<script src="{{ asset('scripts/ui/panel-controls.js') }}"></script>
<script src="{{ asset('scripts/ui/preloader.js') }}"></script>
<script src="{{ asset('scripts/ui/toggle.js') }}"></script>
<script src="{{ asset('scripts/urban-constants.js') }}"></script>
<script src="{{ asset('scripts/extentions/lib.js') }}"></script>
<!-- endbuild -->

<!-- page level scripts -->
<script src="{{ asset('vendor/d3/d3.min.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('vendor/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('vendor/moment/moment.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/lib/sweet-alert.js') }}"></script>
<!-- /page level scripts -->
@stack('jsfiles')
</body>
</html>
