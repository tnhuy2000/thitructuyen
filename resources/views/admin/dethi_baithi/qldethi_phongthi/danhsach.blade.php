@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý đề thi - phòng thi
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý đề thi - phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlphongthi.danhsach')}}">Quản lý phòng thi</a></li>
	  <li class="breadcrumb-item">Quản lý đề thi - phòng thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">
		  	<h5 class="card-title">Danh sách đề thi phòng {{$ktphongthi->maphong}}</h5>
			<a href="#them" data-bs-toggle="modal" data-bs-target="#myModalThemDeThi" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Thêm mới</a>
			
		
		  <!-- Table with stripped rows -->
		  <table class="table datatable table-hover">
		  	<thead>
				<tr>
					<th width="2%">#</th>
				
					<th width="15%">Phòng thi</th>
					<th>Đề thi</th>
					<th width="15%">Kỳ thi</th>
					<th width="15%">Học phần</th>
					<th width="10%">Ghi chú</th>
				
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($dethi_phongthi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						
						<td>
							{{ $value->maphong }}
						</td>
						<td class="small">
						{{ $value->tendethi }}
						</td>
						<td class="small">
						<span style="color:#0000ff;font-weight:bold;">{{ $value->tenkythi }}</span>
							<span style="font-size:0.9em;">
								
								@if(!empty($value->hocky))
									<br />HK: {{ $value->hocky }}
								@endif
								@if(!empty($value->namhoc))
									<br />NH: {{ $value->namhoc }}
								@endif
							</span>
						</td>
						<td class="small"><span style="color:#0000ff;font-weight:bold;">{{ $value->tenhocphan }}</span>
							<span style="font-size:0.9em;">
								@if(!empty($value->mahocphan))
									<br />MHP: {{ $value->mahocphan }}
								@endif
								@if(!empty($value->sotinchi))
									<br />STC: {{ $value->sotinchi }}
								@endif
								
							</span>
						</td>
						<td class="small">{{ $value->ghichu }}</td>
			
						<td><a href="#suaghichu" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalSua" onclick="getSua({{ $value->id }},'{{ $value->dethi_id }}','{{ $value->phongthi_id }}', '{{ $value->ghichu }}'); return false;"><i class="fa-regular fa-pen-to-square"></i></a></td>
						<td class="text-center"><a href="#xoa" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}},{{$value->phongthi_id}}); return false;"  ><i class="fa-regular fa-trash-can"></i></a></td>
		
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
    <!--Thêm mới-->
<form action="{{route('admin.dethi_baithi.qldethi_phongthi.them',['phongthi_id'=> $ktphongthi->id])}}" method="post">
		@csrf
		
		<div class="modal fade" id="myModalThemDeThi" role="dialog" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Thêm đề thi - phòng thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
                    	<div class="form-group">
                            <label for="HinhAnh"> Đề thi<span class="text-danger font-weight-bold">*</span></label>
                                
							<select  class="form-select @error('dethi_id') is-invalid @enderror" style="width: 100%" name="dethi_id" id="Statesdethi_id">
								@foreach($ktdethi as $value)
									<option value="{{$value->id}}" {{(old('dethi_id')==$value->id)?'selected':''}}>{{$value->tendethi}} </option>
								@endforeach
							</select>
							@error('dethi_id')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@enderror
						</div>
						<div class="form-group">
							<label for="ghichu" class="form-label">Ghi chú</label>
							<textarea class="form-control" id="ghichu" name="ghichu" style="height: 80px"></textarea>
							
							@error('ghichu')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@enderror
							
						</div>
                        
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!--Sửa ghi chú-->
	<form action="{{route('admin.dethi_baithi.qldethi_phongthi.sua')}}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="phongthi_id_edit" name="phongthi_id_edit" value="" />
		<div class="modal fade" id="ModalSua" role="dialog" >
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật đề thi - phòng thi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
						<div class="form-group">
							<label for="ghichu" class="form-label">Đề thi</label>
							<select class="form-select @error('dethi_id_edit') is-invalid @enderror" style="width: 100%" id="dethi_id_edit" name="dethi_id_edit" required>
								@foreach($ktdethi as $value)
									
									<option value="{{$value->id}}">{{$value->tendethi}}</option>
								@endforeach
							</select>
							@error('dethi_id_edit')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@enderror
						</div>

						<div class="form-group mt-2">
							<label for="ghichu" class="form-label">Ghi chú</label>
							<textarea class="form-control" id="ghichu_edit" name="ghichu_edit" style="height: 80px"></textarea>
							
							@error('ghichu_edit')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
							@enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
</form>
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
						<p class="font-weight-bold text-danger"><i class="fa-regular fa-circle-question text-danger"></i> Xác nhận xóa? Hành động này không thể phục hồi.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger"> Thực hiện</button>
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
			$('#dethi_id_edit').val(dethi_id).change();
			$('#phongthi_id_edit').val(phongthi_id);
			$('#ghichu_edit').val(ghichu);
		}
		
	

		$('#Statesdethi_id').select2({
			dropdownParent: $('#myModalThemDeThi'),
			placeholder: "Chọn đề thi",
    		allowClear: true
		});
	
		
		$('#dethi_id_edit').select2({
			dropdownParent: $('#ModalSua')	
		});
		
  </script>
@endsection
