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
    <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlcathi.danhsach')}}">Quản lý ca thi</a></li>
	  <li class="breadcrumb-item active">Sửa ca thi</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa ca thi</h5>
              
              <form action="{{ route('admin.sapphong.qlcathi.sua', ['id' => $ktcathi->id]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                      <label for="MaLoai" class="form-label">Kỳ thi</label>
                      <select class="form-control" id="kythi_id" name="kythi_id" required>
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){
                          @if($ktcathi->kythi_id == $value->id)
                           
                            <option value="{{$value->id}}" selected="selected">{{$value->tenkythi}} - học kỳ {{$value->hocky}} - năm học {{$value->namhoc}}</option>
                          @else
                          {
                            <option value="{{$value->id}}">{{$value->tenkythi}} - học kỳ {{$value->hocky}} - năm học {{$value->namhoc}}) </option>
                          }
                          @endif
                          
                        }
                        @endforeach
 
                      </select>
                      @error('makhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Tên ca</label>
                      <input type="text" class="form-control @error('tenca') is-invalid @enderror" id="tenca" name="tenca" value="{{ $ktcathi->tenca }}" required>
                      
                      @error('tenca')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Ngày thi</label>
                      <input type="date" class="form-control @error('ngaythi') is-invalid @enderror" id="ngaythi" name="ngaythi" value="{{ $ktcathi->ngaythi }}" required>
                     
                      @error('ngaythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Giờ bắt đầu</label>
                      <input type="time"  class="form-control @error('giobatdau') is-invalid @enderror" id="giobatdau" name="giobatdau" value="{{ $ktcathi->giobatdau }}" required>
                      @error('giobatdau')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="MaLoai" class="form-label">Mật khẩu ca thi</label>
                      <input type="password" placeholder="Bỏ trống sẽ giữ nguyên mật khẩu cũ"  class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                      @error('password')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label for="MaLoai" class="form-label">Xác nhận mật khẩu ca thi</label>
                      <input type="password" placeholder="Bỏ trống sẽ giữ nguyên mật khẩu cũ" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
                      @error('password_confirmation')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                      
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i> Cập nhật</button>
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