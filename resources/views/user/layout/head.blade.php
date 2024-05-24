<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    @yield('title')
  </title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('user/vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('user/vendor/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700">
  <link rel="stylesheet" href="{{ asset('user/vendor/owl.carousel/assets/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('user/vendor/owl.carousel/assets/owl.theme.default.css') }}">
  <link rel="stylesheet" href="{{ asset('user/css/style.default.css') }}" id="theme-stylesheet">
  <link rel="stylesheet" href="{{ asset('user/css/custom.css') }}">
  <link rel="shortcut icon" href="favicon.png">
</head>