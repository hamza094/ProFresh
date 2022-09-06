<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ProFresh - Work on big ideas</title>

      <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{asset('img/profresh.png')}}">

    @vite(['resources/js/app.js'])

    <script>
  window.App={!! json_encode([
              'csrfToken'=>csrf_token(),
              'user'=>Auth::user(),
              'signedIn'=>Auth::check()
              ]) !!};
  </script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

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

  <div class="footer-copyright text-center py-3 ft-p">© 2021 Copyright:
    <a href="http://localhost:8000/"> Profresh.com</a>
  </div>

</footer>
   </section>-->
