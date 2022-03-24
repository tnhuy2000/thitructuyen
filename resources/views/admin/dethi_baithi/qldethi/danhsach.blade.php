@extends('layouts.admin-layout')
@section('title','Quản lý đề thi')

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
            <form id="clear">
                <div class="row">

                  <!--Name-->
                  	<div class="col-md-2 pl-1">
                        <div class="form-group" id="filter_col0" data-column="0">
                            <label>Name</label>
                            <input type="text" name="Name" class="form-control column_filter" id="col0_filter" placeholder="Name">
                        </div>
                    </div>
                  
                  <!--Job-->
                  <div class="col-md-2 pl-1">
                        <div class="form-group" id="filter_col1" data-column="1">
                            <label>Job</label>
                            <select name="JobID" class="form-control column_filter" id="col1_filter">
                                    <option>All</option>
                                    <option>Điện toán đám mây
MHP: Cos509
STC: 3</option>
                                    <option>Tự luận</option>
                                  
                            </select>
                            </div>
                      </div>
                  
                  <!--Age-->
                  <div class="col-md-2 pl-1">
                        <div class="form-group" id="filter_col2" data-column="2">
                            <label>Age</label>
                            <input type="text" name="Age" class="form-control column_filter" id="col2_filter" placeholder="Age">
                        </div>
                    </div>
                  
                  <!--From-->
                    <div class="col-md-2 pl-1">
                        <div class="form-group" id="filter_col3" data-column="3">
                            <label>From</label>
                            <input type="text" name="From" class="form-control column_filter date-range-filter datepicker" id="col3_filter" placeholder="mm/dd/YY">
                        </div>
                    </div>
                  
                  <!--TO-->
                  <div class="col-md-2 pl-1">
                        <div class="form-group" id="filter_col3" data-column="3">
                            <label>To</label>
                            <input type="text" name="To" class="form-control column_filter" id="col3_filter" placeholder="mm/dd/YY">
                        </div>
                    </div>
                </div>
              
                </form>
                <div class="text-center">
                <a class="btn btn-success btn-lg " href="#"><i class="fa fa-filter "></i> Filter</a>
                    <Button type="button" onclick="ClearFields();" class="btn btn-secondary btn-lg "> Clear Filter</Button>
                </div>
            </div>
        </div>
        <hr>

	  <div class="card">
		<div class="card-body">
		  
		  	<a href="{{ route('admin.dethi_baithi.qldethi.them') }}" class="btn btn-primary mt-3"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  
		  <!-- Bordered Tabs Justified -->
		  <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 active fw-bold" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-moi" type="button" role="tab" aria-controls="home" aria-selected="true">Hiện tại</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                  <button class="nav-link w-100 fw-bold" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-cu" type="button" role="tab" aria-controls="profile" aria-selected="false">Cũ hơn</button>
                </li>
              
              </ul>
			 
              <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                <div class="tab-pane fade show active" id="bordered-justified-moi" role="tabpanel" aria-labelledby="home-tab">
					<!-- Table with stripped rows -->
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
					<!-- End Table with stripped rows -->
                </div>
				<div class="tab-pane fade" id="bordered-justified-cu" role="tabpanel" aria-labelledby="contact-tab">
					<!-- Table with stripped rows -->
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
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
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


		function filterGlobal () {
    $('#ex').DataTable().search(
        $('#global_filter').val(),
    
    ).draw();
    }
    
    function filterColumn ( i ) {
        $('#ex').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }
    
    $(document).ready(function() {
        $('#ex').DataTable();
        
        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        } );
    
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
    } );

	$('select.column_filter').on('change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
  </script>
@endsection
