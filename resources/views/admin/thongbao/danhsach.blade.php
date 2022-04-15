@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý thông báo
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý thông báo</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item active">Quản lý thông báo</li>
	  
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Quản lý thông báo</h5>
			<a href="{{ route('admin.thongbao.them') }}"  class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
			
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
						<th width="4%">#</th>
					
						<th width="45%">Thông báo</th>
						<th width="8%" title="Thông báo quan trọng">Top</th>
						<th width="8%">O/F</th>
						<th width="8%">Sửa</th>
						<th width="8%">Xóa</th>
				</tr>
			</thead>
			<tbody>
			@foreach($thongbao as $value)
						<tr>
							<td>{{ $loop->iteration }}</td>
							
							<td class="text-justify">
								<span class="font-weight-bold text-primary"><a href="{{ route('admin.thongbao.sua', ['id' => $value->id]) }}">{{ $value->tieude }}</a></span>
								<span class="small">
									@if(!empty($value->loai))
										<br />Loại thông báo: @if($value->loai=='don') 
										<span class="badge rounded-pill bg-primary">Thông báo đơn</span> 
										@else 
										<span class="badge rounded-pill bg-danger">Thông báo có văn bản đính kèm </span>
										@endif
										@if($value->loai == 'dinhkem')
											(<a href="{{ route('admin.thongbao.vanban', ['id' => $value->id]) }}">Chỉnh sửa văn bản</a>)
										@endif
									@endif
									@if(!empty($value->created_at))
										<br />Ngày đăng: {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y H:i:s') }}
									@endif
									
								</span>
							</td>
							<td>
								@if($value->quantrong == 1)
									<h2><a href="{{ route('admin.thongbao.quantrong', ['id' => $value->id]) }}"><i class="fa-solid fa-circle-check text-success" title="Thông báo quan trọng"></i></a></h2>
								@else
								<h2><a href="{{ route('admin.thongbao.quantrong', ['id' => $value->id]) }}"><i class="fa-solid fa-circle-xmark text-danger" title="Thông báo bình thường"></i></a></h2>
								@endif
							</td>
							<td >
								@if($value->kichhoat == 1)
									<h2><a href="{{ route('admin.thongbao.kichhoat', ['id' => $value->id]) }}"><i class="fa-solid fa-circle-check text-success" title="Kích hoạt"></i></a></h2>
								@else
									<h2><a href="{{ route('admin.thongbao.kichhoat', ['id' => $value->id]) }}"><i class="fa-solid fa-circle-xmark text-danger" title="Bị khóa"></i></a></h2>
								@endif
							</td>
							<td ><a class="btn btn-primary btn-sm" href="{{ route('admin.thongbao.sua', ['id' => $value->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
							<td ><a href="#xoa" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id }}); return false;"><i class="fa-regular fa-trash-can"></i></td>
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

</main>


<!-- End #main -->
   
<form action="{{ route('admin.thongbao.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="ID_delete" name="ID_delete" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá thông báo</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question "></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>


@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(id) {
			$('#ID_delete').val(id);
		}
		
  </script>
  
@endsection
