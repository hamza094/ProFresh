<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ProFresh</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/fMLpbVf/profresh.png">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


</head>
<body>
<div id="app">
    <main class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1 panel-left">
                    <div class="panel">
                        <a href="/dashboard"><img src="https://i.ibb.co/fMLpbVf/profresh.png" class="main-img" alt=""></a>

                        @if(Auth::user())
                            <router-link to="/dashboard" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-calendar"></i><span class="icon-name">Dashboard</span></span></p>
                            </router-link>
                            <router-link to="/projects" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-user-circle"></i><span class="icon-name">Projects</span></span></p>
                            </router-link>
                            <router-link to="/contacts" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-user"></i><span class="icon-name">Contacts</span></span></p>
                            </router-link>
                            <router-link to="/accounts" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-building"></i><span class="icon-name">Accounts</span> </span></p>
                            </router-link>
                            <router-link to="/deals" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-money-bill-alt"></i><span class="icon-name">Deals</span></span></p>
                            </router-link>
                        @endif

                    </div>
                </div>
                <div class="col-md-11 panel-right">

                    <nav class="navbar navbar-expand-md navbar-light bg-white">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                ProFresh
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto">

                                </ul>

                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">


                                    <!-- Authentication Links -->
                                    @guest
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <dynamic-nav class="mt-2" v-cloak>
                                            <template v-slot:trigger>
                                                <span role="button" class="nav-btn">+</span>
                                            </template>
                                            <div class="top">Records</div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <project-button></project-button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="far fa-user"></i><span>Add contact</span></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="far fa-building"></i><span>Add account</span></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="far fa-money-bill-alt"></i><span>Add deal</span></a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="top top-sales">Sales Activities</div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="fas fa-tasks"></i>
                                                            <span>Add task</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="far fa-calendar-check"></i><span>Add appointment</span></a>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="fas fa-phone-volume"></i><span>Add call log</span></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="fas fa-sms"></i><span>Send SMS</span></a>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="top top-sales">Miscellaneous</div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="far fa-envelope"></i>
                                                            <span>Send email</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="coo">
                                                        <a href=""><i class="fas fa-chart-pie"></i><span>Create report</span></a>
                                                    </div>
                                                </div>
                                            </div>

                                        </dynamic-nav>
                                        <li class="nav-item dropdown">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                    @csrf
                                                </form>

                                                <a class="dropdown-item" href="/users/{{ Auth::user()->id}}/profile">
                                                    Profile
                                                </a>
                                            </div>
                                       </li>
                                    @endguest

                                </ul>
                            </div>
                    </nav>


                @if(Auth::user())
                        <router-view>

                        </router-view>
                    @yield('panel')
                    @else
                        @yield('content')
                    @endif
                </div>
            </div>
        </div>

    </main>

    <slideout-panel></slideout-panel>

</div>
</body>
</html>
