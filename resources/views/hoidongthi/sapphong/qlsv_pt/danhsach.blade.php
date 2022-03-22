@extends('layouts.admin-hoidong-layout')
@section('title','Quản lý sinh viên - phòng thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý sinh viên - phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.qlphongthi.danhsach')}}">Quản lý phòng thi</a></li>
	  <li class="breadcrumb-item">Quản lý sinh viên - phòng thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Danh sách sinh viên phòng {{$ktphongthi->maphong}}</h5>
			<a href="#them" data-bs-toggle="modal" data-bs-target="#myModalThemSVPT" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
			<a href="#nhap" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bx bxs-archive-in"></i> Nhập từ Excel</a>
			<a href="{{ route('hoidongthi.qlsv_pt.xuat',['phongthi_id'=> $ktphongthi->id])}}" class="btn btn-outline-success"><i class="bx bxs-archive-out"></i> Xuất ra Excel</a>
		
		
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
				
					<th width="15%">Mã sinh viên</th>
					<th>Thông tin sinh viên</th>
					<th width="15%" class="text-center">Điểm danh</th>
					<th width="25%">Ghi chú</th>
					
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($sinhvien_phongthi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						
						<td>
							{{ $value->masinhvien }}
						</td>
						<td class="small">
							<span style="color:#0000ff;font-weight:bold;">{{ $value->holot }} {{ $value->ten }}</span>
							<span style="font-size:0.9em;">
								
								@if(!empty($value->email))
									<br />Email: {{ $value->email }}
								@endif
								@if(!empty($value->dienthoai))
									<br />Điện thoại: {{ $value->dienthoai }}
								@endif
							</span>
						</td>
						<td class="text-center">
							@if($value->diemdanh==1)
								<h2><a href="{{ route('hoidongthi.qlsv_pt.diemdanh', ['id' => $value->id,'phongthi_id'=>$value->phongthi_id]) }}"><i class="bx bxs-check-circle text-success"></i></a></h2>
							@else
								<h2><a href="{{ route('hoidongthi.qlsv_pt.diemdanh', ['id' => $value->id,'phongthi_id'=>$value->phongthi_id]) }}"><i class="bx bx-x-circle text-danger"></i></a></h2>
							@endif
							
						<td class="small">{{ $value->ghichu }}
							<br><a href="#suaghichu" data-bs-toggle="modal" data-bs-target="#ModalSuaGhiChu" onclick="getSuaGhiChu({{ $value->id }},'{{ $value->masinhvien }}','{{ $value->phongthi_id }}', '{{ $value->ghichu }}'); return false;">[Sửa ghi chú]</a>
						</td>
						
						
						<td class="text-center"><a href="#xoa" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},{{$value->phongthi_id}}); return false;"  ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
					</tr>
				@endforeach
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->

		</div>
	  </div>

	</div>
  </div>
</section>

</main>


<form action="{{route('hoidongthi.qlsv_pt.them',['phongthi_id'=> $ktphongthi->id])}}" method="post">
		@csrf


</form>
<!-- End #main -->
    <!--Thêm mới-->
<form action="{{route('hoidongthi.qlsv_pt.them',['phongthi_id'=> $ktphongthi->id])}}" method="post">
		@csrf
		
		<div class="modal fade" id="myModalThemSVPT" role="dialog" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Thêm danh sách sinh viên - phòng thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
                    
                            <label for="HinhAnh"> Mã sinh viên<span class="text-danger font-weight-bold">*</span></label>
                                
							<select class="form-select @error('masinhvien') is-invalid @enderror" id="stateSV" name="masinhvien" required>
								
								@foreach($ktsinhvien as $value)
									<option value="{{$value->masinhvien}}" class=" @error('masinhvien') is-invalid @enderror" id="masinhvien">{{$value->masinhvien}}</option>
								@endforeach
							</select>
							@error('masinhvien')
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
	<!--Sửa ghi chú-->
	<form action="{{route('hoidongthi.qlsv_pt.suaghichu')}}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="phongthi_id_edit" name="phongthi_id_edit" value="" />
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
	<form action="{{ route('hoidongthi.qlsv_pt.nhap',['phongthi_id'=> $ktphongthi->id]) }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModalLabel">Nhập từ Excel</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-0">
						<label for="file_excel" class="form-label">Chọn tập tin Excel</label>
						<input type="file" class="form-control" id="file_excel" name="file_excel" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"><i class="fal fa-upload"></i> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form action="{{ route('hoidongthi.qlsv_pt.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id_delete" value="" />
		<input type="hidden" id="phongthi_id_delete" name="phongthi_id_delete" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá sinh viên thuộc phòng</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fal fa-question-circle"></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"><i class="fal fa-trash-alt"></i> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>


@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(id,phongthi_id) {
			$('#id_delete').val(id);
			$('#phongthi_id_delete').val(phongthi_id);
		}
		function getSuaGhiChu(id,masinhvien,phongthi_id,ghichu) {
			$('#id_edit').val(id);
			$('#masinhvien_edit').val(masinhvien);
			$('#phongthi_id_edit').val(phongthi_id);
			$('#ghichu_edit').val(ghichu);
		}
		
		$(document).ready(function() {
            $("#stateSV").select2();   
        });
		
		@if($errors->has('masinhvien') )
	
		var myModal = new bootstrap.Modal(document.getElementById("myModalThemSVPT"), {});
		document.onreadystatechange = function () {
		myModal.show();
		};
					
		@endif

		
  </script>
  
@endsection
