@extends('layouts.sinhvien-layout')
@section('title','Tất cả thông báo')

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
                <li class="breadcrumb-item text-danger active" aria-current="page">Tất cả thông báo</li>
            </ol>
        </nav>
      </h5>  
      <div class="row g-4">
          
      <div class="col-lg-12">
        @foreach($thongbao as $value)
        <div class="card mb-3">
            <div class="row g-0">
              <div class="col-md-4">
                    @if($value->loai=='dinhkem')
                        <img src="{{asset('public/img/img-dinhkem.jpg')}}" class="img-fluid rounded-start" alt="...">
                    @else
                        <img src="{{asset('public/img/no-image.jpg')}}" class="img-fluid rounded-start" alt="...">
                    @endif
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">{{ $value->tieude }}</h5>
                  <p class="card-text">Ngày đăng: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</p>
                  <p><a href="{{ route('sinhvien.thongbao.chitiet', ['id' => $value->id]) }}" class="btn btn-primary">Xem tiếp <i class="bi bi-arrow-right-circle"></i></a></p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
      </div>
    <!-- Pricing End -->
    </div>
    </div>
  @endsection