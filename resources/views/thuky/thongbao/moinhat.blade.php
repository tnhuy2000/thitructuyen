@extends('layouts.hoidongthi-layout')
@section('title','Thông báo mới nhất')

@section('css')

@endsection('css')
@section('content')

  <!-- Pricing Start -->
  <div class="container-xxl">
    <div class="container py-3">
      <h5>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-primary" href="{{route('thuky.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item text-danger active" aria-current="page">Thông báo mới nhất</li>
            </ol>
        </nav>
      </h5>  
      <div class="row g-4">
        <div class="col-lg-9">
          <div class="row">

     
        <h6 class="text-secondary text-uppercase"><i class="fas fa-star"></i> Thông báo mới nhất</h6>
          <div class="card">
            <div class="card-body">
              <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
                <h5 class="text-uppercase fw-bold">{{$thongbao->tieude}}</h5>
              </div>
            
              <h6 class="text-muted"><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $thongbao->created_at)->format('d/m/Y') }}</h6>
              <hr>
              <p class="mt-3"> {!! $thongbao->noidung !!}</p>

              @if($thongbao->loai=='dinhkem')
              <h5 class="card-title">Tập tin đính kèm thông báo:</h5>

              
              <!-- Table with stripped rows -->
              <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th width="4%">#</th>
                    <th width="45%">Tên tài liệu</th>
                    <th width="10%">Lượt tải</th>
                    <th width="10%">Tải về</th>
                    
                </tr>
              </thead>
              <tbody>
              @foreach($vanban as $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            
                            <td class="text-justify">
                                <span class="font-weight-bold text-primary">{{ $value->tenvanban }}</span>
                            </td>
                            <td>{{ $value->luotdownload }}</td>
                            <td ><a class="btn btn-primary btn-sm" target="_blank" href="{{route('thuky.thongbao.taivanban',['id'=>$value->id])}}"><i class="fas fa-download"></i></a></td>
                            
                        </tr>
              @endforeach
              </tbody>
              </table>
              <!-- End Table with stripped rows -->
                  @endif

            </div>
          </div>
            
        </div>  
      </div>    
      <div class="col-lg-3">
        <h6 class="text-secondary text-uppercase"><i class="fas fa-bullhorn"></i> Thông báo khác</h6>
        <marquee direction="down" height="500px" onmouseover="stop()" onmouseout="start()">
        @foreach($thongbao_cu as $value)
            @if($value->id !=$thongbao->id)
            <div class="card mb-3 bg-light h-100">
            
                <div class="card-body">
                  <h5 class="card-title"><a href="{{ route('thuky.thongbao.chitiet', ['id' => $value->id]) }}">{{ $value->tieude }}</a></h5>
                  @if($value->loai=='dinhkem')
                    <h6 class="card-text small"><span class="badge bg-info">Văn bản - đính kèm</span></h6>
                @endif
                  <h6 class="card-text small">Ngày đăng: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</h6>
                  
                </div>
                <div class="card-footer">
                <a href="{{ route('thuky.thongbao.chitiet', ['id' => $value->id]) }}" class="btn btn-primary">Xem tiếp <i class="bi bi-arrow-right-circle"></i></a>
                </div>
            
            </div>
            @endif
          @endforeach
          </marquee>
        </div>
        
      </div>

    <!-- Pricing End -->
    </div>
    </div>
  @endsection