@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý sinh viên
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý sinh viên</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý sinh viên</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Danh sách sinh viên</h5>
		  	<a href="{{ route('admin.danhmuc.qlsinhvien.them') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
		  	<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa-solid fa-upload"></i> Nhập từ Excel</a>
			<a href="{{ route('admin.danhmuc.qlsinhvien.xuat') }}" class="btn btn-success"><i class="fa-solid fa-download"></i> Xuất ra Excel</a>
           
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%" >#</th>
					<th width="15%">Mã số sinh viên</th>
					<th width="30%">Thông tin sinh viên</th>
					<th width="15%">Mã lớp</th>
					<th width="6%" class="text-center">Sửa</th>
					<th width="6%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($sinhvien as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->masinhvien }}</td>
						<td>
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
						<td>{{ $value->malop }}</td>
						
						<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.danhmuc.qlsinhvien.sua', ['masinhvien' => $value->masinhvien]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa('{{ $value->masinhvien}}','{{$value->holot}}','{{$value->ten}}'); return false;"   href="#xoa" ><i class="fa-regular fa-trash-can"></i></a></td>
		
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
    
<form action="{{ route('admin.danhmuc.qlsinhvien.nhap') }}" method="post" enctype="multipart/form-data">
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

<form action="{{ route('admin.danhmuc.qlsinhvien.xoa') }}" method="post">
	@csrf
	<input type="hidden" id="masinhvien_delete" name="masinhvien" value="" />
	
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Xoá sinh viên</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<p ><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận muốn xoá sinh viên <span id="holot" class="fw-bold text-danger"></span> <span id="ten" class="fw-bold text-danger"></span>.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-danger">Thực hiện</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(masinhvien,holot,ten) {
			$('#masinhvien_delete').val(masinhvien);
			$('#holot').text(holot);
			$('#ten').text(ten);
		}
		
		@if($errors->has('id') || $errors->has('tenkhoa')  )
			$('#myModal').modal('show');
		@endif
		
		@if($errors->has('id_edit') || $errors->has('tenkhoa_edit'))
			$('#myModalEdit').modal('show');
		@endif
  </script>
@endsection
