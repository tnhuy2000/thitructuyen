@extends('layouts.admin-hoidong-layout')
@section('title','Quản lý đề thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý đề thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý đề thi</li>
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
		  	<a href="{{ route('hoidongthi.qldethi.them') }}" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	
		
            
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th>Học phần</th>
					<th width="15%">Kỳ thi</th>
					<th width="15%">TG làm bài</th>
					<th width="13%">Hình thức</th>
					<th width="15%">Dữ liệu đề thi</th>
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($dethi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>

							<span style="color:#0000ff;font-weight:bold;">{{ $value->tenhocphan }}</span>
							<span style="font-size:0.9em;">
								
								@if(!empty($value->mahocphan))
									<br />Mã học phần: {{ $value->mahocphan }}
								@endif
								@if(!empty($value->sotinchi))
									<br />Số tín chỉ: {{ $value->sotinchi }}
								@endif
							</span>
						</td>
						
						<td>{{ $value->tenkythi }}</td>
						<td>{{ $value->thoigianlambai }}</td>
						<td>@if($value->hinhthuc=='thuchanh')
								<span>Thực hành</span>
							@else
								<span>Tự luận</span>
							@endif
							</td>
						<td><a href="{{ route('hoidongthi.qldulieudethi.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
						<td class="text-center"><a href="{{ route('hoidongthi.qldethi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
						<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa đề thi của học phần {{$value->tenhocphan}}?')" href="{{ route('hoidongthi.qldethi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
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
    
<form action="{{ route('hoidongthi.qllop.nhap') }}" method="post" enctype="multipart/form-data">
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
		
		@if($errors->has('id') || $errors->has('tenkhoa')  )
			$('#myModal').modal('show');
		@endif
		
		@if($errors->has('id_edit') || $errors->has('tenkhoa_edit'))
			$('#myModalEdit').modal('show');
		@endif
  </script>
@endsection
