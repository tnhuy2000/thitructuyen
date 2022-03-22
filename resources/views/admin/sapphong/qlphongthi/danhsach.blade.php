@extends('layouts.admin-layout')
@section('title','Quản lý phòng thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
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
		 
		<a href="{{ route('admin.sapphong.qlphongthi.them') }}" class="btn btn-outline-primary mt-3 "><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	
            <!-- Bordered Tabs Justified -->
			<ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-dangdienra" type="button" role="tab" aria-controls="home" aria-selected="true">Đang diễn ra</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-sapdienra" type="button" role="tab" aria-controls="profile" aria-selected="false">Sắp diễn ra</button>
                </li>
				<li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 fw-bold" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-dathi" type="button" role="tab" aria-controls="contact" aria-selected="false">Đã kết thúc</button>
                </li>
              
              </ul>
			 
              <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                <div class="tab-pane fade show active" id="bordered-justified-dangdienra" role="tabpanel" aria-labelledby="home-tab">
					 <!-- Table with stripped rows -->
					<table class="table datatable table-hover caption-top">
					<caption>Danh sách phòng thi</caption>
						<thead class="table-light">
							<tr>
								<th width="2%">#</th>
								<th width="10%">Mã phòng</th>
								<th>Ca thi</th>
								<th width="10%">SL thí sinh</th>
								<th width="10%">Mã meeting</th>
								<th width="10%">Ghi chú</th>
								<th width="10%">Đề thi</th>
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">{{ $value->maphong }}</td>

									<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
										<span style="font-size:0.9em;">
										
											@if(!empty($value->ngaythi))
												<br />{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
											@endif
											@if(!empty($value->giobatdau))
												<br />{{ $value->giobatdau }}
											@endif
										</span>
									</td>
									<td>{{ $value->soluongthisinh }}</td>
									<td class="small">{{ $value->ma_meeting }}</td>
									<td class="small">{{ $value->ghichu }}</td>
									<td><a href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
									<td class="text-center">
										<a href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thí sinh</span></a>
										<a href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Hội đồng thi</span> </a>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa phòng thi {{$value->maphong}}?')" href="{{ route('admin.sapphong.qlphongthi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Table with stripped rows -->
                </div>
				<div class="tab-pane fade" id="bordered-justified-sapdienra" role="tabpanel" aria-labelledby="contact-tab">
                   <!-- Table with stripped rows -->
					<table class="table datatable table-hover caption-top">
					<caption>Danh sách phòng thi</caption>
						<thead class="table-light">
							<tr>
								<th width="2%">#</th>
								<th width="10%">Mã phòng</th>
								<th>Ca thi</th>
								<th width="10%">SL thí sinh</th>
								<th width="10%">Mã meeting</th>
								<th width="10%">Ghi chú</th>
								<th width="10%">Đề thi</th>
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">{{ $value->maphong }}</td>

									<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
										<span style="font-size:0.9em;">
										
											@if(!empty($value->ngaythi))
												<br />{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
											@endif
											@if(!empty($value->giobatdau))
												<br />{{ $value->giobatdau }}
											@endif
										</span>
									</td>
									<td>{{ $value->soluongthisinh }}</td>
									<td class="small">{{ $value->ma_meeting }}</td>
									<td class="small">{{ $value->ghichu }}</td>
									<td><a href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
									<td class="text-center">
										<a href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thí sinh</span></a>
										<a href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Hội đồng thi</span> </a>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa phòng thi {{$value->maphong}}?')" href="{{ route('admin.sapphong.qlphongthi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Table with stripped rows -->
                </div>
                <div class="tab-pane fade" id="bordered-justified-dathi" role="tabpanel" aria-labelledby="profile-tab">
					 <!-- Table with stripped rows -->
					<table class="table datatable table-hover caption-top">
						<caption>Danh sách phòng thi</caption>
						<thead class="table-light">
							<tr>
								<th width="2%">#</th>
								<th width="10%">Mã phòng</th>
								<th>Ca thi</th>
								<th width="10%">SL thí sinh</th>
								<th width="10%">Mã meeting</th>
								<th width="10%">Ghi chú</th>
								<th width="10%">Đề thi</th>
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">{{ $value->maphong }}</td>

									<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
										<span style="font-size:0.9em;">
										
											@if(!empty($value->ngaythi))
												<br />{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
											@endif
											@if(!empty($value->giobatdau))
												<br />{{ $value->giobatdau }}
											@endif
										</span>
									</td>
									<td>{{ $value->soluongthisinh }}</td>
									<td class="small">{{ $value->ma_meeting }}</td>
									<td class="small">{{ $value->ghichu }}</td>
									<td><a href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
									<td class="text-center">
										<a href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}"> <span class="badge bg-danger"><i class="bx bx-plus-circle"></i> Thí sinh</span></a>
										<a href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Hội đồng thi</span> </a>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa phòng thi {{$value->maphong}}?')" href="{{ route('admin.sapphong.qlphongthi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
		  <!-- End Table with stripped rows -->
                </div>
               
              </div><!-- End Bordered Tabs Justified --> 
		 

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
