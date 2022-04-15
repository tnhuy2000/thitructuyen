@extends('layouts.sinhvien-layout')
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
            <!-- <iframe src="{{asset('public/uploads/QĐ ban hanh quy dinh tam thoi thi truc tuyen 2021.pdf')}}" frameBorder="0"
    scrolling="auto" width="100%" height="1100px">
            </iframe> -->
            </div>
            <br>
            <div class="row g-4">
                <!--start-->
                @php $count=0; @endphp
              @foreach($sinhvien_phongthi as $value)
                @php $ngaygiothi=Carbon\Carbon::parse($value->ngaythi)->setTimeFromTimeString($value->giobatdau);
                $hientai = Carbon\Carbon::now();
                $hientai->addMinutes(15);
               
                $result= $hientai->greaterThanOrEqualTo($ngaygiothi);
               
                if($result)
                {
                @endphp
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s" >
                    <div class="price-item " style="height:400px;">
                        <div class="border-bottom p-4 mb-4" >
                            <h5 class="text-primary mb-1">{{$value->tenkythi}}</h5>
                            <h2 class="display-6 mb-0">
                                <small class="align-top" style="font-size: 22px; line-height: 45px;"></small>{{$value->maphong}}<small
                                    class="align-bottom" style="font-size: 16px; line-height: 40px;">/ Ca: {{$value->tenca}}</small>
                            </h2>
                            <h5>
                            <small>@php $ngaythi = Carbon\Carbon::createFromFormat('Y-m-d', $value->ngaythi)->format('d/m/Y'); @endphp
                            <i class="far fa-calendar-alt"></i> Ngày: {{$ngaythi}}</small>
                            </h5>
                            <h5><small><i class="far fa-clock"></i> Giờ bắt đầu: {{$value->giobatdau}} phút</small></h5>
                        </div>
                        <div class="p-4 pt-0">
                            @foreach($hoidongthi_phongthi as $value1)
                              @if($value1->maphong==$value->maphong)
                              <p><i class="fa fa-check text-success me-3"></i>{{$value1->holot}} {{$value1->ten}} ({{$value1->vaitro}})</p>
                              @endif
                            @endforeach
                            <a class="btn-slide mt-2" href="{{ route('sinhvien.phongthi',['phongthi_id'=>$value->phongthi_id]) }}" class="btn btn-primary"><i class="fa fa-arrow-right"></i><span >Vào phòng</span></a>
                           
                              
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
    <div id="popup" class="modal" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                      <h5 class="modal-title">THÔNG BÁO MỚI</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>            
                </div>
                <div class="modal-body">
                  <h5 class="text-danger fw-bold">{{$thongbao->tieude}}</strong></h5>
                  <h6 class="text-muted"><i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $thongbao->created_at)->format('d/m/Y') }}</h6>
                  <p style="box-sizing: border-box; padding: 0px; margin: 0px 0px 10px; outline: 0px; font-size: 14px; background-color: rgb(255, 255, 255); line-height: 1.8; caret-color: rgb(255, 0, 0); color: rgb(255, 0, 0); -webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-size-adjust: 100%; font-family: Roboto, Arial, Helvetica, sans-serif; text-align: center;">
                    {!!$thongbao->noidung !!}
                  </p>
                  @if($thongbao->loai=='dinhkem')
                    <p class="text-danger" >Thông báo có đính kèm văn bản. Vui lòng bấm xem tiếp để xem toàn bộ nội dung.</p>
                    <p><a class="btn btn-primary" href="{{route('sinhvien.thongbao.chitiet',['id'=>$thongbao->id])}}">Xem tiếp <i class="bi bi-arrow-right-circle"></i></a></p>
                  @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal"> Đóng</button>
                </div>
            </div>
        </div>
</div>
  @endsection

  @section('javascript')
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
@endsection