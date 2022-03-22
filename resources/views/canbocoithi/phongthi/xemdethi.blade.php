@extends('layouts.hoidongthi-layout')
@section('pagetitle')
	Xem đề thi
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
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('canbocoithi.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('canbocoithi.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
				<li class="breadcrumb-item text-primary" aria-current="page">{{$dethi_phongthi->maphong}}</li>
				<li class="breadcrumb-item text-danger active" aria-current="page">2. Làm bài thi</li>
			</ol>
		</nav>
		</h5>
		<div class="wow mt-2 mb-2" data-wow-delay="0.1s">
			<h3 class="">{{$dethi_phongthi->mahocphan}} - {{$dethi_phongthi->tenhocphan}}</h3>
			<button disabled class="btn" id="remaining_time">  </button>
		</div>
		<br>
		<div class="row">
			<div class="col-md-8">
				<div class="card" style="border-width: 5px;border: solid;">
					
					<div class="card-body text-center">
				
						@php $count=1; @endphp
						@foreach($dulieudethi as $value)
							<h6 class="card-title bg-dark text-white">Trang {{$count++}}</h6>
							<img src="{{$path_dethi. $value->duongdan}}" class="img-thumnail" width="650px"/>
							<hr>
							
						@endforeach
						<h6>Đề thi có tổng số: {{$count-1}} trang</h6>

					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card" style="border-width: 5px;border: solid #ff0000;">
					<div class="card-body">
						<h5><img class="" src="{{asset('public/img/clock.png')}}" width="60px" alt="">	Thời gian làm bài: {{$dethi_phongthi->thoigianlambai}} phút</h5>
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
@section('javascript')    

@endsection
