@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý tài khoản thư ký
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý tài khoản thư ký</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý tài khoản thư ký</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Danh sách tài khoản thư ký</h5>
		  	<a href="#them" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModalThemUser"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bx bxs-archive-out"></i> Nhập từ Excel</a>
			
            
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover table-sm">
		  	<thead>
				<tr>
					<th class="small" width="2%">#</th>
					<th class="small" width="15%">Mã cán bộ</th>
					<th class="small">Họ tên</th>
					<th class="small" width="10%">Username</th>
					<th class="small" width="25%">Email</th>
                    <th class="small" width="10%">Trạng thái</th>
                    <th class="small" width="9%">O/F</th>
					<th class="small" width="12%" class="text-center">Phân quyền</th>
					{{-- <th class="small" width="6%" class="text-center">Xóa</th> --}}
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($tkthuky as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td class="small">{{ $value->macanbo }}</td>
						
						<td class="small">
							<span style="color:#0000ff;font-weight:bold;">{{ $value->name }}</span>
							
						</td>
						<td class="small">{{ $value->username }}</td>	
						<td class="small">{{ $value->email }}</td>
						<td>@if($value->trangthai==1) 
								<span class="badge bg-primary"><i class="bi bi-check-circle me-1"></i> Kích hoạt</span>
							@else 
								<span class="badge bg-danger text-white"><i class="bi bi-x-circle me-1"></i>Bị khoá </span> 
							@endif
						</td>
						<td>
							@if($value->trangthai==1)
								<h2><a href="#khoa" data-bs-toggle="modal" data-bs-target="#myModalKhoa" onclick="getKhoa({{ $value->id}},{{$value->trangthai}},'{{$value->name}}'); return false;"   >
								<i class="bi bi-toggle2-on text-primary"></i>
								</a>
								</h2>
							@else
								<h2><a href="#kichhoat" data-bs-toggle="modal" data-bs-target="#myModalKichHoat" onclick="getKichHoat({{ $value->id}},{{$value->trangthai}},'{{$value->name}}'); return false;">
									<i class="bi bi-toggle2-off text-danger"></i>
									</a>
								</h2>
							@endif
						</td>
					
						<td class="text-center small"><a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModalUpdate" onclick="getSua({{ $value->id}},'{{$value->macanbo}}','{{$value->name}}',{{$value->role}}); return false;" ><i class="fa-regular fa-pen-to-square"></i></a></td>
						{{-- <td class="text-center small"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}}); return false;" ><i class="bi bi-trash"></i> </a></td>
		 --}}
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
    
<form action="{{ route('admin.qlnguoidung.qltkthuky.nhap') }}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="role" value="2">
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
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form> 

  <!--Thêm mới-->
  <form action="{{route('admin.qlnguoidung.qltkthuky.them')}}" method="post">
		@csrf
		<input type="hidden" name="role" value="2">
		<div class="modal fade" id="myModalThemUser" role="dialog" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Thêm người dùng</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">		
						<form>
							
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Nhập mã số cán bộ:</label>
								<br>
								<select class="form-select  @error('macanbo') is-invalid @enderror"  style="width: 100%" id="statesCB" name="macanbo" required>
									
									@foreach($kthoidongthi as $value)
										<option class="@error('macanbo') is-invalid @enderror" {{(old('macanbo')==$value->macanbo)?'selected':''}} value="{{$value->macanbo}}">{{$value->macanbo}} - {{$value->holot}} {{$value->ten}} </option>
									@endforeach
								</select>
								@error('macanbo')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
								@enderror
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<form action="{{ route('admin.qlnguoidung.qltkthuky.trangthai')}}" method="post">
		@csrf
		<input type="hidden" id="id_khoa" name="id_khoa" value="" />
		<input type="hidden" id="trangthai_khoa" name="trangthai_khoa" value="" />
		<div class="modal fade" id="myModalKhoa" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật trạng thái</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p >Bạn muốn <span class="fw-bold text-danger">khoá</span> người dùng <span class="fw-bold text-danger" id="hoten_khoa"></span> ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	

	<form action="{{ route('admin.qlnguoidung.qltkthuky.trangthai')}}" method="post">
		@csrf
		<input type="hidden" id="id_kichhoat" name="id_kichhoat" value="" />
		<input type="hidden" id="trangthai_kichhoat" name="trangthai_kichhoat" value="" />
		<div class="modal fade" id="myModalKichHoat" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật trạng thái</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p >Bạn muốn <span class="fw-bold text-primary">kích hoạt</span> người dùng <span class="fw-bold text-primary" id="hoten_kichhoat"></span> ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-primary">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<form action="{{ route('admin.qlnguoidung.qltkthuky.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá người dùng</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question"></i>Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<form action="{{route('admin.qlnguoidung.phanquyen')}}" method="post">
		@csrf
		<input type="text" name="id_update" id="id_update" value="">
		<div class="modal fade" id="myModalUpdate" role="dialog" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Phân quyền</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">		
						<form>
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Mã cán bộ</label>
								<input type="text" class="form-control" id="macanbo" value="" readonly>
							</div>
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Tên</label>
								<input type="text" class="form-control" id="name" value="" readonly>
							</div>
							<div class="mb-3">
								<label for="message-text" class="col-form-label">Phân quyền:</label>
								<br>
								<select class="form-select  @error('role') is-invalid @enderror" id="role"  style="width: 100%"  name="role" required>
									
										<option class="@error('role') is-invalid @enderror" {{(old('role')==3)?'selected':''}} value="3">Cán bộ coi thi</option>
										<option class="@error('role') is-invalid @enderror" {{(old('role')==2)?'selected':''}} value="2">Thư ký</option>
										<option class="@error('role') is-invalid @enderror" {{(old('role')==4)?'selected':''}} value="4">Hội đồng thi</option>
								</select>
								@error('role')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
								@enderror
							</div>
						</form>
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
<script type="text/javascript">
  		function getXoa(id) {
			$('#id_delete').val(id);
		}
		function getSua(id,macanbo,name,role) {
			$('#id_update').val(id);
			$('#macanbo').val(macanbo);
			$('#name').val(name);
			$('#role').val(role).change();
		}
		function getKichHoat(id,trangthai,hoten) {
			$('#id_kichhoat').val(id);
			$('#trangthai_kichhoat').val(trangthai);
			$('#hoten_kichhoat').text(hoten);
		}
		function getKhoa(id,trangthai,hoten) {
			$('#id_khoa').val(id);
			$('#trangthai_khoa').val(trangthai);
			$('#hoten_khoa').text(hoten);
		}
		$('#statesCB').select2({
			dropdownParent: $('#myModalThemUser'),
			placeholder: "Nhập mã cán bộ",
    		allowClear: true
		});
		@if($errors->has('macanbo') )
	
		var myModal = new bootstrap.Modal(document.getElementById("myModalThemUser"), {});
		document.onreadystatechange = function () {
		myModal.show();
		};
				
	@endif
  </script>
@endsection
