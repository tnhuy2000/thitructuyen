@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý bài thi và dữ liệu đề thi
@endsection
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
                    @endphp

				@foreach($ngaythi as $value)
				<tr>
                    
                    <td>{{ $count++ }}</td> 
					@php
						$ngaythi_format= Carbon\Carbon::parse($value->ngaythi)->format('d-m-Y');
					@endphp
                    <td>{{$ngaythi_format}}</td>
					<td>
					@php
				
					foreach ($folder as $fileInfo){
                        if($fileInfo->isDot()) continue;
							
							if($ngaythi_format==$fileInfo->getFilename()){
							@endphp
							<a href="{{route('admin.dethi_baithi.qlbaithi.zipNgayThi',['ngaythi' => $fileInfo->getFilename()])}}"><i class="fa-solid fa-download"></i> Tải xuống</a>	
							@php
							}
						}
					@endphp
					</td>
					<td>
						@php
					foreach ($folder as $fileInfo){
                        if($fileInfo->isDot()) continue;
							
						if($ngaythi_format==$fileInfo->getFilename()){
						@endphp
							<a href="{{route('admin.dethi_baithi.qlbaithi.cathi',['ngaythi' => $ngaythi_format])}}"><i class="fa-regular fa-folder-open text-warning"></i> Mở</a>
						@php
						}
					}
					@endphp
					</td>
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
  		function getXoa(id,phongthi_id) {
			$('#id_delete').val(id);
			$('#phongthi_id_delete').val(phongthi_id);
		}
		

  </script>
@endsection
