<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
      
        <title>@yield('title')</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
      
        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
      
        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
      
        <!-- Vendor CSS Files -->
        <link href="{{asset('public/themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/quill/quill.snow.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
        <link href="{{asset('public/themes/vendor/simple-datatables/style.css')}}" rel="stylesheet">
        <!-- Template Main CSS File -->
        <link href="{{asset('public/themes/css/style.css')}}" rel="stylesheet">
    
      </head>
      <body>

        <main>
          <div class="container">
      
            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
              <h1> @yield('code')</h1>
              <h2> @yield('message')</h2>
             
              <img src="{{asset('public/themes/img/not-found.svg')}}" class="img-fluid">
              
            </section>
      
          </div>
        </main><!-- End #main -->
      
        {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
       --}}
        <!-- Vendor JS Files -->
        
        <script src="{{asset('public/themes/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('public/themes/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('public/themes/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/php-email-form/validate.js')}}"></script>
        <!-- Template Main JS File -->
        <script src="{{asset('public/themes/js/main.js')}}"></script>
      
      </body>
      
      </html>
