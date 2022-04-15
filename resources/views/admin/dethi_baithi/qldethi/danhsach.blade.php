@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý đề thi
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý đề thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý đề thi</li>
	  <li class="breadcrumb-item active">Danh sách</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">
	<div class="card">
            <div class="card-body">
            
                <div class="row">

                 
				  	<div class="col-md-3 pl-1"></div>

                  	<div class="col-md-5 col-sm-3 pl-1 mt-3">
                        <div class="form-group" id="filter_col1" data-column="1">
                            <label class="form-label" >Tìm kiếm theo học phần</label>
                            <select name="hocphan" class="form-select column_filter " id="col1_filter">
								<option value="">--Tất cả--</option>
								@foreach($hocphan as $hocphan)
                                    <option value="{{$hocphan->mahocphan}}">{{$hocphan->tenhocphan}} - {{$hocphan->mahocphan}}</option>
								@endforeach   
                            </select>
                        </div>

                    </div>
                 
                
            	</div>
       
			<a href="{{ route('admin.dethi_baithi.qldethi.them') }}" class="btn btn-primary mt-2 mb-2"><i class="fa-solid fa-plus"></i> Thêm mới</a>
		  <!-- Table with stripped rows -->
		  <table class="table table-hover" id="ex">
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="18%">Học phần</th>
								<th width="15%">Kỳ thi</th>
								<th width="20%">Tên đề thi</th>
								<th width="13%">TG làm bài</th>
								<th width="13%">Hình thức</th>
								<th width="13%">Dữ liệu đề thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($dethi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenhocphan }}</span>
									
										<span style="font-size:0.9em;">
											
											@if(!empty($value->mahocphan))
												<br />MHP: {{ $value->mahocphan }}
											@endif
											@if(!empty($value->sotinchi))
												<br />STC: {{ $value->sotinchi }}
											@endif
										</span>
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
									<td class="small"><span style="font-size:0.9em;">{{ $value->tendethi }}</span></td>
									<td class="small"><span class="badge bg-secondary">{{ $value->thoigianlambai }} phút</span></td>
									<td class="small">@if($value->hinhthuc=='thuchanh')
										<span class="badge bg-info">Thực hành</span>
										@else
										<span class="badge  bg-success">Tự luận</span>
										@endif
										</td>
									<td><a class="btn btn-primary btn-sm" href="{{ route('admin.dethi_baithi.qldulieudethi.danhsach', ['id' => $value->id]) }}"><i class="fa-solid fa-plus"></i> Thêm</a></td>
									<td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('admin.dethi_baithi.qldethi.sua', ['id' => $value->id]) }}"><i class="fa-regular fa-pen-to-square"></i></a></td>
									<td class="text-center"><a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#myModalDelete" onclick="getXoa({{ $value->id}}); return false;"   href="#xoa" ><i class="fa-regular fa-trash-can"></i></a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					<!-- End Table with stripped rows -->
		  <!-- Bordered Tabs Justified -->
		  <!-- <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-moi" type="button" role="tab" aria-controls="home" aria-selected="true">Hiện tại</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-cu" type="button" role="tab" aria-controls="profile" aria-selected="false">Cũ hơn</button>
                </li>
              
              </ul> -->
			 
              <!-- <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                <div class="tab-pane fade show active" id="bordered-justified-moi" role="tabpanel" aria-labelledby="home-tab">
					
					<table class="table datatable table-hover">
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="18%">Học phần</th>
								<th width="15%">Kỳ thi</th>
								<th width="20%">Tên đề thi</th>
								<th width="9%">TG làm bài</th>
								<th width="13%">Hình thức</th>
								<th width="15%">Dữ liệu đề thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($dethimoi as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenhocphan }}</span>
										<span style="font-size:0.9em;">
											
											@if(!empty($value->mahocphan))
												<br />MHP: {{ $value->mahocphan }}
											@endif
											@if(!empty($value->sotinchi))
												<br />STC: {{ $value->sotinchi }}
											@endif
										</span>
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
									<td class="small"><span style="font-size:0.9em;">{{ $value->tendethi }}</span></td>
									<td class="small"><span class="badge rounded-pill bg-secondary">{{ $value->thoigianlambai }} phút</span></td>
									<td class="small">@if($value->hinhthuc=='thuchanh')
											<span>Thực hành</span>
										@else
											<span>Tự luận</span>
										@endif
										</td>
									<td><a href="{{ route('admin.dethi_baithi.qldulieudethi.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
									<td class="text-center"><a href="{{ route('admin.dethi_baithi.qldethi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa đề thi của học phần {{$value->tenhocphan}}?')" href="{{ route('admin.dethi_baithi.qldethi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					</table>
					
                </div>
				<div class="tab-pane fade" id="bordered-justified-cu" role="tabpanel" aria-labelledby="contact-tab">
					
					<table class="table  table-hover" id="ex">
						<thead>
							<tr>
								<th width="2%">#</th>
								<th width="18%">Học phần</th>
								<th width="15%">Kỳ thi</th>
								<th width="20%">Tên đề thi</th>
								<th width="9%">TG làm bài</th>
								<th width="13%">Hình thức</th>
								<th width="15%">Dữ liệu đề thi</th>
								<th width="8%" class="text-center">Sửa</th>
								<th width="8%" class="text-center">Xóa</th>
							</tr>
						</thead>
						<tbody>
							@php $count = 1; @endphp
							@foreach($dethicu as $value)
								<tr>
									<td>{{ $count++ }}</td>
									<td class="small">
										<span style="color:#0000ff;font-weight:bold;">{{ $value->tenhocphan }}</span>
										<span style="font-size:0.9em;">
											
											@if(!empty($value->mahocphan))
												<br />MHP: {{ $value->mahocphan }}
											@endif
											@if(!empty($value->sotinchi))
												<br />STC: {{ $value->sotinchi }}
											@endif
										</span>
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
									<td class="small"><span style="font-size:0.9em;">{{ $value->tendethi }}</span></td>
									<td class="small"><span class="badge rounded-pill bg-secondary">{{ $value->thoigianlambai }} phút</span></td>
									<td class="small">@if($value->hinhthuc=='thuchanh')
											<span>Thực hành</span>
										@else
											<span>Tự luận</span>
										@endif
										</td>
									<td><a href="{{ route('admin.dethi_baithi.qldulieudethi.danhsach', ['id' => $value->id]) }}"><span class="badge bg-primary"><i class="bx bx-plus-circle"></i> Thêm</span></a></td>
									<td class="text-center"><a href="{{ route('admin.dethi_baithi.qldethi.sua', ['id' => $value->id]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
									<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa đề thi của học phần {{$value->tenhocphan}}?')" href="{{ route('admin.dethi_baithi.qldethi.xoa', ['id' => $value->id]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
					
								</tr>
							@endforeach
						</tbody>
					
					</table>
					
                </div>
                
               
              </div>End Bordered Tabs Justified -->
		</div>
	  </div>

	</div>
  </div>
