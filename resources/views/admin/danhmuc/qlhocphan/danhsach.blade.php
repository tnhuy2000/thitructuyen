@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý học phần
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý học phần</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý học phần</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Bs lọc ds</h5>
		  		<a href="{{route('admin.danhmuc.qlhocphan.them')}}" type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
				<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa-solid fa-upload"></i> Nhập từ Excel</a>
				<a href="{{ route('admin.danhmuc.qlhocphan.xuat') }}" class="btn btn-success"><i class="fa-solid fa-download"></i> Xuất ra Excel</a>
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th width="20%">Mã học phần</th>
					<th >Tên học phần</th>
					<th width="20%">Số tín chỉ</th>
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($hocphan as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->mahocphan }}</td>
						<td>{{ $value->tenhocphan }}</td>
						<td>{{ $value->sotinchi }}</td>
						<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.danhmuc.qlhocphan.sua', ['mahocphan' => $value->mahocphan]) }}" class=""><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa('{{ $value->mahocphan}}','{{$value->tenhocphan}}'); return false;"   href="#xoa"><i class="fa-regular fa-trash-can"></i></a></td>
		
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
<form action="{{ route('admin.danhmuc.qlhocphan.nhap') }}" method="post" enctype="multipart/form-data">
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
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>
{{-- Xoá --}}
<form action="{{ route('admin.danhmuc.qlhocphan.xoa') }}" method="post">
	@csrf
	<input type="hidden" id="mahocphan_delete" name="mahocphan" value="" />
	
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Xoá học phần</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<p ><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận muốn xoá học phần <span id="mahp" class="fw-bold text-danger"></span> - <span id="tenhocphan" class="fw-bold text-danger"></span>.</p>
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
  	function getXoa(mahocphan,tenhocphan) {
			$('#mahocphan_delete').val(mahocphan);
			$('#tenhocphan').text(tenhocphan);
			$('#mahp').text(mahocphan);
		}		
  </script>
@endsection
