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
                    <li class="breadcrumb-item text-danger active" aria-current="page">{{$dethi_phongthi->maphong}}</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">{{$dethi_phongthi->maphong}} - {{$dethi_phongthi->tenkythi}}</h1>
            </div>
            <hr>
            <h3>Tổng quan bài làm:</h3>
            
           
            <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
            
            <div class="alert alert-dark" role="alert">
                <h5 class="text-danger">
                <i class="fas fa-calendar-minus"></i> Trạng thái bài làm: đã hoàn thành
                </h5>
            </div>
        
        
            
          </div>
            

   
        </div>
    </div>

    <!-- Pricing End -->


	
	
  @endsection
  @section('javascript')    
<script type="text/javascript">
  		
		
  </script>
@endsection