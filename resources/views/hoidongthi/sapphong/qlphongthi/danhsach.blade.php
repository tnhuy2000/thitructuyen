@extends('layouts.admin-hoidong-layout')
@section('title','Quản lý phòng thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('hoidongthi.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item">Quản lý phòng thi</li>
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
		  	<a href="{{ route('hoidongthi.qlphongthi.them') }}" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	
            
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th width="15%">Mã phòng</th>
					<th width="20%">Ca thi</th>
					<th width="15%">SL thí sinh</th>
					<th width="15%">Ghi chú</th>
					<th width="10%">Đề thi</th>
					<th width="15%">Danh sách</th>
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($phongthi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->maphong }}</td>

						<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
							<span style="font-size:0.9em;">
							
								@if(!empty($value->ngaythi))
									<br />Ngày thi: {{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
								@endif
								@if(!empty($value->giobatdau))
									<br />Giờ bắt đầu: {{ $value->giobatdau }}
								@endif
							</span>
						</td>
						<td>{{ $value->soluongthisinh }}</td>
						<td>{{ $value->ghichu }}</td>
						<td><a href="{{ route('hoidongthi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
						<td>
							<a href="{{ route('hoidongthi.qlsv_pt.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thí sinh</span></a>
							<hr>
							<a href="{{ route('hoidongthi.qlhdt_pt.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Hội đồng thi</span> </a>
						</td>
						<td class="text-center"><a href="{{ route('hoidongthi.qlphongthi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
						<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa phòng thi {{$value->maphong}}?')" href="{{ route('hoidongthi.qlphongthi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
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
