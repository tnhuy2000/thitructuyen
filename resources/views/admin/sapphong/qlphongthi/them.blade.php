@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý phòng thi | Thêm
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
    <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlphongthi.danhsach')}}">Quản lý phòng thi</a></li>
	  <li class="breadcrumb-item active">Thêm mới</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Thêm mới</h5>
              
              <form action="{{ route('admin.sapphong.qlphongthi.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                      <label for="MaLoai" class="form-label">Ca thi</label>
                      <select class="form-select @error('cathi_id') is-invalid @enderror" id="statesCaThi" height="40px" name="cathi_id">
                        <option value="">-- Chọn ca thi --</option>
                        @foreach($ktcathi as $value){

                            <option value="{{$value->id}}" {{(old('cathi_id')==$value->id)?'selected':''}} >{{$value->tenca}} - ngày: {{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}} - giờ bắt đầu: {{$value->giobatdau}}</option>
                        
                        }
                        @endforeach
                      </select>
                      @error('cathi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Mã phòng</label>
                      <input type="text" class="form-control @error('maphong') is-invalid @enderror" id="maphong" name="maphong" value="{{ old('maphong') }}" required>
                      
                      @error('maphong')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-3">
                      <label for="validationCustom02" class="form-label">Số lượng thí sinh</label>
                      <input type="number" class="form-control @error('soluongthisinh') is-invalid @enderror" id="soluongthisinh" name="soluongthisinh" value="{{ old('soluongthisinh') }}" required>
                     
                      @error('soluongthisinh')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-5">
                      <label for="validationCustom02" class="form-label">Meeting</label>
                      <select class="form-select @error('meeting') is-invalid @enderror" name="meeting" required>
                          <option value="googlemeet">-- Chọn loại phòng họp --</option>
                          <option value="googlemeet">Google Meet</option>
                          <option value="zoom" selected="selected">Zoom</option>
                      </select>
                    </div>
                    
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Ghi chú</label>
                      <textarea class="form-control @error('ghichu') is-invalid @enderror" id="ghichu" name="ghichu">{{ old('ghichu') }}</textarea>
                      @error('ghichu')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                    
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Thực hiện</button>
                    </div>
                </form>
              <!-- End Custom Styled Validation -->

            </div>
	    </div>

	  </div>
  </div>
</section>

</main><!-- End #main -->
@endsection
@section('javascript')    
<script type="text/javascript">
$(document).ready(function() {
            $("#statesCaThi").select2();   
        });

</script>

@endsection