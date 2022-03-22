@extends('layouts.admin-layout')
@section('title','Quản lý tài khoản sinh viên')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý tài khoản sinh viên</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý tài khoản sinh viên</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Danh sách tài khoản sinh viên</h5>
		  	<!-- <a href="{{ route('admin.qlnguoidung.qltksinhvien.them') }}" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	<a href="#nhap" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bx bxs-archive-in"></i> Nhập từ Excel</a>
			
             -->
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover table-sm">
		  	<thead>
				<tr>
					<th class="small" width="2%">#</th>
					<th class="small" width="15%">Mã số sinh viên</th>
					<th class="small">Họ tên</th>
					<th class="small" width="10%">Username</th>
					<th class="small" width="25%">Email</th>
                    <th class="small" width="10%">Trạng thái</th>
                    <th class="small" width="9%">O/F</th>
					<th class="small" width="6%" class="text-center">Sửa</th>
					<th class="small" width="6%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($tksinhvien as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td class="small">{{ $value->masinhvien }}</td>
						
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
								<h2><a href="{{ route('admin.qlnguoidung.qltksinhvien.trangthai', ['id'=> $value->id, 'trangthai' => $value->trangthai]) }}">
								<i class="bi bi-toggle2-on text-primary"></i>
								</a>
								</h2>
							@else
								<h2><a href="{{ route('admin.qlnguoidung.qltksinhvien.trangthai', ['id'=> $value->id, 'trangthai' => $value->trangthai]) }}">
									<i class="bi bi-toggle2-off text-danger"></i>
									</a>
								</h2>
							@endif
						</td>
					
						<td class="text-center small"><a class="btn btn-primary btn-sm" href="{{ route('admin.qlnguoidung.qltksinhvien.sua', ['id' => $value->id]) }}"><i class="bi bi-pencil-square"></i></a></td>
						<td class="text-center small"><a class="btn btn-danger btn-sm" onclick="return confirm('Bạn có muốn xóa sinh viên {{$value->name}}?')" href="{{ route('admin.qlnguoidung.qltksinhvien.xoa', ['id' => $value->id]) }}" ><i class="bi bi-trash"></i> </a></td>
		
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
    
<form action="{{ route('admin.qlnguoidung.qltksinhvien.nhap') }}" method="post" enctype="multipart/form-data">
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
@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(id) {
			$('#id').val(id);
		}
		
		
  </script>
@endsection
