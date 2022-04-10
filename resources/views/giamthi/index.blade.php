@extends('layouts.giamthi-layout')
@section('title','Dashboard')

@section('css')

@endsection('css')
@section('content')

    <!-- Pricing Start -->
    <div class="container-xxl">
        <div class="container py-3">
            <div class="text-center wow" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Online Exams</h6>
                <h1 class="">Phòng thi của tôi</h1>
            </div>
            <div class="row g-4">
                <!--start-->
                @php $count=0; @endphp
              @foreach($hoidongthi_phongthi as $value)
                @php $ngaygiothi=Carbon\Carbon::parse($value->ngaythi)->setTimeFromTimeString($value->giobatdau);
                $hientai = Carbon\Carbon::now();
                $hientai->addMinutes(15);
               
                $result= $hientai->greaterThanOrEqualTo($ngaygiothi);
                if($result)
                {
                @endphp
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="price-item">
                        <div class="border-bottom p-4 mb-4">
                            <h5 class="text-primary mb-1">{{$value->tenkythi}}</h5>
                            <h2 class="display-6 mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;"></small>{{$value->maphong}}<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Ca: {{$value->cathi_id}}</small>
                            </h2>
                            <h5>
                            <small>@php $ngaythi = Carbon\Carbon::createFromFormat('Y-m-d', $value->ngaythi)->format('d/m/Y'); @endphp
                            <i class="far fa-calendar-alt"></i> Ngày: {{$ngaythi}}</small>
                            </h5>
                            <h5><small><i class="far fa-clock"></i> Giờ bắt đầu: {{$value->giobatdau}} phút</small></h5>
                        </div>
                        <div class="p-4 pt-0">
                            @foreach($hoidongthi_phongthi_ds as $value1)
                              @if($value1->maphong==$value->maphong)
                              <p><i class="fa fa-check text-success me-3"></i>{{$value1->holot}} {{$value1->ten}} 
                                  @if($value1->vaitro=="thuky")
                                    (Thư ký)
                                  @elseif($value1->vaitro=="canbocoithi")
                                    (Giám thị)
                                  @endif
                              </p>
                              @endif
                            @endforeach
                            <a class="btn-slide mt-2" href="{{ route('giamthi.phongthi',['phongthi_id'=>$value->phongthi_id]) }}" class="btn btn-primary"><i class="fa fa-arrow-right"></i><span >Vào phòng</span></a>
                            </a>
                              
                        </div>
                    </div>
                </div><!--end-->
                @php

                $count++;
                  }
                @endphp             
              @endforeach
              @if($count==0)
                <div class="alert alert-warning  alert-dismissible fade show" role="alert">
                  <h4 class="alert-heading">Thông báo</h4>
                  <hr>
                  <p class="mb-0">Bạn chưa được tham gia vào bất kỳ phòng thi nào.</p>
                  
                </div>
              @endif
            </div>
        </div>
    </div>
    <!-- Pricing End -->

  @endsection