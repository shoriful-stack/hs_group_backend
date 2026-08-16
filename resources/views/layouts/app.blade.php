<!doctype html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="minimal-theme" >

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="csrf-token" content="{{ csrf_token() }}">

  @include('_partials.header')
  <title>@yield('title') {{ __('HS Engineering & Technologies Ltd.') }}</title>
  <!-- 'resources/sass/app.scss',  -->
<!-- @vite(['resources/js/app.js']) -->
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
  @include('_partials.nav')
       <!--end top header-->

       <!--start sidebar -->
    @include('_partials.sidebar')
       <!--end sidebar -->

       <!--start content-->
          <main class="page-content">
            <!--breadcrumb-->
              @yield('content')

         </main>
       <!--end page main-->


       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        


  </div>
  <!--end wrapper-->

@include('_partials.footer')
@include('_partials.modal')
@include('_partials.delete-confirm')
@include('_partials.message')
@stack('scripts')

</body>

</html>