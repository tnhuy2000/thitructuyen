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
                <i class="fas fa-calendar-minus"></i> Trạng thái bài làm: chưa nộp
                </h5>
            </div>
            <br>
            
           
            <div class="form-group">
            
                    <input type="hidden" class="form-control" id="ThuMuc" name="ThuMuc" value="{{ $folder }}" readonly required />
                    
               
            </div>
        
            <h5>Bài làm của bạn:</h5>
            <br>
            <h5 id="ChonHinh"><a href="#hinhanh" class="btn btn-warning">Xem bài làm</a></h5>
            <br>
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalXNNopBai"><i class="fas fa-upload"></i> Nộp bài và kết thúc</button>
          </div>
   
        </div>
    </div>

    <!-- Pricing End -->


	<form action="{{route('sinhvien.ketthuc')}}" method="post">
@csrf
		<div class="modal" id="myModalXNNopBai" tabindex="-1" role="dialog" aria-labelledby="myModalXNNopBai">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xác nhận</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<input type="hidden" name="baithi_id" id="baithi_id" value="{{$baithi_id}}" required>
						<input type="hidden" name="phongthi_id" id="phongthi_id" value="{{$dethi_phongthi->phongthi_id}}" required>
						<input type="hidden" name="dethiphongthi_id" id="dethiphongthi_id" value="{{$dethi_phongthi->id}}" required>
						<input type="hidden" class="form-control" id="ThuMuc" name="ThuMuc" value="{{ $folder }}" required />
						<p class="font-weight-bold text-danger"><i class="fas fa-question-circle"></i> Bạn chắc chắn muốn nộp bài?</p>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> Chắc chắn</button>
						<button type="button" class="btn btn-warning" data-bs-dismiss="modal"> Không</button>
					</div>
				</div>
			</div>
		</div>
</form>
	
  @endsection
  
  @section('javascript')    
  <script src="{{ asset('public/js/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript">
  		var chonHinh = document.getElementById('ChonHinh');
		chonHinh.onclick = function() { uploadFileWithCKFinder(); };
		function uploadFileWithCKFinder()
		{
			CKFinder.modal(
			{
				displayFoldersPanel: false,
				width: 800,
				height: 500
       
			});
		}
		
  </script>
@endsection