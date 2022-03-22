<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="{{asset('public/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    @yield('css')
    <link href="{{asset('public/css/login.css')}}" rel="stylesheet">
	
    
    @yield('javascript')
</head>
<body>

<br>
<br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 login-sec">
                <h2 class="text-center">Online Exam</h2>
                   
                          
                <form class="my-login-validation"  method="POST" action="{{ route('login') }}">
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                        <i class="bi bi-shield-x"></i> Lỗi: {{ Session::get('fail') }}
                        </div>
                    @endif
                    @if (Session::get('info'))
                        <div class="alert alert-info">
                            {{ Session::get('info') }}
                        </div>
                    @endif
                    <a type="submit" href="{{ route('google.login') }}" class="btn btn-login btn-block"><img src="{{asset('public/img/icon_gmail.png')}}" width="32px" alt="">   Đăng nhập bằng Gmail AGU</a>
                    <br>
                    
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="text-uppercase">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Session::get('verifiedEmail') ? Session::get('verifiedEmail') : old('email') }}">
                        <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        
                        
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1" class="text-uppercase">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                        
                        <span class="text-danger">@error('password'){{ $message }}@enderror</span>
                    </div>
    
                    <div class="form-check">
                        
                        <button type="submit" class="btn btn-login float-right">{{ __('Login') }}</button>
                    </div>
                    
    
                </form>
                
            </div>
            <div class="col-md-8 banner-sec">
                	   
            </div>
        </div>
    </div>
																			        
</body>
</html>
