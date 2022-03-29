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
      @php 
      $ngaythi= Carbon\Carbon::parse($cathi_theongay->ngaythi)->format('d-m-Y');
      @endphp
	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qlbaithi.cathi',['ngaythi' =>$ngaythi] )}}">{{$ngaythi}}</a></li>
	  <li class="breadcrumb-item active">{{$cathi_theongay->tenca}}</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Dữ liệu bài thi ngày: {{$cathi_theongay->ngaythi}} | Ca thi: {{$cathi_theongay->tenca}}</h5>
		
		
             <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th>Phòng thi</th>
					<th width="25%">Tải xuống</th>
					<th width="25%">Mở thư mục</th>
				</tr>
			</thead>
			<tbody>
                   
                  
                    @foreach($phongthi_theoca as $value)
                    @php
						$ngaythi_format= Carbon\Carbon::parse($value->ngaythi)->format('d-m-Y');
					@endphp
				<tr>
                   
                        <td>{{ $loop->iteration }}</td>       
                        <td>{{$value->maphong}}</td>
                        <td>
                        @php
                        foreach ($folder as $fileInfo){
                            if($fileInfo->isDot()) continue;
                            $subject = $fileInfo->getFilename();
                            $search = ['phong-'];
                            $replace   = '';
                           
                            $result = str_replace($search, $replace, $subject);
                         
                            if($value->maphong==$result){
                            @endphp
                            <a href="{{route('admin.dethi_baithi.qlbaithi.zipPhongThi',['ngaythi' => $ngaythi_format,'cathi'=>$cathi,'phongthi'=>$fileInfo->getFilename()])}}"><i class="bx bxs-download"></i>Tải</a>
                            @php
                            }
                        }
                        @endphp
                        </td>
                        <td>
                          @php
                          foreach ($folder as $fileInfo){
                              if($fileInfo->isDot()) continue;
                              $subject = $fileInfo->getFilename();
                              $search = ['phong-'];
                              $replace   = '';
                            
                              $result = str_replace($search, $replace, $subject);
                          
                              if($value->maphong==$result){
                              @endphp
                              <a href="{{route('admin.dethi_baithi.qlbaithi.ketquabaithi',['phongthi'=>$value->id])}}"><i class="bx bxs-folder-open text-warning"></i> Mở</a>
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
