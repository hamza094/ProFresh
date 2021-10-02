<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ProFresh</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script>
  window.App={!! json_encode([
              'csrfToken'=>csrf_token(),
              'user'=>Auth::user(),
              'signedIn'=>Auth::check()
              ]) !!};
  </script>

<script src="https://js.stripe.com/v3/"></script>


 <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
  

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/fMLpbVf/profresh.png">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <main class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-1 panel-left">
                    <div class="panel">
                        <a href="/"><img src="{{asset('img/profresh.png')}}" class="main-img" alt=""></a>

                        @if(Auth::user())
                            <a href="/dashboard" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-calendar"></i><span class="icon-name">Dashboard</span></span></p>
                            </a>
                            <a href="/projects" class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo far fa-user-circle"></i><span class="icon-name">Projects</span></span></p>
                            </a>
                             <project-button></project-button>
                             <a href="/api/profile/user/{{ Auth::user()->id}}" 
                                class="panel-list_item">
                                <p>
                                 <span class="icon">
                                 @if(Auth::user()->avatar_path !== null)
                                            <img src="{{Auth::user()->avatar_path}}" alt="User Avatar" class="chat-user_image" />
                                            @else
                                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvsQZEtAw99ePVsNhLCexVsSKct6D13NluBQ&usqp=CAU" alt="User Avatar" class="chat-user_image" /><span class="icon-name">Profile</span>
                                            @endif</span>                       
                                </p>
                            </a>
                             <a href="{{ route('logout') }}" 
                              onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();" 
                              class="panel-list_item">
                                <p><span class="icon"><i class="icon-logo fas fa-sign-out-alt"></i><span class="icon-name">Logout</span></span></p>
                            </a>
                        @endif
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    </form>
                    </div>
                </div>
                <div class="col-md-11 panel-right">

                    <nav class="navbar navbar-expand-md navbar-light bg-white">
                        <a class="navbar-brand" href="/dashboard">
                            <b>Dashboard</b>
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
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                        </li>
                                    @endif
                                @else
                                <notifications class="mr-3"></notifications>
                                 @endguest

                            </ul>
                        </div>
                    </nav>
