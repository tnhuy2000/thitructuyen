@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý kỳ thi
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý kỳ thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item">Quản lý kỳ thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Danh sách kỳ thi</h5>
		  		<a href="{{route('admin.sapphong.qlkythi.them')}}" type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
              
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th>Tên kỳ thi</th>
					<th width="10%">Học kỳ</th>
                    <th width="20%">Năm học</th>
					<th width="10%" class="text-center">Sửa</th>
					<th width="10%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($kythi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span></td>
						<td ><span class="badge bg-secondary">{{ $value->hocky }}</span></td>
                        <td><span class="badge bg-secondary">{{ $value->namhoc }}</span></td>
						<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.sapphong.qlkythi.sua', ['id' => $value->id]) }}" class=""><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},'{{$value->tenkythi}}',{{$value->hocky}},'{{$value->namhoc}}'); return false;"   href="#xoa"><i class="fa-regular fa-trash-can"></i></a></td>
		
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
<form action="{{ route('admin.sapphong.qlkythi.xoa') }}" method="post">
	@csrf
	<input type="hidden" id="id_delete" name="id" value="" />
	
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Xoá kỳ thi</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<p ><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận muốn xoá kỳ thi <span  class="fw-bold text-danger"><span id="tenkythi" class="fw-bold text-danger"></span> - học kỳ: <span id="hocky"></span> - năm học: <span id="namhoc"></span> </span>.</p>
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
  		function getXoa(id,tenkythi,hocky,namhoc) {
			$('#id_delete').val(id);
			$('#tenkythi').text(tenkythi);
			$('#hocky').text(hocky);
			$('#namhoc').text(namhoc);
		}
		
		@if($errors->has('id') || $errors->has('tenkhoa')  )
			$('#myModal').modal('show');
		@endif
		
		@if($errors->has('id_edit') || $errors->has('tenkhoa_edit'))
			$('#myModalEdit').modal('show');
		@endif
  </script>
@endsection
