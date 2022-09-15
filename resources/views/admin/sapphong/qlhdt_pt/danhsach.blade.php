@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý hội đồng thi - phòng thi
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý hội đồng thi - phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlphongthi.danhsach')}}">Quản lý phòng thi</a></li>
	  <li class="breadcrumb-item">Quản lý hội đồng thi - phòng thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Danh sách hội đồng thi phòng {{$ktphongthi->maphong}}</h5>
			<a href="#them" data-bs-toggle="modal" data-bs-target="#myModalThemHDTPT" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
			<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa-solid fa-upload"></i> Nhập từ Excel</a>
			<a href="{{ route('admin.sapphong.qlsv_pt.xuat',['phongthi_id'=> $ktphongthi->id])}}" class="btn btn-success"><i class="fa-solid fa-download"></i> Xuất ra Excel</a>
		
		
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
				
					<th width="15%">Mã cán bộ</th>
					<th>Thông tin cán bộ</th>
					<th width="15%">Vai trò</th>
					<th width="25%">Ghi chú</th>
					<th width="6%" >Sửa</th>
					<th width="6%">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($hoidongthi_phongthi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						
						<td>
							{{ $value->macanbo }}
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
							
						<td>
							@if($value->vaitro=='thuky')
								<span class="badge bg-primary text-white">Thư ký</span> 
							@elseif($value->vaitro=='canbocoithi')
								<span class="badge bg-success text-white">Cán bộ coi thi</span> 
							@elseif($value->vaitro=='hoidongthi')
								<span class="badge bg-danger text-white">Hội đồng thi</span> 
							@endif
						</td>
						<td>{{ $value->ghichu }}</td>
						<td class="small">
							<a href="#sua" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalSua" onclick="getSua({{ $value->id }},'{{ $value->macanbo }}','{{ $value->phongthi_id }}','{{ $value->ghichu }}'); return false;"><i class="fa-regular fa-pen-to-square"></i></a>
						</td>
						
						<td class="text-center"><a class="btn btn-danger btn-sm" href="#xoa" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},{{$value->phongthi_id}}); return false;"  ><i class="fa-regular fa-trash-can"></i></a></td>
		
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

</main><!-- End #main -->
    <!--Thêm mới-->
<form action="{{route('admin.sapphong.qlhdt_pt.them',['phongthi_id'=> $ktphongthi->id])}}" method="post">
		@csrf
		
		<div class="modal fade" id="myModalThemHDTPT" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Thêm danh sách hội đồng thi - phòng thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
                    
						<form>
							
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Nhập mã cán bộ:</label>
								<br>
								<select class="form-select @error('macanbo') is-invalid @enderror" style="width: 100%" id="statesCB" multiple="multiple" name="macanbo[]" required>
									<option value="">-- Nhập mã cán bộ --</option>
									@foreach($kthoidongthi as $value)
										<option value="{{$value->macanbo}}">{{$value->macanbo}} - {{$value->holot}} {{$value->ten}}</option>
									@endforeach
								</select>
							</div>
						</form>
							@error('macanbo')
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
	<form action="{{route('admin.sapphong.qlhdt_pt.sua')}}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="phongthi_id_edit" name="phongthi_id_edit" value="" />
		
		<div class="modal fade" id="ModalSua" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Nhập mã cán bộ:</label>
								<br>
								<select class="form-select @error('macanbo_edit') is-invalid @enderror" style="width: 100%" id="stateCBEdit"  name="macanbo_edit" required>

									@foreach($kthoidongthi as $value)
										<option value="{{$value->macanbo}}">{{$value->macanbo}} - {{$value->holot}} {{$value->ten}}</option>
									@endforeach
								</select>
							</div>
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
	<form action="{{ route('admin.sapphong.qlhdt_pt.nhap',['phongthi_id'=> $ktphongthi->id]) }}" method="post" enctype="multipart/form-data">
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
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form action="{{ route('admin.sapphong.qlhdt_pt.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id_delete" value="" />
		<input type="hidden" id="phongthi_id_delete" name="phongthi_id_delete" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá cán bộ thuộc phòng</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"> Thực hiện</button>
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
		function getSua(id,macanbo,phongthi_id,ghichu) {
			$('#id_edit').val(id);
			$('#stateCBEdit').val(macanbo).change();
			$('#phongthi_id_edit').val(phongthi_id);
			$('#ghichu_edit').val(ghichu);
		}
		

		$('#statesCB').select2({
			dropdownParent: $('#myModalThemHDTPT'),
			placeholder: "Nhập mã cán bộ",
    		allowClear: true,
			theme: "bootstrap-5"
		});
		$('#stateCBEdit').select2({
			dropdownParent: $('#ModalSua')
		});
		// @if($errors->has('macanbo') )
	
		// var myModal = new bootstrap.Modal(document.getElementById("myModalThemHDTPT"), {});
		// document.onreadystatechange = function () {
		// myModal.show();
		// };
				
			
		// @endif
  </script>
@endsection
