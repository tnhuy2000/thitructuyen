<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 
  <title>@yield('pagetitle', 'Trang chủ') - {{ config('app.short_name', 'Online Exam') }}</title>
  <!-- Favicons -->
  <link href="{{asset('public/img/agulogo.png')}}" rel="icon">
  <link href="{{asset('public/img/agulogo.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

  <link rel="stylesheet" href="{{ asset('public/js/ijaboCropTool/ijaboCropTool.min.css') }}">
  <!-- Vendor CSS Files -->
  <link href="{{asset('public/themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  {{-- select2 css --}}
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <!-- Or for RTL support -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" /> 

  <link href="{{asset('public/themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('public/themes/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <style>
   .select2-results__group{
     color: rgb(27, 11, 247) !important;
     font-weight: bold !important;
   }
  </style>

  @yield('css')
   
    <script src="https://kit.fontawesome.com/44f5ed54db.js" crossorigin="anonymous"></script>
    <!-- Template Main CSS File -->
    <link href="{{asset('public/themes/css/style.css')}}" rel="stylesheet">
    
     <link rel="stylesheet" href="{{ asset('public/vendor/datatables/datatables-1.10.22/css/dataTables.bootstrap4.min.css') }}" />
      
     @toastr_css



    <script src="https://kit.fontawesome.com/44f5ed54db.js" crossorigin="anonymous"></script>
    
</head>