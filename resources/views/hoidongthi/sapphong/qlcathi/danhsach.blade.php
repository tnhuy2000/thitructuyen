@extends('layouts.admin-hoidong-layout')
@section('title','Quản lý ca thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý ca thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item">Quản lý ca thi</li>
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
		  	<a href="{{ route('hoidongthi.qlcathi.them') }}" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	
            
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th width="15%">Tên ca</th>
					<th width="15%">Ngày thi</th>
					<th width="15%">Giờ bắt đầu</th>
					<th width="30%">Kỳ thi</th>
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($cathi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->tenca }}</td>
						<td>{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}</td>
						<td>{{ $value->giobatdau }}</td>
						<td>
							<span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span>
							<span style="font-size:0.9em;">
								
								@if(!empty($value->hocky))
									<br />Học kỳ: {{ $value->hocky }}
								@endif
								@if(!empty($value->namhoc))
									<br />Năm học: {{ $value->namhoc }}
								@endif
							</span>
						</td>
						<td class="text-center"><a href="{{ route('hoidongthi.qlcathi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
						<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa ca thi {{$value->tenca}}?')" href="{{ route('hoidongthi.qlcathi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
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
