@extends('layouts.giamthi-layout')
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
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('giamthi.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="#">Phòng thi của tôi</a></li>
                    <li class="breadcrumb-item text-danger active" aria-current="page">{{$hoidongthi_phongthi->maphong}}</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">{{$hoidongthi_phongthi->maphong}} - {{$hoidongthi_phongthi->tenkythi}}</h1>
            </div>
            <hr>
           
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-lg-12 col-sm-9 col-md-6 text-center">
            @if(is_numeric($hoidongthi_phongthi->ma_meeting))
                <h5><img src="{{asset('public/img/icon_zoom.png')}}" width="50px" alt="">
                    <a href="{{route('giamthi.thamgiadiemdanh',['phongthi_id'=>$hoidongthi_phongthi->phongthi_id])}}" >1. Tham gia phòng điểm danh</a>  
                </h5>
            @else
                <h5><img src="{{asset('public/img/ggmeet.png')}}" width="50px" alt="">
                     <a href="{{route('giamthi.thamgiadiemdanh',['phongthi_id'=>$hoidongthi_phongthi->phongthi_id])}}" >1. Tham gia phòng điểm danh</a>
                </h5>
            @endif
            <h5><img src="{{asset('public/img/lambai.png')}}" width="50px" alt="">
                @if($dem==1)
                <a href="{{route('giamthi.dethi',['phongthi_id'=>$hoidongthi_phongthi->phongthi_id])}}" > 2. Làm bài thi <i class="fas fa-chevron-circle-right"></i></a>
                @else
                <a href="#chondethi" data-bs-toggle="modal" data-bs-target="#myModalChonDeThi"> 2. Làm bài thi <i class="fas fa-chevron-circle-right"></i></a>
                @endif
            </h5>
            <h5>
                <img src="{{asset('public/img/check.png')}}" width="50px" alt="">
                <a  href="{{route('giamthi.danhsachthisinh',['phongthi_id'=>$hoidongthi_phongthi->phongthi_id])}}" > 3. Giám thị điểm danh thí sinh <i class="fas fa-chevron-circle-right"></i></a>
               
            </h5>
            <h5><a href="{{route('giamthi.ketquabaithi',['phongthi_id'=>$hoidongthi_phongthi->phongthi_id])}}" class="btn btn-primary col-sm-12 col-md-4"> <i class="fas fa-clipboard-list"></i> Kết quả làm bài</a></h5>
            </div>
            <div class="col-sm-3"></div>
            </div>
          
            

    <form action="{{route('giamthi.chondethi')}}" method="post">
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