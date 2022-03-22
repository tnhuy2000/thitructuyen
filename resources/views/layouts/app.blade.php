<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">
    @yield('css')
    <link href="{{asset('public/css/login.css')}}" rel="stylesheet">
	
    
    @yield('javascript')

<body>
<br>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12 login-sec">
            <h2 class="text-center">Online Exam</h2>
            <div class="card">
                <div class="card-header">XÁC NHẬN</div>
                <div class="card-body">
                    Bạn đã đăng nhập với tên {{Auth::user()->name}}, cần đăng xuất trước khi đăng nhập làm người dùng khác.
                </div>
                <div class="card-footer">
                    <a class="btn btn-danger float-right ml-2" href="{{route('admin.dashboard')}}" onclick="event.preventDefault();">Huỷ bỏ</a>
                    <a class="btn btn-primary float-right ml-2" href="{{route('logout')}}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form1').submit();">
                    
                        <span>Thoát</span>
                    </a>
                    <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>