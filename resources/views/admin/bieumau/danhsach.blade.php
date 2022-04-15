@extends('layouts.admin-layout')
@section('pagetitle')
Biểu mẫu
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Biểu mẫu</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item active">Biểu mẫu</li>
	  
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Biểu mẫu</h5>
			
			
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
						<th width="4%">#</th>					
						<th width="45%">Tên biểu mẫu (dùng cho import excel)</th>
						<th width="15%">Tải xuống</th>
				</tr>
			</thead>
			<tbody>
                    <tr>
                        <td>1</td>
                        <td class="text-justify"><i class="fa-solid fa-file-excel"></i> Danh sách Khoa</td> 
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'khoa'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Lớp</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'lop'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Học phần</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'hocphan'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Sinh viên</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'sinhvien'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Hội đồng thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'hoidongthi'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Kỳ thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'kythi'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Ca thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'cathi'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Phòng thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'phongthi'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Sinh viên - Phòng thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'sv_pt'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Hội đồng thi - Phòng thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'hdt_pt'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td><i class="fa-solid fa-file-excel"></i> Danh sách Đề thi</td>
                        <td><a href="{{route('admin.taibieumau',['tenbieumau'=>'dethi'])}}"><i class="fa-solid fa-download" title="Tải biểu mẫu"></i></a></td>
                    </tr>
                        	
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
   


@endsection
@section('javascript')    
<script type="text/javascript">
  		function getXoa(id) {
			$('#ID_delete').val(id);
		}
		
  </script>
  
@endsection
