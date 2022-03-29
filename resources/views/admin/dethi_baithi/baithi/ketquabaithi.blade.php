@extends('layouts.admin-layout')
@section('title','Quản lý bài thi & dữ liệu bài thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý bài thi & dữ liệu bài thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Đề thi & bài thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qlbaithi.danhsach')}}">Quản lý bài thi & dữ liệu bài thi</a></li>
      @php 
      $ngaythi= Carbon\Carbon::parse($phongthi->ngaythi)->format('d-m-Y');
      @endphp
	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qlbaithi.cathi',['ngaythi' =>$ngaythi] )}}">{{$ngaythi}}</a></li>
	  <li class="breadcrumb-item active"><a href="{{route('admin.dethi_baithi.qlbaithi.phongthi',['ngaythi'=>$ngaythi,'cathi' =>$phongthi->cathi_id] )}}">{{$phongthi->tenca}}</a></li>
      <li class="breadcrumb-item active">{{$phongthi->maphong}}</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Dữ liệu bài thi ngày: {{$ngaythi}} | Ca thi: {{$phongthi->tenca}} | Phòng:  {{$phongthi->maphong}}</h5>
              <div class="row">

                 
                    <div class="col-md-4 pl-1"></div>

                    <div class="col-md-3 col-sm-3 pl-1 mb-3">
                        <div class="form-group" id="filter_col4" data-column="4">
                            <label class="form-label" >Trạng thái</label>
                            <select name="trangthai" class="form-select column_filter " id="col4_filter">
                                <option selected="selected">--Chọn trạng thái--</option>
                                <option>Đã nộp bài</option>
                                <option>Chưa nộp bài</option>
                                <option>Làm bài lại</option>
                          
                        </select>
                        </div>

                    </div>




                    </div>
              <a href="" onclick="event.preventDefault();
       document.getElementById('zipFilePhongThi').submit();" class="btn btn-primary mb-2"><i class="bx bxs-download"></i> Tải toàn bộ bài làm</a>
            <!-- Table with stripped rows -->
			<div class="table-responsive-lg">
		 	 <table class="table table-hover table-sm " id="ex">
		  	    <thead>
				<tr>
					<th class="small" width="2%">#</th>
				
					<th class="small" width="30%">Họ tên</th>
					<th class="small" width="6%">Mã SV</th>
                    <th class="small" width="6%">Email</th>
                    <th class="small" width="9%" class="text-center">Trạng thái</th>
					<th class="small" width="6%" class="text-center">Tổng file</th>
					<th class="small" width="10%" class="text-center">TG bắt đầu</th>
					<th class="small" width="10%">TG kết thúc</th>
                    <th class="small" width="15%">TG thực hiện</th>
                    <th class="small" width="15%">Ghi chú</th>
					<th class="small" width="10%" class="text-center">Làm lại</th>
					
				
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($baithi as $value)
					<tr>
						<td class="small">{{ $count++ }}</td>
						<td class="small"><span style="color:#0000ff;font-weight:bold; font-size:0.9em;">{{ $value->holot }} {{ $value->ten }}</span>
							<span style="font-size:0.9em;">
								<br />
								@foreach($dulieubaithi as $dulieubaithi2)
									@if($dulieubaithi2->baithi_id== $value->id)
                                   
								<a href="#hinhanh" class="fw-bold text-danger" onclick="getXemHinh('{{ $dulieubaithi2->duongdan }}')"><i class="bi bi-eye-fill"></i> Xem bài làm</a><br>
								<a href="#taiZip" class="fw-bold text-danger" onclick="event.preventDefault();getZip('{{$value->masinhvien}}','{{$dulieubaithi2->duongdan}}');
       document.getElementById('zipFile').submit();" ><i class="bx bxs-download"></i> Tải bài làm</a>
	   								@endif
	   							@endforeach
							</span>
							
						</td>
						<td class="small"><span style="font-size:0.9em;">{{ $value->masinhvien }}</span></td>
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
                            <span style="font-size:0.9em;">
							@if(!empty($value->thoigianbatdau))
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->thoigianbatdau)->format('d/m/Y H:i:s') }}
							@endif
                            </span>
						</td>
                        <td class="small">
                            <span style="font-size:0.9em;">
							@if(!empty($value->thoigianketthuc))
							{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->thoigianketthuc)->format('d/m/Y H:i:s') }}
							@endif
                            </span>
						</td>
                        <td class="small">
                            <span style="font-size:0.9em;">
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
                            </span>
						</td>
						<td class="small text-center "><span style="font-size:0.9em;">{{ $value->ghichu }}
							<br><a class="text-danger" href="#suaghichu" data-bs-toggle="modal" data-bs-target="#ModalSuaGhiChu" onclick="getBaiThiSuaGhiChu({{ $value->id }},'{{ $value->masinhvien }}','{{ $value->dethiphongthi_id }}', '{{ $value->ghichu }}'); return false;">[Sửa]</a>
                                </span>
                        </td>	
						<td class="small text-center">
						<a href="#lambailai" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalXacNhanLamBaiLai" onclick="getLamBaiLai({{ $value->id }},'{{ $value->dethiphongthi_id }}'); return false;"><i class="bi bi-arrow-counterclockwise"></i></a>
						</td>
								
					</tr>

				@endforeach
			</tbody>
		  </table>
          

		</div>
	  </div>

	</div>
  </div>
</section>

</main><!-- End #main -->


    <form action="{{route('admin.dethi_baithi.qlbaithi.zipFile')}}" method="post" id="zipFile">
		@csrf
		<input type="hidden" id="masinhvien" name="masinhvien" value="" />
		<input type="hidden" id="duongdan" name="duongdan" value="" />
	</form>
	<form action="{{route('admin.dethi_baithi.qlbaithi.zipFile_PhongThi')}}" method="post" id="zipFilePhongThi">
		@csrf
		
		<input type="hidden" id="duongdan" name="duongdan" value="{{$folder}}" />
		<input type="hidden" id="maphong" name="maphong" value="{{$phongthi->maphong}}" />
	</form>
	<form action="{{route('admin.dethi_baithi.qlbaithi.suaghichu')}}" method="post">
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
	<form action="{{route('admin.dethi_baithi.qlbaithi.lambailai')}}" method="post">
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
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
				url: '{{ route("admin.dethi_baithi.qlbaithi.hinhanh.ajax") }}',
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
        function filterGlobal () {
	$('#ex').DataTable().search(
		$('#global_filter').val(),
	
	).draw();
	}
    
    function filterColumn ( i ) {
        $('#ex').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }
    
    $(document).ready(function() {
		
        $('#ex').DataTable();
        
        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        } );
		
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
    } );

    $('select.column_filter').on('change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );

		
  </script>
@endsection
