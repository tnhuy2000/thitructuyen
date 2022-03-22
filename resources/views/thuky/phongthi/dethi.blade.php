@extends('layouts.hoidongthi-layout')
@section('pagetitle')
	Làm bài thi
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
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('thuky.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('thuky.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">{{$dethi_phongthi->maphong}}</li>
                    <li class="breadcrumb-item text-danger active" aria-current="page">2. Làm bài thi</li>
                </ol>
            </nav>
            </h5>
           
            <br>
            <div class="bg-light text-center p-5 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
              <form>
                  <div class="row g-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div class="text-center wow">
                      <h3 class="text-secondary text-uppercase"> HỌC PHẦN: {{$dethi_phongthi->tenhocphan}} </h3>
                      <hr>
                      <h6 class="text-uppercase">Số lần làm bài: 1</h6>
                      
                      <h6 class="text-uppercase">Thời gian làm bài: {{$dethi_phongthi->thoigianlambai}} phút </h6>
                      <h6 class="text-uppercase">Hình thức: 
                        @if($dethi_phongthi->hinhthuc=="thuchanh")
                        Thực hành
                        @else
                        Tự luận
                        @endif
                      </h6>
                      <h6 class="">(Đề thi yêu cầu mật khẩu)</h6>
                      </div>
                      <br>
                      <br>
                        <div class="">
                            <a class="btn btn-primary w-100 py-3" data-bs-toggle="modal" data-bs-target="#myModalMKCT">Xem đề thi</a>
                        </div>
                        <div class="col-md-3"></div>
                  </div>
              </form>
          </div>
        </div>
           
        </div>
    </div>
    <!-- Pricing End -->
    <form action="{{route('thuky.matkhaucathi')}}" method="post">
		@csrf
	
		<input type="hidden" id="phongthi_id" name="phongthi_id" value="{{$dethi_phongthi->phongthi_id}}" />
		<input type="hidden" id="dethi_id" name="dethi_id" value="{{$dethi_phongthi->dethi_id}}" />
		<div class="modal fade" id="myModalMKCT" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
              <h5 class="modal-title">Bắt đầu làm bài</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
             
						<div class="mb-0">
            @if (Session::get('fail'))
                  <div class="alert alert-danger">
                  {{ Session::get('fail') }}
                  </div>
              @endif
							<h5>Mật khẩu ca thi</h5>
              <label for="matkhaucathi" class="form-label">Đề thi yêu cầu mật khẩu</label>
							<input type="password" name="matkhaucathi" id="matkhaucathi" class="form-control @error('matkhaucathi') is-invalid @enderror" required>
							@error('matkhaucathi')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
            </div>
					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-success"> Bắt đầu làm bài</button>
					</div>
				</div>
			</div>
		</div>
	</form>
  @endsection
  @section('javascript')    


<script>

  @if (Session::get('fail'))
	
  var myModal = new bootstrap.Modal(document.getElementById("myModalMKCT"), {});
  document.onreadystatechange = function () {
  myModal.show();
  };
        
  @endif
		
	</script>
@endsection