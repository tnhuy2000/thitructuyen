@extends('layouts.sinhvien-layout')
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
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('sinhvien.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
				<li class="breadcrumb-item"><a class="text-primary" href="{{route('sinhvien.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
				<li class="breadcrumb-item text-primary" aria-current="page">{{$dethi_phongthi->maphong}}</li>
				<li class="breadcrumb-item text-danger active" aria-current="page">2. Làm bài thi</li>
			</ol>
		</nav>
		</h5>
		<div class="wow mt-2 mb-2" data-wow-delay="0.1s">
			<h3 class="text-info">Trang dành cho sinh viên nộp bài lại</h3>
			<h3 class="">{{$dethi_phongthi->mahocphan}} - {{$dethi_phongthi->tenhocphan}}</h3>
			<button disabled class="btn" id="remaining_time">  </button>
		</div>
		
		<div class="row">
			<div class="col-md-8">
				<div class="card" style="border-width: 5px;border: solid;">
					
					<div class="card-body">
						<div class="text-center">
						@php $count=1; @endphp
						@foreach($dulieudethi as $value)
							<h6 class="card-title bg-dark text-white">Trang {{$count++}}</h6>
							<img src="{{$path_dethi. $value->duongdan}}" class="img-thumnail" width="650px"/>
							<hr>
							
						@endforeach
						<h6>Đề thi có tổng số: {{$count-1}} trang</h6>
						<br>
						<br>
						</div>
						<h5 class="text-danger fw-bold">KHU VỰC NỘP BÀI</h5>
						<div class="bg-light py-2 px-2" style="border: dashed;">
						<!-- End Table with stripped rows -->
							<form role="form" method="post" action="{{route('sinhvien.nopbai.them')}}" id="form_exam_submit" enctype="multipart/form-data">
								@csrf
							
								<input type="hidden" name="baithi_id" id="baithi_id" value="{{$baithi_id}}">
								<input type="hidden" name="phongthi_id" id="phongthi_id" value="{{$dethi_phongthi->phongthi_id}}">
								<input type="hidden" name="dethiphongthi_id" id="dethiphongthi_id" value="{{$dethi_phongthi->id}}">
							
								<div class="form-group">
								
								<h6 >Chú ý:
									<ol>
										<li>Sinh viên vui lòng nhấn nút <span class="text-danger">"Chọn file"</span> để tải bài làm.</li>
										<li>Sau khi tải bài làm xong thì nhấn nút  <span class="text-danger">"Làm xong"</span> để nộp bài.</li>
									</ol>
								
								</h6>
								
									<div class="input-group">
										
										<div class="input-group-prepend">
										
											<div class="input-group-text" id="ChonHinh"><span class="badge bg-secondary">1</span> &nbsp;<a  href="#hinhanh">Chọn file</a></div>
										</div>
									
										<input type="text" class="form-control" id="ThuMuc" name="ThuMuc" value="{{ $folder }}" readonly required />
										
									</div>
								</div>
								<br>
								<div class="text-center">
								<span class="badge bg-secondary">2</span>&nbsp;<button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Làm xong</button>
								</div>
							</form>	
						</div>	

					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card" style="border-width: 5px;border: solid #ff0000;">
					<div class="card-body">
						<h6 class="text-info"><i class="fas fa-exclamation-circle"></i> Sinh viên có 15 phút để nộp bài lại. Sau 15 phút nếu sinh viên chưa nộp bài thì bài thi sẽ được tính là 0 điểm.</h6>
						
						@php 
						$ngaygiothi= Carbon\Carbon::createFromDate($baithi->thoigiannopbailai);
						
						
						$nam=$ngaygiothi->year;
						$thang=$ngaygiothi->month;
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
						

						$ngay=$ngaygiothi->day;
						$gio=$ngaygiothi->toTimeString();
						
						@endphp
						
						<input type="hidden" name="ngay" id="ngay" value="{{$ngay}}">
						<input type="hidden" name="thang" id="thang" value="{{$thang}}">
						<input type="hidden" name="nam" id="nam" value="{{$nam}}">
						<input type="hidden" name="gio" id="gio" value="{{$gio}}">
						
						<h6 class="text-danger">
				
						<img class="" src="{{asset('public/img/clock.png')}}" width="60px" alt="">	
						Còn lại: <span id="demnguoc"></span>
						<i class="fas fa-clock"></i>
						</h6>
						<h6 class="text-danger">Chú ý: Khu vực nộp bài ở cuối trang web</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



		
		<div class="modal" id="myModalNopBai" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Hết thời gian</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fas fa-clock"></i> Đã hết thời gian làm bài!</p>
						
					</div>
					<div class="modal-footer">
					
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal"> OK</button>
					</div>
				</div>
			</div>
		</div>

		

@endsection
@section('javascript')    
<script src="{{ asset('public/js/ckfinder/ckfinder.js') }}"></script>

	<script>
		
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

		// Output the result in an element with id="demo"
		var phut=((days*24)*60) + (hours*60) + minutes;
		document.getElementById("demnguoc").innerHTML = phut + " phút " + seconds + " giây ";
			
		// If the count down is over, write some text 
		if (distance < 0) {
			clearInterval(x);
			$(function () {
				$('#myModalNopBai').modal('show');
				setTimeout(function () {
					$('#myModalNopBai').modal('hide');
					form_submitted.submit();
				}, 1000);
				
			});
			
		}
		}, 1000);
		
	</script>
@endsection
