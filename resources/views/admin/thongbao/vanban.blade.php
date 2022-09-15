@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý văn bản
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý văn bản</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
      <li class="breadcrumb-item"><a href="{{route('admin.thongbao.danhsach')}}">Quản lý thông báo</a></li>
	  <li class="breadcrumb-item active">Cập nhật đính kèm</li>
	  
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Cập nhật đính kèm cho {{ $thongbao->tieude }}</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa-solid fa-plus"></i> Thêm mới</button>
			
            <table class="table datatable table-hover table-sm">
				<thead>
					<tr>
						<th width="5%">#</th>
						<th width="30%">Tên văn bản</th>
						<th width="30%">Tập tin</th>
						<th width="10%">Lượt tải</th>
						<th width="9%">O/F</th>
						<th width="9%">Sửa</th>
						<th width="9%">Xóa</th>
					</tr>
				</thead>
				<tbody>
					@foreach($vanban as $value)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
								{{ $value->tenvanban }}<br />
								<span class="small"><i class="fa-solid fa-link"></i> <span class="text-primary">{{ $value->tenvanbankhongdau }}</span></span>
							</td>
							<td><i class="fa-regular fa-file"></i> {{ $value->duongdan }}</td>
							<td>{{ $value->luotdownload }}</td>
							<td >
								@if($value->kichhoat == 1)
									<h2><a href="{{ route('admin.thongbao.vanban.kichhoat', ['idthongbao' => $thongbao->id, 'id' => $value->id]) }}"><i class="fa-solid fa-circle-check text-success" title="Kích hoạt"></i></a></h2>
								@else
                                    <h2><a href="{{ route('admin.thongbao.vanban.kichhoat', ['idthongbao' => $thongbao->id, 'id' => $value->id]) }}"><i class="fa-solid fa-circle-xmark text-danger" title="Bị khóa"></i></a></h2>
								@endif
							</td>
							<td ><a class="btn btn-primary btn-sm" href="#sua" data-bs-toggle="modal" data-bs-target="#myModalEdit" onclick="getCapNhat({{ $value->id }}, '{{ $value->tenvanban }}', '{{ $value->duongdan }}'); return false;"><i class="fa-regular fa-pen-to-square"></i></a></td>
							<td ><a class="btn btn-danger btn-sm" href="#xoa" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id }}); return false;"><i class="fa-regular fa-trash-can"></i></a></td>
						</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	  </div>

	</div>
  </div>
</section>

</main>


<!-- End #main -->
   
<form action="{{ route('admin.thongbao.vanban.them') }}" method="post">
		@csrf
		<input type="hidden" id="thongbao_id" name="thongbao_id" value="{{ $thongbao->id }}" />
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myModalLabel">Thêm văn bản</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="mb-3">
							<label class="form-label" for="tenvanban">Tên văn bản <span class="text-danger fw-bold">*</span></label>
							<input type="text" class="form-control @error('tenvanban') is-invalid @enderror" id="tenvanban" name="tenvanban" value="{{ old('tenvanban') }}" required />
							@error('tenvanban')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@endif
						</div>
						<div class="mb-3">
							<label class="form-label" for="duongdan"> Đường dẫn <span class="text-danger fw-bold">*</span></label>
							<div class="input-group">
								
								<div class="input-group-text" id="chontaptin"><a href="#taptin">Chọn tập tin</a></div>
								
								<input type="text" class="form-control @error('duongdan') is-invalid @enderror" id="duongdan" name="duongdan" readonly required />
							</div>
							@error('duongdan')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@endif
						</div>
					</div>
					<div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<form action="{{ route('admin.thongbao.vanban.sua') }}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="text" id="thongbao_id_edit" name="thongbao_id_edit" value="{{ $thongbao->id }}" />
        <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabelEdit">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật văn bản</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
                    <div class="mb-3">
							<label class="form-label" for="tenvanban_edit"> Tên văn bản <span class="text-danger fw-bold">*</span></label>
							<input type="text" class="form-control @error('tenvanban_edit') is-invalid @enderror" id="tenvanban_edit" name="tenvanban_edit" required />
							@error('tenvanban_edit')
								<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@endif
						</div>
						<div class="mb-3">
							<label class="form-label"for="duongdan_edit"><span class="badge badge-info">2</span> Đường dẫn <span class="text-danger fw-bold">*</span></label>
							
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="chontaptin_edit"><a href="#hinhanh">Tải file lên</a></div>
                                </div>
                                
                                <input type="text" class="form-control @error('duongdan_edit') is-invalid @enderror" id="duongdan_edit" name="duongdan_edit" value="{{ old('duongdan_edit') }}" readonly required />
                                @error('duongdan_edit')
                                    <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
						
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
		
	</form>
	
	<form action="{{ route('admin.thongbao.vanban.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id_delete" value="" />
		<input type="hidden" id="thongbao_id_delete" name="thongbao_id_delete" value="{{ $thongbao->id }}" />
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myModalLabelDelete">Xóa văn bản</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question "></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
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
		function escapeHtml(unsafe)
		{
			return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
		}
		
		var chonTapTin = document.getElementById('chontaptin');

		chonTapTin.onclick = function() { selectFileWithCKFinder('duongdan'); };
		
		var chonTapTinEdit = document.getElementById('chontaptin_edit');
		chonTapTinEdit.onclick = function() { selectFileWithCKFinder('duongdan_edit'); };
		
		function selectFileWithCKFinder(elementid)
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
						var output = document.getElementById(elementid);
						output.value = escapeHtml(file.get('name'));
					});
					finder.on('file:choose:resizedImage', function(evt) {
						var output = document.getElementById(elementid);
						output.value = escapeHtml(evt.data.file.get('name'));
					});
				}
			});
		}
		
		function getCapNhat(id, tenVanVan, duongDan) {
			$('#id_edit').val(id);
			$('#tenvanban_edit').val(tenVanVan);
			$('#duongdan_edit').val(duongDan);
		}
		
		function getXoa(id) {
			$('#id_delete').val(id);
		}
		
		@if($errors->has('tenvanban') || $errors->has('duongdan'))
			var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
			document.onreadystatechange = function () {
			myModal.show();
			}
		@endif
		
		@if($errors->has('tenvanban') || $errors->has('duongdan_edit'))
			var myModal = new bootstrap.Modal(document.getElementById("myModalEdit"), {});
			document.onreadystatechange = function () {
			myModal.show();
			}
		@endif
		
					
	
	</script>
@endsection