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
            
            <div class="bg-light text-center p-4 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
            
            <div class="alert alert-dark" role="alert">
                <h5 class="text-danger">
                <i class="fas fa-calendar-minus"></i> Trạng thái bài làm: chưa nộp bài
                </h5>
            </div>
        
            
           
            <div class="form-group">
            
                    <input type="hidden" class="form-control" id="ThuMuc" name="ThuMuc" value="{{ $folder }}" readonly required />
                    
               
            </div>
        
            <h5>Bài làm của bạn:</h5>
            
            <h5 id="ChonHinh"><a href="#hinhanh" class="btn btn-warning">Xem bài làm</a></h5>
          
            @php
            Carbon\Carbon::setLocale('vi');
              $ngaygiothi=Carbon\Carbon::parse($dethi_phongthi->ngaythi)->setTimeFromTimeString($dethi_phongthi->giobatdau);
             
              $datetime= $ngaygiothi->addMinutes($dethi_phongthi->thoigianlambai);

            $nam=$datetime->year;
						$thang=$datetime->month;
						if($thang==1)
							$thang="January";
						elseif($thang==2)
							$thang="February";
						elseif($thang==3)
							$thang="March";
						elseif($thang==4)
							$thang="April";
						elseif($thang==5)
							$thang="May";
						elseif($thang==6)
							$thang="June";
						elseif($thang==7)
							$thang="July";
						elseif($thang==8)
							$thang="August";
						elseif($thang==9)
							$thang="September";
						elseif($thang==10)
							$thang="October";
						elseif($thang==11)
							$thang="November";
						else
							$thang="December";
						

						$ngay=$datetime->day;
						$gio=$datetime->toTimeString();
						
						@endphp
						
						<input type="hidden" name="ngay" id="ngay" value="{{$ngay}}">
						<input type="hidden" name="thang" id="thang" value="{{$thang}}">
						<input type="hidden" name="nam" id="nam" value="{{$nam}}">
						<input type="hidden" name="gio" id="gio" value="{{$gio}}">
              
           
            <h6>Hạn chót nộp bài làm này vào lúc: {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->format('d/m/Y H:i:s')}} </h6> Còn lại: <span id="demnguoc"></span>
            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalXNNopBai"><i class="fas fa-upload"></i> Nộp bài và kết thúc</button>
          </div>
   
        </div>
    </div>

    <!-- Pricing End -->


	<form action="{{route('sinhvien.ketthuc')}}" method="post" id="form_exam_submit">
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
		//đếm ngược thời gian
		// Set the date we're counting down to
		var ngay=document.getElementById('ngay').value;
		var thang=document.getElementById('thang').value;
		var nam=document.getElementById('nam').value;
		var gio=document.getElementById('gio').value;
		//var countDownDate = new Date("March 7, 2022 23:15:00").getTime();
		var countDownDate = new Date(""+thang+" "+ngay+", "+nam+" "+gio).getTime();
		// Update the count down every 1 second
		var x = setInterval(function() {

		// Get today's date and time
		var now = new Date().getTime();
			
		// Find the distance between now and the count down date
		var distance = countDownDate - now;
			
		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		//lấy id form
		let form_submitted = document.getElementById('form_exam_submit');
		let form_datas = new FormData(form_submitted);

		// // Output the result in an element with id="demo"
		var phut=((days*24)*60) + (hours*60) + minutes;
		document.getElementById("demnguoc").innerHTML = phut + " phút " + seconds + " giây ";
			
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			$(function () {
				$('#myModalXNNopBai').modal('show');
				setTimeout(function () {
					$('#myModalXNNopBai').modal('hide');
					form_submitted.submit();
				}, 5000);
				
			});
			
		}
		}, 1000);
  </script>
@endsection