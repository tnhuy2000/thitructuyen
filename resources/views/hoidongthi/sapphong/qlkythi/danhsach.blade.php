@extends('layouts.admin-hoidong-layout')
@section('title','Quản lý kỳ thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý kỳ thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.dashboard')}}">Bảng điều khiển</a></li>
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
		  <h5 class="card-title">Bs lọc ds</h5>
		  		<a href="{{route('hoidongthi.qlkythi.them')}}" type="button" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
              
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th>Tên kỳ thi</th>
					<th width="15%">Học kỳ</th>
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
						<td>{{ $value->hocky }}</td>
                        <td>{{ $value->namhoc }}</td>
						<td class="text-center"><a href="{{ route('hoidongthi.qlkythi.sua', ['id' => $value->id]) }}" class=""><i class="bx bxs-pencil"></i> Sửa</a></td>
						<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa kỳ thi {{$value->tenkythi}}?')" href="{{ route('hoidongthi.qlkythi.xoa', ['id' => $value->id]) }}"><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
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
