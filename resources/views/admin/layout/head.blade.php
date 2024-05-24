<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    @yield('title')
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('admin/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('admin/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
  <link href='bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
  <script src='bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' type='text/javascript'></script>



  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/latest/css/bootstrap.css" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  {{-- <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css'> --}}
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
  <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
</head>