</section>

</main><!-- End #main -->
    
{{-- Xoá --}}
<form action="{{ route('admin.dethi_baithi.qldethi.xoa') }}" method="post">
	@csrf
	<input type="hidden" id="id_delete" name="id" value="" />
	
	<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title">Xoá đề thi</h5>
				  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body" >
					<p class="text-danger"><i class="fa-regular fa-circle-question "></i> Xác nhận xoá đề thi? Hành động này không thể phục hồi.</p>
					<p class="text-muted">(Ghi chú: Dữ liệu đề thi đính kèm sẽ mất nếu đề thi bị xoá.)</p>
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

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
<script type="text/javascript">
  		function getXoa(id) {
			$('#id_delete').val(id);
		}
		
		@if($errors->has('id') || $errors->has('tenkhoa')  )
			$('#myModal').modal('show');
		@endif
		
		@if($errors->has('id_edit') || $errors->has('tenkhoa_edit'))
			$('#myModalEdit').modal('show');
		@endif


	// function filterGlobal () {
	// 	$('#ex').DataTable().search(
	// 		$('#global_filter').val(),
		
	// 	).draw();
	// }
    
    function filterColumn ( i ) {
        $('#ex').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }
    
   

		$('select.column_filter').on('change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );

		$(document).ready(function() {
           $("#col1_filter").select2();  
			
        });

		

	
	
		
  </script>
@endsection
