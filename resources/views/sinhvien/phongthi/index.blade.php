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
                    <li class="breadcrumb-item text-danger active" aria-current="page">{{$sinhvien_phongthi->maphong}}</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">{{$sinhvien_phongthi->maphong}} - {{$sinhvien_phongthi->tenkythi}}</h1>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-lg-12 col-sm-9 col-md-6 text-center">
            @if(is_numeric($sinhvien_phongthi->ma_meeting))
                <h5><img src="{{asset('public/img/icon_zoom.png')}}" width="50px" alt="">
                    <a href="{{route('sinhvien.thamgiadiemdanh',['phongthi_id'=>$sinhvien_phongthi->phongthi_id])}}" >1. Tham gia phòng điểm danh</a>  
                </h5>
            @else
                <h5><img src="{{asset('public/img/ggmeet.png')}}" width="50px" alt="">
                     <a href="{{route('sinhvien.thamgiadiemdanh',['phongthi_id'=>$sinhvien_phongthi->phongthi_id])}}" >1. Tham gia phòng điểm danh</a>
                </h5>
            @endif
           
            @if($sinhvien_phongthi->diemdanh!=0 )
            <h5>
                <img src="{{asset('public/img/lambai.png')}}" width="50px" alt="">
                @if($dem==1)
                <a href="{{route('sinhvien.lambaithi',['phongthi_id'=>$sinhvien_phongthi->phongthi_id])}}" > 2. Làm bài thi</a>
                @else
                <a href="#chondethi" data-bs-toggle="modal" data-bs-target="#myModalChonDeThi"> 2. Làm bài thi</a>
                @endif
            </h5>
          
            @endif
            <h6 class="text-muted">Ghi chú: Sinh viên phải tham gia phòng điểm danh để giám thị điểm danh trước khi làm bài</h6>
            </div>
            <div class="col-sm-3"></div>
            </div>
    <form action="{{route('sinhvien.chondethi')}}" method="post">
		@csrf
	
		<input type="hidden" id="phongthi_id" name="phongthi_id" value="{{$ktphongthi->id}}" />
		
		<div class="modal fade" id="myModalChonDeThi" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Chọn đề thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
						<div class="mb-0">
							<label for="ghichu" class="form-label">Đề thi</label>
							<select class="form-select" name="dethi_id" id="dethi_id" required>
                            <option value="">--Chọn đề thi--</option>
                                @foreach($dethi_phongthi as $value)
                                <option value="{{$value->dethi_id}}">{{$value->mahocphan}} - {{$value->tenhocphan}}</option>
                                @endforeach
                            </select>
						</div>
						@error('ghichu_edit')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-success"> Đồng ý</button>
					</div>
				</div>
			</div>
		</div>
	</form>
            
        </div>
    </div>

    <!-- Pricing End -->


	
	
  @endsection
  @section('javascript')    
<script type="text/javascript">
  		
		
  </script>
@endsection