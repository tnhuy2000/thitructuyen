@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý phòng thi
@endsection

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
		<h5 class="card-title">Danh sách phòng thi</h5>
		<a href="{{ route('admin.sapphong.qlphongthi.them') }}" class="btn btn-primary  "><i class="fa-solid fa-plus"></i> Thêm mới</a>
		<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa-solid fa-upload"></i> Nhập từ Excel</a>
		{{-- <a href="#nhap" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fa-solid fa-download"></i> Xuất ra Excel</a>
			 --}}
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
								<th width="10%">Bài thi</th>
								<th width="10%">Đề thi</th>
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi_dangdienra as $value)
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
									<td class="small"><a class="btn btn-sm btn-success" href="{{ route('admin.dethi_baithi.qlbaithi.ketquabaithi', ['phongthi'=>$value->id]) }}" title="Xem kết quả bài thi"><i class="bi bi-eye-fill"></i></a></td>
									<td><a class="btn btn-sm btn-danger" href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}" title="Thêm đề thi"><i class="fa-solid fa-paperclip"></i></a></td>
							
									<td class="text-center">
										<a class="btn btn-sm btn-primary" href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}" title="Thêm sinh viên"><i class="fa-solid fa-plus"></i> Sinh viên</a>
										<a class="btn btn-sm btn-warning mt-1" href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}" title="Thêm hội đồng thi"><i class="fa-solid fa-plus"></i> Hội đồng thi</a>
									</td>
									<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
									<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},'{{$value->maphong}}'); return false;"   href="#xoa"><i class="fa-regular fa-trash-can"></i></a></td>
					
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
								<th width="10%">Bài thi</th>
								<th width="10%">Đề thi</th>
								
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi_sapdienra as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">{{ $value->maphong }}</td>

									<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
										<span style="font-size:0.8em;">
										
											@if(!empty($value->ngaythi))
												<br />{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
											@endif
											@if(!empty($value->giobatdau))
												<br />{{ $value->giobatdau }}
											@endif
										</span>
									</td>
									<td>{{ $value->soluongthisinh }}</td>
									<td class="small"><span style="font-size:0.9em;">{{ $value->ma_meeting }}</span></td>
									<td class="small">{{ $value->ghichu }}</td>
									<td class="small"><a class="btn btn-sm btn-success" href="{{ route('admin.dethi_baithi.qlbaithi.ketquabaithi', ['phongthi'=>$value->id]) }}" title="Xem kết quả bài thi"><i class="fa-solid fa-eye"></i></a></td>
									<td><a class="btn btn-sm btn-danger" href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}" title="Thêm đề thi"><i class="fa-solid fa-paperclip"></i></a></td>
									
									<td class="text-center">
										<a class="btn btn-sm btn-primary" href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}" title="Thêm sinh viên"><i class="fa-solid fa-plus"></i> Sinh viên</a>
										<a class="btn btn-sm btn-warning mt-1" href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}" title="Thêm hội đồng thi"><i class="fa-solid fa-plus"></i> Hội đồng thi</a>
									</td>
									<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
									<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},'{{$value->maphong}}'); return false;"   href="#xoa"><i class="fa-regular fa-trash-can"></i></a></td>
					
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
								<th width="8%">Bài thi</th>
								<th width="10%">Đề thi</th>
								
								<th width="15%" class="text-center">Danh sách</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($phongthi_daketthuc as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">{{ $value->maphong }}</td>

									<td><span style="color:#0000ff;font-weight:bold;">{{ $value->tenca }}</span>
										<span style="font-size:0.8em;">
										
											@if(!empty($value->ngaythi))
												<br />{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
											@endif
											@if(!empty($value->giobatdau))
												<br />{{ $value->giobatdau }}
											@endif
										</span>
									</td>
									<td>{{ $value->soluongthisinh }}</td>
									<td class="small"><span style="font-size:0.9em;">{{ $value->ma_meeting }}</span></td>
									<td class="small">{{ $value->ghichu }}</td>
									<td class="small"><a class="btn btn-sm btn-success" href="{{ route('admin.dethi_baithi.qlbaithi.ketquabaithi', ['phongthi'=>$value->id]) }}" title="Xem kết quả bài thi"><i class="fa-solid fa-eye"></i></a></td>
									<td><a class="btn btn-sm btn-danger" href="{{ route('admin.dethi_baithi.qldethi_phongthi.danhsach', ['id' => $value->id]) }}" title="Thêm đề thi"><i class="fa-solid fa-paperclip"></i></a></td>
								
									<td class="text-center">
										<a class="btn btn-sm btn-primary" href="{{ route('admin.sapphong.qlsv_pt.danhsach', ['id' => $value->id]) }}" title="Thêm sinh viên"><i class="fa-solid fa-plus"></i> Sinh viên</a>
										<a class="btn btn-sm btn-warning mt-1" href="{{ route('admin.sapphong.qlhdt_pt.danhsach', ['id' => $value->id]) }}" title="Thêm hội đồng thi"><i class="fa-solid fa-plus"></i> Hội đồng thi</a>
									</td>
									<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $value->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
									<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},'{{$value->maphong}}'); return false;"   href="#xoa"><i class="fa-regular fa-trash-can"></i></a></td>
					
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
<form action="{{ route('admin.sapphong.qlphongthi.nhap') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModalLabel">Nhập từ Excel</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="mb-0">
						<label for="file_excel" class="form-label">Chọn tập tin Excel</label>
						<input type="file" class="form-control" id="file_excel" name="file_excel" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form> 
<form action="{{ route('admin.sapphong.qlphongthi.xoa') }}" method="post">
	@csrf
	<input type="hidden" id="id_delete" name="id" value="" />
	
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Xoá phòng thi</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<p ><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận muốn xoá phòng thi <span id="maphong" class="fw-bold text-danger"></span>.</p>
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
<script type="text/javascript">
  		function getXoa(id,maphong) {
			$('#id_delete').val(id);
			$('#maphong').text(maphong);
		}
		
		@if($errors->has('id') || $errors->has('tenkhoa')  )
			$('#myModal').modal('show');
		@endif
		
		@if($errors->has('id_edit') || $errors->has('tenkhoa_edit'))
			$('#myModalEdit').modal('show');
		@endif
  </script>
@endsection
