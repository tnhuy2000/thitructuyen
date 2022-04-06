<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 
  <title>@yield('pagetitle', 'Trang chủ') - {{ config('app.short_name', 'OnlineExams') }}</title>
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

  <link rel="stylesheet" href="{{ asset('public/js/ijaboCropTool/ijaboCropTool.min.css') }}">
  <!-- Vendor CSS Files -->
  <link href="{{asset('public/themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> --}}
  

  @yield('css')
   
    
  <!-- Template Main CSS File -->
    <link href="{{asset('public/themes/css/style.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('public/select/select2.css')}}" rel="stylesheet"/> -->
     <link href="{{asset('public/select/demo.css')}}" rel="stylesheet" type="text/css"/>
     <link rel="stylesheet" href="{{ asset('public/vendor/datatables/datatables-1.10.22/css/dataTables.bootstrap4.min.css') }}" />
      
     @toastr_css
    
     <script src="{{asset('public/select/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('public/select/select2.js')}}"></script> 

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  

    
</head>