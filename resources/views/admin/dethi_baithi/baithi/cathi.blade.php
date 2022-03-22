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
	  <li class="breadcrumb-item active">{{$ngaythi}}</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Dữ liệu bài thi ngày: {{$ngaythi}}</h5>
		
             <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
                    
					<th>Đường dẫn</th>
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
                       
                    <td><i class="bx bxs-folder text-warning"></i> {{$ngaythi}}/{{$fileInfo->getFilename(), PHP_EOL}}</td>
                    <td><a href="{{route('admin.dethi_baithi.qlbaithi.zipCaThi',['ngaythi' => $ngaythi, 'cathi'=>$fileInfo->getFilename()])}}"><i class="bx bxs-download"></i>Tải</a></td>
                    <td><a href="{{route('admin.dethi_baithi.qlbaithi.phongthi',['ngaythi'=>$ngaythi,'cathi' => $fileInfo->getFilename()])}}"><i class="bx bxs-folder-open text-warning"></i> Mở</a></td>
                   
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
