@extends('layouts.admin-layout')
@section('pagetitle')
	Quản lý khoa
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý khoa</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý khoa</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-8">
	
	  <div class="card">
		<div class="card-body">
		  <h5 class="card-title">Danh sách khoa</h5>
		 
              	<a href="#nhap" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#importModalKhoa"><i class="fa-solid fa-upload"></i> Nhập từ Excel</a>
				<a href="{{ route('admin.danhmuc.qlkhoa.xuat') }}" class="btn btn-success"><i class="fa-solid fa-download"></i> Xuất ra Excel</a>
            <br><br>
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover table-sm"">
		  	<thead>
				<tr>
					<th width="5%">#</th>
					<th width="20%">Mã khoa</th>
					<th >Tên khoa</th>
					<th width="10%">Sửa</th>
                    <th width="10%">Xoá</th>
				</tr>
			</thead>
			<tbody>
            @php $count = 1; @endphp
				@foreach($khoa as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->makhoa }}</td>
						<td class="small">{{ $value->tenkhoa }}</td>
						
						<td class="text-center"><a href="#sua" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModalSua" onclick="getSua('{{ $value->makhoa}}','{{$value->tenkhoa}}'); return false;"  ><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a href="#xoa" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa('{{ $value->makhoa}}'); return false;"  ><i class="fa-regular fa-trash-can"></i></a></td>
		
					</tr>
				@endforeach
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->

		</div>
	  </div>

	</div>
	<div class="col-md-4">
                    <div class="card">
                        <div class="card-header fw-bold">Thêm mới Khoa/Phòng ban</div>
						
                        <div class="card-body">
                            <form action="{{ route('admin.danhmuc.qlkhoa.them') }}" method="post" id="add-khoa-form" autocomplete="off">
                                @csrf
                                <div class="form-group mt-2">
                                    <label for="">Mã khoa/phòng ban</label>
                                    <input type="text" class="form-control @error('makhoa') is-invalid @enderror" id="makhoa" name="makhoa" placeholder="Mã khoa" value="{{ old('makhoa') }}">
                                    @error('makhoa')
									<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
								 	@enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="">Tên khoa/ phòng ban</label>
									<textarea class="form-control @error('tenkhoa') is-invalid @enderror" style="height: 80px" name="tenkhoa" id="tenkhoa" placeholder="Tên khoa">{{ old('tenkhoa') }}</textarea>
                                    <!-- <input type="text" height="30px" class="form-control @error('tenkhoa') is-invalid @enderror" name="tenkhoa" id="tenkhoa" placeholder="Tên khoa" value="{{ old('tenkhoa') }}"> -->
									@error('tenkhoa')
									<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
									@enderror
                                </div>
								<br>
                                <div class="form-group">
								
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
              </div>
  </div>
</section>

</main><!-- End #main -->
<form action="{{ route('admin.danhmuc.qlkhoa.xoa') }}" method="post">
		@csrf
		<input type="hidden" id="makhoa_delete" name="makhoa_delete" value="" />
		
		<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Xoá khoa</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question"></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
<form action="{{ route('admin.danhmuc.qlkhoa.nhap') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="modal fade" id="importModalKhoa" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
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
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-danger">Nhập dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form action="{{ route('admin.danhmuc.qlkhoa.sua') }}" method="post">
 @csrf
<div class="modal fade" id="myModalSua" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cập nhật khoa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form>
                     <div class="form-group">
                        <label for="validationCustom01" class="form-label">Mã khoa</label>
                      <input type="text" class="form-control" id="makhoa_edit" name="makhoa_edit" value="" readonly  required>
                      @error('makhoa_edit')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="form-group mt-2">
                      <label for="validationCustom02" class="form-label">Tên khoa</label>
                      <input type="text" class="form-control @error('tenkhoa_edit') is-invalid @enderror"  id="tenkhoa_edit" name="tenkhoa_edit" required>
                      @error('tenkhoa_edit')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                </form>
            </div>
            <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
					<button type="submit" class="btn btn-success"><i class="fa-regular fa-floppy-disk"></i> Cập nhật</button>
			</div>
        </div>
    </div>
</div>
</form>
@endsection
@section('javascript') 
<script src="{{ asset('public/jquery/jquery-3.6.0.min.js') }}"></script>
   
	<script type="text/javascript">
  
        function getXoa(makhoa) {
			$('#makhoa_delete').val(makhoa);
		}
		function getSua(makhoa,tenkhoa) {
			$('#makhoa_edit').val(makhoa);
			$('#tenkhoa_edit').val(tenkhoa);
		}     
  </script>
@endsection
