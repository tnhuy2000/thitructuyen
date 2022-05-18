@extends('layouts.admin-layout')
@section('pagetitle')
Thống kê điểm danh sinh viên
@endsection

@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Thống kê điểm danh Sinh viên</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="#">Thống kê điểm danh Sinh viên</a></li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
      
	<div class="col-lg-12">

	  <div class="card">
		<div class="card-body">

        <div class="row">

                 
				  	<div class="col-md-1 pl-1"></div>

                  	<div class="col-md-3 col-sm-3 pl-1 mt-3">
                        <div class="form-group" id="filter_col0" data-column="0">
                            <label class="form-label" >Theo ca thi</label>
                            <select name="hocphan" class="form-select column_filter " id="col0_filter">
								<option value="">--Tất cả--</option>
								@foreach($cathi as $cathi)
                                    <option value="{{$cathi->tenca}}">{{$cathi->tenca}}</option>
								@endforeach   
                            </select>
                        </div>

                    </div>
                    <div class="col-md-3 pl-1 mt-3">
                        <div class="form-group" id="filter_col1" data-column="1">
                            <label class="form-label">Ngày thi</label>
                            <input type="text" name="ngaythi" class="form-control column_filter date-range-filter datepicker" id="col1_filter" placeholder="dd/mm/YY">
                        </div>
                    </div>
                    <div class="col-md-3 pl-1 mt-3">
                    <div class="form-group" id="filter_col2" data-column="2">
                            <label class="form-label" >Theo phòng thi</label>
                            <select name="hocphan" class="form-select column_filter " id="col2_filter">
								<option value="">--Tất cả--</option>
								@foreach($phongthi as $value)
                                    <option value="{{$value->maphong}}">{{$value->maphong}}</option>
								@endforeach   
                            </select>
                        </div>
                    </div>
                 
                
            	</div>
		  	<h5 class="card-title">Thống kê</h5>
			
		  <!-- Table with stripped rows -->
		  <table class="table table-hover" id="ex">
		  	<thead>
				<tr>
				
					<th width="15%">Ca thi</th>
                    <th width="15%">Ngày thi</th>
					<th>Phòng thi</th>
					<th width="10%" >Sĩ số</th>
                    <th width="10%" >Có mặt</th>
                    <th width="10%" >Vắng</th>
					
					
				</tr>
			</thead>
			<tbody>
                @php $count=1; @endphp
                    @foreach($phongthi as $phongthi)
					<tr>
						
						<td>{{$phongthi->tenca}}</td>
						<td>{{ \Carbon\Carbon::parse($phongthi->ngaythi)->format('d/m/Y')}}</td>
                        <td>{{$phongthi->maphong}}</td>
                          
                            <td class="small">
                                {{$phongthi->soluongthisinh}}
                            </td>
                         @foreach($sinhvien_phongthi_comat as $svpt_comat)
                            @if($svpt_comat->phongthi_id==$phongthi->id)
                                @if($svpt_comat->slsvvang!=null)
                                    <td> {{$svpt_comat->slsvvang}}</td>
                                    <td>{{$phongthi->soluongthisinh-$svpt_comat->slsvvang}}</td>
                                @else
                                    <td>0</td>
                                    <td>{{$phongthi->soluongthisinh-0}}</td>
                                @endif
                            
                            @endif

                        @endforeach
                        
                      
						
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

</main>


<!-- End #main -->


@endsection
@section('javascript')    
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
  	
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
 //start   
            $(document).ready(function() {
                $('#ex').DataTable();
                $("#col0_filter").select2({         
                    theme: "bootstrap-5",
                });
                $("#col2_filter").select2({         
                    theme: "bootstrap-5",
                });
                $('input.global_filter').on( 'keyup click', function () {
                    filterGlobal();
                } );
            
                $('input.column_filter').on( 'keyup click', function () {
                    filterColumn( $(this).parents('div').attr('data-column') );
                } );
                
            } );
//end 
            $('select.column_filter').on('change', function () {
                filterColumn( $(this).parents('div').attr('data-column') );
            } );
		
  </script>
  
@endsection
