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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="https://i.ibb.co/fMLpbVf/profresh.png">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     @paddleJS
</head>
<body>
<div id="app">
    <main class="">

      <navbar></navbar>

    </main>

    <slideout-panel></slideout-panel>

</div>
</body>

   <!--<section class="footer">
     <footer class="page-footer font-small blue">

  <div class="footer-copyright text-center py-3 ft-p">© 2023 Copyright:
    <a href="http://localhost:8000/"> Profresh.com</a>
  </div>

</footer>
   </section>-->
