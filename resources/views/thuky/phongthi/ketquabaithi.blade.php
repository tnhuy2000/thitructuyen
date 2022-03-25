@extends('layouts.hoidongthi-layout')
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
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('thuky.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('thuky.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">{{$ktphongthi->maphong}}</li>
                    <li class="breadcrumb-item text-danger active" aria-current="page">Kết quả</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">Kết quả - Phòng: {{$ktphongthi->maphong}}</h1>
            </div>
			<hr>
            <a href="" onclick="event.preventDefault();
       document.getElementById('zipFilePhongThi').submit();" class="btn btn-primary mb-2"><i class="fas fa-download"></i> Tải toàn bộ bài làm</a>
            <!-- Table with stripped rows -->
			<div class="table-responsive-lg">
		 	 <table id="DataList" class="table table-hover table-sm ">
		  	<thead>
				<tr>
					<th width="2%">#</th>
				
					<th width="20%">Họ/Tên đệm và tên</th>
					<th width="8%">Mã sinh viên</th>
                    <th width="10%">Điạ chỉ email</th>
                    <th width="9%" class="text-center">Trạng thái</th>
					<th width="8%" class="text-center">Tổng số file</th>
					<th width="10%" class="text-center">Thời gian bắt đầu</th>
					<th width="10%">Thời gian kết thúc</th>
                    <th width="15%">Thời gian thực hiện</th>
                    <th class="text-center">Ghi chú</th>
					<th width="10%" class="text-center">Làm lại</th>
					
				
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($baithi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td class="small"><span style="color:#0000ff;font-weight:bold;">{{ $value->holot }} {{ $value->ten }}</span>
							<span style="font-size:0.9em;">
								<br />
								@foreach($dulieubaithi as $dulieubaithi2)
									@if($dulieubaithi2->baithi_id== $value->id)
								<a href="#hinhanh" class="fw-bold" onclick="getXemHinh('{{ $dulieubaithi2->duongdan }}')"><i class="fas fa-eye"></i> Xem lại bài làm</a><br>
								<a href="#taiZip" class="fw-bold" onclick="event.preventDefault();getZip('{{$value->masinhvien}}','{{$dulieubaithi2->duongdan}}');
       document.getElementById('zipFile').submit();" ><i class="fas fa-download"></i>Tải bài làm</a>
	   								@endif
	   							@endforeach
							</span>
							
						</td>
						<td class="small">{{ $value->masinhvien }}</td>
						<td class="small"><span style="font-size:0.9em;">{{$value->email}}</span></td>
						<td>
							@if($value->trangthai==1)
								<span class="badge bg-success">Đã nộp bài</span>
							@elseif($value->trangthai==0)
							<span class="badge bg-danger">Chưa nộp bài</span>
							@elseif($value->trangthai==2)
							<span class="badge bg-info">Làm bài lại</span>
							@endif
						</td>
						
								<td class="table-info text-center small">
									
								@foreach($dulieubaithi1 as $dulieubaithi3)
									@php
									if($dulieubaithi3->baithi_id== $value->id){
									
										$directory = storage_path('app/'.$dulieubaithi3->duongdan);
										$filecount = 0;
										$files = glob($directory . "/*.{jpg,png,gif}",GLOB_BRACE);
										if($files){
											$filecount = count($files);
										}
									@endphp
									<span class="text-danger fw-bold">{{$filecount}}</span>
									@php
									}	
									@endphp
								@endforeach
								
							
								</td>
							
						@if(!empty($value->thoigianbatdau) && !empty($value->thoigianketthuc))
						@php 
						
						$dt1 = Carbon\Carbon::create($value->thoigianbatdau);
						$dt2 = Carbon\Carbon::create($value->thoigianketthuc);
						
						$diff = abs(strtotime($dt2) - strtotime($dt1));
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
						$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
						$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
						$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
						
						
						@endphp
                        @endif
						
                        <td class="small">
							@if(!empty($value->thoigianbatdau))
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->thoigianbatdau)->format('d/m/Y H:i:s') }}
							@endif
						</td>
                        <td class="small">
							@if(!empty($value->thoigianketthuc))
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->thoigianketthuc)->format('d/m/Y H:i:s') }}
							@endif
						</td>
                        <td class="small">
						@if(!empty($value->thoigianbatdau) && !empty($value->thoigianketthuc))
							@if($hours==0 and $minutes==0)
								{{$seconds.' giây'}}
							@elseif($hours==0)
								{{$minutes.' phút '.$seconds.' giây'}}
							@elseif($hours==0 and $seconds==0)
								{{$minutes.' phút'}}
							@elseif($minutes==0 and $seconds==0)
								{{$hours.' giờ'}}
							@elseif($seconds==0)
								{{$hours.' giờ '.$minutes.' phút'}}
							@else
								{{$hours.' giờ '.$minutes.' phút '.$seconds.' giây'}}
							@endif
					
						@endif

						</td>
						<td class="small text-center">{{ $value->ghichu }}
							<br><a href="#suaghichu" data-bs-toggle="modal" data-bs-target="#ModalSuaGhiChu" onclick="getBaiThiSuaGhiChu({{ $value->id }},'{{ $value->masinhvien }}','{{ $value->dethiphongthi_id }}', '{{ $value->ghichu }}'); return false;">[Sửa]</a>
						</td>	
						<td class="small text-center">
						<a href="#lambailai" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalXacNhanLamBaiLai" onclick="getLamBaiLai({{ $value->id }},'{{ $value->dethiphongthi_id }}'); return false;"><i class="fas fa-redo"></i></a>
						</td>
								
					</tr>

				@endforeach
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->
		  </div>
   
        </div>
    </div>

    <!-- Pricing End -->
	
	<form action="{{route('thuky.zipFile')}}" method="post" id="zipFile">
		@csrf
		<input type="hidden" id="masinhvien" name="masinhvien" value="" />
		<input type="hidden" id="duongdan" name="duongdan" value="" />
	</form>
	<form action="{{route('thuky.zipFile_PhongThi')}}" method="post" id="zipFilePhongThi">
		@csrf
		
		<input type="hidden" id="duongdan" name="duongdan" value="{{$folder}}" />
		<input type="hidden" id="maphong" name="maphong" value="{{$ktphongthi->maphong}}" />
	</form>
	<form action="{{route('thuky.suaghichu')}}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="dethiphongthi_id_edit" name="dethiphongthi_id_edit" value="" />
		<input type="hidden" id="masinhvien_edit" name="masinhvien_edit" value="" />
		<div class="modal fade" id="ModalSuaGhiChu" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật ghi chú</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
						<div class="mb-0">
							<label for="ghichu" class="form-label">Ghi chú</label>
							<textarea class="form-control" id="ghichu_edit" name="ghichu_edit" style="height: 80px"></textarea>
						</div>
						@error('ghichu_edit')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form action="{{route('thuky.lambailai')}}" method="post">
		@csrf
		<input type="hidden" id="id_lambailai" name="id_lambailai" value="" />
		<input type="hidden" id="dethiphongthi_id_lambailai" name="dethiphongthi_id_lambailai" value="" />
		
		<div class="modal fade" id="ModalXacNhanLamBaiLai" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xác nhận làm bài lại</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
						Bạn chắc chắn muốn cho sinh viên này làm bài lại?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
  @endsection
  @section('javascript')    
  <script src="{{ asset('public/js/ckfinder/ckfinder.js') }}"></script>
<script type="text/javascript">
  		
    function getBaiThiSuaGhiChu(id,masinhvien,dethiphongthi_id_edit,ghichu) {
        $('#id_edit').val(id);
        $('#masinhvien_edit').val(masinhvien);
        $('#dethiphongthi_id_edit').val(dethiphongthi_id_edit);
        $('#ghichu_edit').val(ghichu);
    }
	function getLamBaiLai(id,dethiphongthi_id_lambailai) {
        $('#id_lambailai').val(id);      
        $('#dethiphongthi_id_lambailai').val(dethiphongthi_id_lambailai);

    }
	function getXemHinh(duongdan) {
			$.ajax({
				url: '{{ route("thuky.hinhanh.ajax") }}',
				method: 'POST',
				data: { _token: '{{ csrf_token() }}', duongdan: duongdan },
				dataType: 'text',
				success: function(data) {
					CKFinder.modal(
					{
						readOnly: true,
						displayFoldersPanel: false,
						width: 800,
						height: 500
					});
					
				}
			});
		}
		
		function getZip(masinhvien, duongdan) {
			$('#masinhvien').val(masinhvien);
			$('#duongdan').val(duongdan);
		}
	
  </script>
@endsection