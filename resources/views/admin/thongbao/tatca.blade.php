@extends('layouts.admin-layout')
@section('title','Dashboard')

@section('content')

<main id="main" class="main">

        <div class="pagetitle">
        <h1>Tất cả thông báo</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
            <li class="breadcrumb-item active">Tất cả thông báo</li>
            
            </ol>
        </nav>
        </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->

        
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
                  <p><a href="{{ route('admin.dashboard.chitietthongbao', ['id' => $value->id]) }}" class="btn btn-primary">Xem tiếp <i class="bi bi-arrow-right-circle"></i></a></p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
       

      </div>
    </section>

  </main><!-- End #main -->


  
  @endsection