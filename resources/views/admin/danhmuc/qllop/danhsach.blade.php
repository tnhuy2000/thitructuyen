@extends('layouts.admin-layout')
@section('title','Quản lý lớp')

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý lớp</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item">Quản lý lớp</li>
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
						<div class="form-group" id="filter_col3" data-column="3">
							<label class="form-label" >Tìm kiếm theo Khoa</label>
							<select name="khoa" class="form-select column_filter " id="col3_filter">
							
								@foreach($khoa as $khoa1)
									<option value="{{$khoa1->tenkhoa}}">{{$khoa1->tenkhoa}}</option>
								@endforeach   
							</select>
						</div>

					</div>
					
                 
             
                
            	</div>
		  	<h5 class="card-title">Danh sách lớp</h5>
		  	<a href="{{ route('admin.danhmuc.qllop.them') }}" class="btn btn-outline-primary"><i class="bx bxs-plus-square"></i> Thêm mới</a>
		  	<a href="#nhap" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#importModal"><i class="bx bxs-archive-in"></i> Nhập từ Excel</a>
			<a href="{{ route('admin.danhmuc.qllop.xuat') }}" class="btn btn-outline-success"><i class="bx bxs-archive-out"></i> Xuất ra Excel</a>
            
		  <!-- Table with stripped rows -->
		  <table class="table table-hover" id="ex">
		  	<thead>
				<tr>
					<th width="2%">#</th>
					<th width="3%">Mã lớp</th>
					<th width="15%">Tên lớp</th>
					<th width="15%">Tên khoa</th>
					<th width="10%">Niên khoá</th>
					<th width="8%" class="text-center">Sửa</th>
					<th width="8%" class="text-center">Xóa</th>
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($lop as $value)
					<tr>
						<td>{{ $count++ }}</td>
						<td>{{ $value->malop }}</td>
						<td class="small">{{ $value->tenlop }}</td>
						<td class="small">{{ $value->tenkhoa }}</td>
						<td>{{ $value->nienkhoa }}</td>
						<td class="text-center"><a href="{{ route('admin.danhmuc.qllop.sua', ['malop' => $value->malop]) }}"><i class="bx bxs-pencil"></i> Sửa</a></td>
						<td class="text-center"><a onclick="return confirm('Bạn có muốn xóa lớp {{$value->tenlop}}?')" href="{{ route('admin.danhmuc.qllop.xoa', ['malop' => $value->malop]) }}" ><i class="bx bxs-trash text-danger"></i> Xoá</a></td>
		
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
    
<form action="{{ route('admin.danhmuc.qllop.nhap') }}" method="post" enctype="multipart/form-data">
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
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fal fa-times"></i> Hủy bỏ</button>
					<button type="submit" class="btn btn-danger"><i class="fal fa-upload"></i> Nhập dữ liệu</button>
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

		$(document).ready(function() {
           $("#col3_filter").select2();  
			
        });

  </script>
@endsection
