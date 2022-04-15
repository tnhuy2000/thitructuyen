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
	  <li class="breadcrumb-item"><a href="{{route('admin.thongbao.danhsach')}}">Quản lý thông báo</a></li>
	  <li class="breadcrumb-item active">Thêm mới</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Thêm mới</h5>
              
              <form role="form" method="post" action="{{ route('admin.thongbao.sua', ['id' => $thongbao->id]) }}" class="row g-3 needs-validation" novalidate>
				@csrf
			
					<div class="col-md-12">
						<label class="form-label" for="loai"> Loại thông báo <span class="text-danger font-weight-bold">*</span></label>
						<select class="form-select @error('loai') is-invalid @enderror" id="loai" name="loai" required>
							    <option value="">-- Chọn loại --</option>
								@if($thongbao->loai=='don')
									<option value="don" selected="selected">Thông báo đơn</option>
									<option value="dinhkem">Thông báo có đính kèm văn bản</option>
								@else
									<option value="don">Thông báo đơn</option>
                                	<option value="dinhkem" selected="selected">Thông báo có đính kèm văn bản</option>
								@endif
						
						</select>
						@error('loai')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					
			
				<div class="col-md-12">
					<label class="form-label" for="tieude">Tiêu đề <span class="text-danger fw-bold">*</span></label>
					<input type="text" class="form-control @error('tieude') is-invalid @enderror" id="tieude" name="tieude" value="{{ $thongbao->tieude }}" required />
					@error('tieude')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
					@enderror
				</div>
				
				<div class="col-md-12">
					<label class="form-label" for="noidung">Nội dung thông báo <span class="text-danger fw-bold">*</span></label>
					<textarea class="form-control @error('noidung') is-invalid @enderror ckeditor" id="noidung" name="noidung" required>{{ $thongbao->noidung }}</textarea>
					@error('noidung')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
					@enderror
				</div>
				
				<div class="form-group" id="divDinhKem">
					<span class="text-danger"><i class="fa-solid fa-link"></i> Văn bản đính kèm được cập nhật ở bước tiếp theo.</span>
				</div>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" id="quantrong" name="quantrong" value="1" @if($thongbao->quantrong == 1) checked @endif />
						<label class="custom-control-label" for="quantrong">Ghim thông báo lên trên cùng</label>
					</div>
				</div>
				<div class="col-12">
				@if($thongbao->loai == 'dinhkem')
					<button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Lưu và tiếp tục</button>
				@else
					<button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Cập nhật thông báo</button>
				@endif
				</div>
			</form>
            </div>
	    </div>

	  </div>
  </div>
</section>

</main><!-- End #main -->
@endsection
@section('javascript')
	<script src="{{ asset('public/js/ckeditor/4.15.0/ckeditor.js') }}"></script>
	<script src="{{ asset('public/js/ckfinder/ckfinder.js') }}"></script>
	<script>
		$(document).ready(function() {
			if($("#loai").val() == "don") {
				$("#divDinhKem").hide();
			
			} else if($("#loai").val() == "dinhkem") {
				$("#divDinhKem").show();
				
			} else {
				$("#divDinhKem").hide();
			
			}
			$("#loai").change(function() {
				if($("#loai").val() == "don") {
					$("#divDinhKem").hide();			
				} else if($("#loai").val() == "dinhkem") {
					$("#divDinhKem").show();				
				} else {
					$("#divDinhKem").hide();
				}
			});
			
			var index = 2;
			$(".btn-add-more").click(function() {
				$(".copy input[name^='dinhkem']").attr("id", "dinhkem" + index);
				$(".copy input[name^='tenvanban']").attr("id", "tenvanban" + index);
				$(".copy a").attr("onclick", "BrowseServer(" + index + ");");
				index++;
				
				var html = $(".copy").html();
				$(".add-more-after").after(html);
			});
			$("body").on("click", ".btn-remover", function() {
				$(this).parents(".form-row").remove();
			});
		});
		
		function escapeHtml(unsafe)
		{
			return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
		}
		
		function BrowseServer(index)
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
						var output = document.getElementById("dinhkem" + index);
						output.value = escapeHtml(file.get('name'));
					});
					finder.on('file:choose:resizedImage', function(evt) {
						var output = document.getElementById("dinhkem" + index);
						output.value = escapeHtml(evt.data.file.get('name'));
					});
				}
			});
		}
	</script>
@endsection