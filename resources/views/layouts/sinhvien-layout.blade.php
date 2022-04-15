<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
 <title>@yield('pagetitle', 'Trang chủ') - {{ config('app.short_name', 'OnlineExams') }}</title>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    {{-- <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="{{ asset('public/vendor/datatables/datatables-1.10.22/css/dataTables.bootstrap4.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('public/js/ijaboCropTool/ijaboCropTool.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('public/themes_user/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/themes_user/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('public/themes_user/css/bootstrap.min.css')}}" rel="stylesheet">
    @toastr_css
    <!-- Template Stylesheet -->
    <link href="{{asset('public/themes_user/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow border-top border-5 border-primary sticky-top p-0">
        <a href="{{route('sinhvien.dashboard')}}" class="navbar-brand bg-primary d-flex align-items-center px-4 px-lg-5">
            <h2 class="mb-2 text-white">Online Exams</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                
               
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> 
                    <i class="fas fa-bell"></i> Thông báo
                    </a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="{{route('sinhvien.thongbao.moinhat')}}" class="dropdown-item"> <i class="fas fa-bullhorn"></i> Mới nhất</a>
                        <a href="{{route('sinhvien.thongbao.tatca')}}" class="dropdown-item"><i class="fas fa-book-reader"></i> Tất cả</a>    
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img width="30px" src="{{Auth::user()->picture}}" alt="Profile" class="rounded-circle user_picture">
                    <span class="user_name">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu fade-up m-0">
                        <a href="{{route('sinhvien.profile')}}" class="dropdown-item"> <i class="fas fa-user-cog"></i> Hồ sơ cá nhân</a>
                        
                        <a href="{{route('logout')}}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();" class="dropdown-item"> <i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    @yield('content')


    

     <!-- Footer Start -->
     <div class="container-fluid bg-dark text-light footer pt-5 wow fadeIn" data-wow-delay="0.1s" style="margin-top: 6rem;">
      
      <div class="container">
          <div class="copyright">
              <div class="row">
                  <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                      &copy; <a class="border-bottom" href="#">Online Exams</a>, All Right Reserved.
                  </div>
                  <div class="col-md-6 text-center text-md-end">
                     Bạn đang đăng nhập với tên: <a class="border-bottom">{{Auth::user()->name}}</a>
                      </br>Bạn có muốn thoát? <a class="border-bottom" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" href="" target="_blank">Thoát</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        </form>
                  </div>
                  
              </div>
              <br>
                  <br><br>
          </div>
      </div>
  </div>

 
  

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-0 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="{{asset('public/themes_user/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('public/themes_user/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('public/themes_user/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('public/themes_user/lib/counterup/counterup.min.js')}}"></script>
    <script src="{{asset('public/themes_user/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('public/themes_user/js/main.js')}}"></script>
    
    @jquery
    <script type="text/javascript">
        
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        };
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        };
        jQuery(document).ready(function () {
            if (getCookie('test_status') != '5') {
                $('#popup').modal('show');
                setCookie('test_status', '5', 0.1);
            }
        });
       
    
        </script>
 
  @toastr_js
  @toastr_render
  @yield('javascript')
</body>

</html>