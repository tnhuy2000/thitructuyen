@extends('layouts.hoidongthi-layout')
@section('pagetitle')
	Phòng thi
@endsection

@section('css')

@endsection('css')
@section('content')



  <!-- Pricing Start -->
  <div class="container-xxl">
        <div class="container py-3">
            <h5>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('canbocoithi.dashboard')}}"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a class="text-primary" href="{{route('canbocoithi.phongthi',['phongthi_id'=>$ktphongthi->id])}}">Phòng thi của tôi</a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">{{$ktphongthi->maphong}}</li>
                    <li class="breadcrumb-item text-danger active" aria-current="page">3. Giám thị điểm danh thí sinh</li>
                </ol>
            </nav>
            </h5>
            <div class="wow mt-5 mb-3" data-wow-delay="0.1s">
                
                <h1 class="">Điểm danh - Phòng: {{$ktphongthi->maphong}}</h1>
            </div>
            
            <!-- Table with stripped rows -->
		  <table id="DataList" class="table table-hover table-sm ">
		  	<thead>
				<tr>
					<th width="5%">#</th>
				
					<th width="12%">Mã sinh viên</th>
					<th>Họ tên</th>
                    <th width="25%">Liên hệ</th>
                    <th width="12%">Mã lớp</th>
					<th width="10%" class="text-center">Điểm danh</th>
					<th class="text-center" width="20%">Ghi chú</th>
					
				
				</tr>
			</thead>
			<tbody>
				@php $count = 1; @endphp
				@foreach($sinhvien_phongthi as $value)
					<tr>
						<td>{{ $count++ }}</td>
						
						<td>
							{{ $value->masinhvien }}
						</td>
						<td class="small">
							<span style="color:#0000ff;font-weight:bold;">{{ $value->holot }} {{ $value->ten }}</span>
						
						</td>
                        <td class="small">
                            <span style="font-size:0.9em;">
								@if(!empty($value->email))
									Email: {{ $value->email }}
								@endif
								@if(!empty($value->dienthoai))
									<br />Điện thoại: {{ $value->dienthoai }}
								@endif
							</span>
                        
						</td>
                        
                        <td>{{ $value->malop }}</td>
						<td class="text-center">
							@if($value->diemdanh==1)
								<h2><a href="{{ route('canbocoithi.diemdanh', ['id' => $value->id,'phongthi_id'=>$value->phongthi_id]) }}"><i class="fas fa-check-circle text-success"></i></a></h2>
							@else
								<h2><a href="{{ route('canbocoithi.diemdanh', ['id' => $value->id,'phongthi_id'=>$value->phongthi_id]) }}"><i class="fas fa-times text-danger"></i></a></h2>
							@endif
							
						<td class="small text-center">{{ $value->ghichu }}
							<br><a href="#suaghichu" data-bs-toggle="modal" data-bs-target="#ModalSuaGhiChu" onclick="getDiemDanhSuaGhiChu({{ $value->id }},'{{ $value->masinhvien }}','{{ $value->phongthi_id }}', '{{ $value->ghichu }}'); return false;">[Sửa ghi chú]</a>
						</td>
						
					</tr>
				@endforeach
			</tbody>
		  </table>
		  <!-- End Table with stripped rows -->

   
        </div>
    </div>

    <!-- Pricing End -->


	<form action="{{route('canbocoithi.suaghichu')}}" method="post">
		@csrf
		<input type="hidden" id="id_edit" name="id_edit" value="" />
		<input type="hidden" id="phongthi_id_edit" name="phongthi_id_edit" value="" />
		<input type="hidden" id="masinhvien_edit" name="masinhvien_edit" value="" />
		<div class="modal fade" id="ModalSuaGhiChu" role="dialog" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Cập nhật ghi chú</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" style="max-height: 800px">
						<div class="mb-0">
							<label for="ghichu" class="form-label">Ghi chú</label>
							<textarea class="form-control" id="ghichu_edit" name="ghichu_edit" style="height: 80px"></textarea>
						</div>
						@error('ghichu_edit')
						<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
						<button type="submit" class="btn btn-primary"> Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	
  @endsection
  @section('javascript')    
<script type="text/javascript">
  		
    function getDiemDanhSuaGhiChu(id,masinhvien,phongthi_id,ghichu) {
        $('#id_edit').val(id);
        $('#masinhvien_edit').val(masinhvien);
        $('#phongthi_id_edit').val(phongthi_id);
        $('#ghichu_edit').val(ghichu);
    }
	
  </script>
@endsection