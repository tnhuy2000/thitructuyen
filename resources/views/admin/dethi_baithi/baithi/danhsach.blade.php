@extends('layouts.admin-layout')
@section('title','Quản lý bài thi & dữ liệu bài thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý bài thi & dữ liệu bài thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Đề thi & bài thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qlbaithi.danhsach')}}">Quản lý bài thi & dữ liệu bài thi</a></li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Dữ liệu bài thi theo ngày</h5>
		
             <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
                    
					<th>Ngày thi</th>
					<th width="25%">Tải xuống</th>
					<th width="25%">Mở thư mục</th>
				</tr>
			</thead>
			<tbody>
                   
                    @php 
                    $count = 1;
                    foreach ($folder as $fileInfo){
                        if($fileInfo->isDot()) continue;
                    @endphp
				<tr>
                    
                    <td>{{ $count++ }}</td>       
                       
                    <td>{{$fileInfo->getFilename(), PHP_EOL}}</td>
                    <td><a href="{{route('admin.dethi_baithi.qlbaithi.zipNgayThi',['ngaythi' => $fileInfo->getFilename()])}}"><i class="bx bxs-download"></i> Tải</a></td>
                    <td><a href="{{route('admin.dethi_baithi.qlbaithi.cathi',['ngaythi' => $fileInfo->getFilename()])}}"><i class="bx bxs-folder-open text-warning"></i> Mở</a></td>
						
                </tr>
                @php
                    }
                @endphp   
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->
		</div>
	  </div>

	</div>
  </div>
</section>

</main><!-- End #main -->

<form action="{{ route('admin.dethi_baithi.qldethi_phongthi.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="id_delete" name="id_delete" value="" />
		<input type="hidden" id="phongthi_id_delete" name="phongthi_id_delete" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá đề thi - phòng thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fal fa-question-circle"></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"><i class="fal fa-trash-alt"></i> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(id,phongthi_id) {
			$('#id_delete').val(id);
			$('#phongthi_id_delete').val(phongthi_id);
		}
		function getSua(id,dethi_id,phongthi_id,ghichu) {
			$('#id_edit').val(id);
			$('#dethi_id_edit').val(dethi_id);
			$('#phongthi_id_edit').val(phongthi_id);
			$('#ghichu_edit').val(ghichu);
		}
		
		$(document).ready(function() {
            $("#states2").select2();   
        });
		
  </script>
@endsection
