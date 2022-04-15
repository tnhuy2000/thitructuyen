@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý ca thi | Thêm
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý ca thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
    <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlcathi.danhsach')}}">Quản lý ca thi</a></li>
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
              
              <form action="{{ route('admin.sapphong.qlcathi.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                      <label for="MaLoai" class="form-label">Kỳ thi</label>
                      <select class="form-select @error('kythi_id') is-invalid @enderror" id="kythi_id" name="kythi_id">
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){
                          <option value="{{$value->id}}" {{(old('kythi_id')==$value->id)?'selected':''}}>{{$value->tenkythi}} - học kỳ {{$value->hocky}} - năm học {{$value->namhoc}} </option>
                        }
                        @endforeach
 
                      </select>
                      @error('makhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="form-group col-md-12">
                    <label for="validationCustom01" class="form-label">Tên ca</label>
                      <input type="text" class="form-control @error('tenca') is-invalid @enderror" id="tenca" name="tenca" value="{{ old('tenca') }}" required>
                      
                      @error('tenca')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Ngày thi</label>
                      <input type="date" class="form-control @error('ngaythi') is-invalid @enderror" id="ngaythi" name="ngaythi" value="{{ old('ngaythi') }}" required>
                     
                      @error('ngaythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Giờ bắt đầu</label>
                      <input type="time"  class="form-control @error('giobatdau') is-invalid @enderror" id="giobatdau" name="giobatdau" value="{{ old('giobatdau') }}" required>
                      @error('giobatdau')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                   
                    
                    <div class="form-group col-md-12">
                      <label for="MaLoai" class="form-label">Mật khẩu ca thi</label>
                      <input type="password"  class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
                      @error('password')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                      <input class="mt-2" type="checkbox" id="checkbox" onclick="myFunction()"> Hiện mật khẩu
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
    function myFunction() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
    $(document).ready(function() {
            $("#kythi_id").select2();   
        });
 
</script>
@endsection
