@extends('layouts.admin-layout')
@section('title','Quản lý ca thi')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý ca thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item">Quản lý ca thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">
		<div class="card">
            <div class="card-body">
			<h5 class="card-title">Danh sách ca thi</h5>
		  	<a href="{{ route('admin.sapphong.qlcathi.them') }}" class="btn btn-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
			  <a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bx bxs-archive-out"></i> Nhập từ Excel</a>
			  <a href="#xuat" data-bs-toggle="modal" data-bs-target="#exportModal" class="btn btn-success"><i class="bx bxs-archive-in"></i> Xuất ra Excel</a>
		
			 
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
						@php
						$dt = Carbon\Carbon::now();
						$today= $dt->toDateString();
						@endphp
						<!-- <caption>Danh sách ca thi ngày: {{ \Carbon\Carbon::parse($today)->format('d/m/Y')}}</caption> -->
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="15%">Tên ca</th>
								<th width="15%">Ngày thi</th>
								<th width="15%">Giờ bắt đầu</th>
								<th width="30%">Kỳ thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($cathi_dangdienra as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td>{{ $value->tenca }}</td>
									<td>{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}</td>
									<td>{{ $value->giobatdau }}</td>
									<td>
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span>
										<span style="font-size:0.9em;">
											
											@if(!empty($value->hocky))
												<br />Học kỳ: {{ $value->hocky }}
											@endif
											@if(!empty($value->namhoc))
												<br />Năm học: {{ $value->namhoc }}
											@endif
										</span>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlcathi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa ca thi {{$value->tenca}}?')" href="{{ route('admin.sapphong.qlcathi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Table with stripped rows -->
                </div>
				<div class="tab-pane fade" id="bordered-justified-sapdienra" role="tabpanel" aria-labelledby="contact-tab">
                  <!-- Table with stripped rows -->
					<table class="table datatable table-hover">
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="15%">Tên ca</th>
								<th width="15%">Ngày thi</th>
								<th width="15%">Giờ bắt đầu</th>
								<th width="30%">Kỳ thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($cathi_sapdienra as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td>{{ $value->tenca }}</td>
									<td>{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}
									
									</td>
									<td>{{ $value->giobatdau }}</td>
									<td>
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span>
										<span style="font-size:0.9em;">
											
											@if(!empty($value->hocky))
												<br />Học kỳ: {{ $value->hocky }}
											@endif
											@if(!empty($value->namhoc))
												<br />Năm học: {{ $value->namhoc }}
											@endif
										</span>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlcathi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa ca thi {{$value->tenca}}?')" href="{{ route('admin.sapphong.qlcathi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Table with stripped rows -->
                </div>
                <div class="tab-pane fade" id="bordered-justified-dathi" role="tabpanel" aria-labelledby="profile-tab">
					<!-- Table with stripped rows -->
					<table class="table datatable table-hover">
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="15%">Tên ca</th>
								<th width="15%">Ngày thi</th>
								<th width="15%">Giờ bắt đầu</th>
								<th width="30%">Kỳ thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($cathi_dathi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td>{{ $value->tenca }}</td>
									<td>{{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}}</td>
									<td>{{ $value->giobatdau }}</td>
									<td>
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span>
										<span style="font-size:0.9em;">
											
											@if(!empty($value->hocky))
												<br />Học kỳ: {{ $value->hocky }}
											@endif
											@if(!empty($value->namhoc))
												<br />Năm học: {{ $value->namhoc }}
											@endif
										</span>
									</td>
									<td class="text-center"><a href="{{ route('admin.sapphong.qlcathi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa ca thi {{$value->tenca}}?')" href="{{ route('admin.sapphong.qlcathi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
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
    
<form action="{{ route('admin.sapphong.qlcathi.nhap') }}" method="post" enctype="multipart/form-data">
	@csrf
	
	<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModalLabel">Nhập từ Excel</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
                      <label for="MaLoai" class="form-label">Kỳ thi</label>
                      <select class="form-control" id="kythi_id" name="kythi_id">
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){
                          <option value="{{$value->id}}">{{$value->tenkythi}} năm học {{$value->namhoc}} </option>
                        }
                        @endforeach
 
                      </select>
                      @error('kythi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
					<div class="mb-0">
						<label for="file_excel" class="form-label">Chọn tập tin Excel</label>
						<input type="file" class="form-control" id="file_excel" name="file_excel" required />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"><i class="fal fa-upload"></i> Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form action="{{ route('admin.sapphong.qlcathi.xuat') }}" method="post" enctype="multipart/form-data">
	@csrf
	
	<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="importModalLabel">Xuất ra Excel</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="form-group">
                      <label for="MaLoai" class="form-label">Kỳ thi</label>
                      <select class="form-control" id="kythi_id" name="kythi_id" required>
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){
                          <option value="{{$value->id}}">{{$value->tenkythi}} năm học {{$value->namhoc}} </option>
                        }
                        @endforeach
 
                      </select>
                      @error('kythi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"><i class="fal fa-upload"></i> Xuất dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>
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
