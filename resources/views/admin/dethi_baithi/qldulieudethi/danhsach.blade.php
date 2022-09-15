@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý dữ liệu đề thi
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý dữ liệu đề thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qldethi.danhsach')}}">Quản lý đề thi</a></li>
	  <li class="breadcrumb-item">Quản lý dữ liệu đề thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">

		<h5 class="card-title">Học phần: {{$ktdethi->tenhocphan}} | Kỳ thi: {{$ktdethi->tenkythi}} </h5>
		<h6>Học kỳ: {{$ktdethi->hocky}} | Năm học: {{$ktdethi->namhoc}} </h5>
		<h6>Thời gian làm bài: {{$ktdethi->thoigianlambai}} phút</h6>
		<h6>Hình thức làm bài: 
			@if($ktdethi->hinhthuc=="tuluan")
				<span>Tự luận</span> 
			@else
				<span>Thực hành</span>
			@endif
		</h6>
		<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-plus"></i> Thêm dữ liệu</button></p>
		<table class="table table-hover table-bordered">
		  	<thead>
				<tr>
					<th scope="col" width="2%">#</th>
				
					<th scope="col">Tập tin</th>
					<th scope="col"  width="15%">Thứ tự hiển thị</th>
					<th scope="col" width="15%">Ghi chú</th>
					<th scope="col" width="8%" class="text-center">Sửa</th>
					<th scope="col" width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($ktdulieudethi as $value)
					<tr >
						<td>{{ $count++ }}</td>
				
                        <td>
							@php
								$ex=pathinfo($value->duongdan, PATHINFO_EXTENSION);
							@endphp
							@if ($ex=='png' || $ex=='jpg')
							<img class="img-thumbnail border-warning" src="{{ $path . $value->duongdan }}" width="100" height="130" />
							<span style="font-size: 0.8em;">{{$value->duongdan}}</span>
							@else
							<i class="fa-regular fa-file"></i> <span style="font-size: 0.8em;">{{$value->duongdan}}</span>
							@endif
							
							
                    	</td>
                        <td>{{ $value->thutuhienthi }}</td>
						<td>{{ $value->ghichu }}</td>
						
						<td class="text-center"><a href="#sua" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModalEdit" onclick="getCapNhat({{ $value->id }},{{ $value->dethi_id }}, '{{ $value->duongdan }}','{{ $value->ghichu }}', {{ $value->thutuhienthi }}); return false;"><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a href="#xoa" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},{{$value->dethi_id}},'{{$value->duongdan}}'); return false;" ><i class="fa-regular fa-trash-can"></i></a></td>
					</tr>
				@endforeach
			</tbody>
		  </table>
            <h5 class="text-danger"><strong>Tổng số file: {{$count-1}}</strong></h5>
		
		</div>
	  </div>

	</div>
  </div>
</section>

</main><!-- End #main -->
    <!--Thêm mới-->
<form action="{{route('admin.dethi_baithi.qldulieudethi.themmoi',['dethi_id' => $ktdethi->id])}}" method="post">
		@csrf
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" >
			<div class="modal-dialog modal-lg"role="document" >
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Thêm dữ liệu đề thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="HinhAnh"> File<span class="text-danger font-weight-bold">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="ChonHinh"><a href="#hinhanh">Tải file lên</a></div>
                                    </div>
                                    
                                    <input type="text" class="form-control @error('HinhAnh') is-invalid @enderror" id="HinhAnh" name="HinhAnh" value="{{ old('HinhAnh') }}" readonly required />
                                    @error('HinhAnh')
                                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ghichu"> Ghi chú</label>
                                <input type="text" class="form-control @error('ghichu') is-invalid @enderror" id="ghichu" name="ghichu" />
                                @error('ghichu')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="thutuhienthi"> Thứ tự hiển thị</label>
                                <input type="text" class="form-control @error('thutuhienthi') is-invalid @enderror" id="thutuhienthi" name="thutuhienthi" value="1" />
                                @error('thutuhienthi')
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

	
	<form action="{{ route('admin.dethi_baithi.qldulieudethi.sua') }}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="dethi_id_edit" name="dethi_id_edit" value="" />
		<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabelEdit">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myModalLabelEdit">Cập nhật dữ liệu đề thi</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						
						<div class="form-group">
							<label for="HinhAnh_edit">File dữ liệu đề thi <span class="text-danger font-weight-bold">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text" id="ChonHinh_edit"><a href="#hinhanh">Tải file khác</a></div>
								</div>
								<input type="text" class="form-control @error('hinhanh_edit') is-invalid @enderror" id="hinhanh_edit" name="hinhanh_edit" value="{{ old('hinhanh_edit') }}" readonly required />
								@error('hinhanh_edit')
									<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
								@enderror
							</div>
						</div>
						
						<div class="form-group">
							<label for="">Ghi chú</label>
							<input type="text" class="form-control @error('ghichu_edit') is-invalid @enderror" id="ghichu_edit" name="ghichu_edit" value="{{ old('ghichu_edit') }}" />
								@error('ghichu_edit')
									<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
								@enderror
						</div>
						<div class="form-group">
							<label for="thutuhienthi_edit">Thứ tự hiển thị</label>
							<input type="text" class="form-control @error('thutuhienthi_edit') is-invalid @enderror" id="thutuhienthi_edit" name="thutuhienthi_edit" value="{{ old('thutuhienthi_edit') }}" />
							@error('thutuhienthi_edit')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	
	<form action="{{ route('admin.dethi_baithi.qldulieudethi.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id_delete" value="" />
		<input type="hidden" id="dethi_id_delete" name="dethi_id_delete" value="" />
		<input type="hidden" id="duongdan_delete" name="duongdan_delete" value="" />
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá dữ liệu đề thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question "></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
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
<script src="{{ asset('public/js/ckfinder/ckfinder.js') }}"></script>
	<script>
		function getCapNhat(id, dethi_id, duongdan, ghichu, thutuhienthi) {
			$('#id_edit').val(id);
			$('#dethi_id_edit').val(dethi_id);
			$('#hinhanh_edit').val(duongdan);
			$('#ghichu_edit').val(ghichu);
			$('#thutuhienthi_edit').val(thutuhienthi);
		}
		function escapeHtml(unsafe)
		{
			return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
		}
		
		var chonHinh = document.getElementById('ChonHinh');
		chonHinh.onclick = function() { selectFileWithCKFinder('HinhAnh'); };
		
		var chonHinhEdit = document.getElementById('ChonHinh_edit');
		chonHinhEdit.onclick = function() { selectFileWithCKFinder('hinhanh_edit'); };
		
		function selectFileWithCKFinder(elementId)
		{
			CKFinder.modal(
			{
				chooseFiles: true,
				displayFoldersPanel: false,
				width: 800,
				height: 500,
				onInit: function(finder) {
					finder.on('files:choose', function(evt) {
						var file = evt.data.files.first();
						var output = document.getElementById(elementId);
						output.value = escapeHtml(file.get('name'));
					});
					finder.on('file:choose:resizedImage', function(evt) {
						var output = document.getElementById(elementId);
						output.value = escapeHtml(evt.data.file.get('name'));
					});
				}
			});
		}
		
		@if($errors->has('HinhAnh') || $errors->has('thutuhienthi') || $errors->has('ghichu'))
			$('#myModal').modal('show');
		@endif
		
		function getXoa(id,dethi_id,duongdan) {
			$('#id_delete').val(id);
			$('#dethi_id_delete').val(dethi_id);
			$('#duongdan_delete').val(duongdan);
		}
	</script>
@endsection
