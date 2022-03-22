@extends('layouts.sinhvien-layout')
@section('pagetitle')
	Phòng thi
@endsection

@section('css')

@endsection('css')
@section('content')



  <!-- Pricing Start -->
  <div class="container-xxl">
        <div class="container py-3">
            <h5>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('sinhvien.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="#">Phòng thi của tôi</a></li>
                    <li class="breadcrumb-item text-danger" aria-current="page">{{$sinhvien_phongthi->maphong}}</li>
                    <li class="breadcrumb-item text-danger active" aria-current="page">1. Tham gia phòng điểm danh</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">1. Tham gia phòng điểm danh</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-lg-12 col-sm-9 col-md-6 text-center">
            @if(is_numeric($sinhvien_phongthi->ma_meeting))
                <h5><img src="{{asset('public/img/icon_zoom.png')}}" width="50px" alt="">
                    Zoom Meeting ID: {{$sinhvien_phongthi->ma_meeting}} 
                </h5>
            @else
                <h5><img src="{{asset('public/img/ggmeet.png')}}" width="50px" alt="">
                    Mã Google Meet: {{$sinhvien_phongthi->ma_meeting}}
                </h5>
            @endif
            <h5><a class="btn btn-primary" href="{{$sinhvien_phongthi->join_url}}" target="_blank">Tham gia phòng điểm danh <i class="fas fa-chevron-circle-right"></i></a></h5>

            </div>
            <div class="col-sm-3"></div>
            </div>
    <
            
        </div>
    </div>

    <!-- Pricing End -->


	
	
  @endsection
  @section('javascript')    
<script type="text/javascript">
  		
		
  </script>
@endsection