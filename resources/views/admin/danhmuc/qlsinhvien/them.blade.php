@extends('layouts.admin-layout')
@section('title','Quản lý sinh viên')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý sinh viên</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qlsinhvien.danhsach')}}">Quản lý sinh viên</a></li>
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
              
              <form action="{{ route('admin.danhmuc.qlsinhvien.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Mã sinh viên</label>
                      <input type="text" placeholder="Vd: DTH185437" class="form-control @error('masinhvien') is-invalid @enderror" id="masinhvien" name="masinhvien" value="{{ old('masinhvien') }}" required>
                      
                      @error('masinhvien')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-3">
                      <label for="validationCustom02" class="form-label">Họ lót</label>
                      <input type="text"  class="form-control @error('holot') is-invalid @enderror" id="holot" name="holot" value="{{ old('holot') }}" required>
                     
                      @error('holot')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-5">
                      <label for="validationCustom02" class="form-label">Tên điệm và tên</label>
                      <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten') }}" required>
                      @error('ten')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                      <div class="form-group col-sm-6">
                        <label for="validationCustom02" class="form-label">Địa chỉ email</label>
                        <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                      </div>
                      <div class="form-group col-sm-6">
                      <label for="validationCustom02" class="form-label">Điện thoại</label>
                        <input type="number" placeholder="Điện thoại" class="form-control @error('dienthoai') is-invalid @enderror" id="dienthoai" name="dienthoai" value="{{ old('dienthoai') }}" required>
                        @error('dienthoai')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                      </div>
                   
                    <div class="form-group">
                      <label for="MaLoai" class="form-label">Lớp</label>
                      <select class="form-control @error('dienthoai') is-invalid @enderror" id="states" name="malop" required>
                        <option value="">-- Chọn Lớp --</option>
                        @foreach($ktkhoa as $value1){
                        <optgroup label="{{$value1->tenkhoa}}">
                          @foreach($ktlop as $value2){
                            @if($value2->makhoa==$value1->makhoa)
                            <option value="{{$value2->malop}}">{{$value2->malop}}</option>
                            @endif
                            }
                          @endforeach
                        </optgroup>
                        }
                        @endforeach
                      </select>
                      
                      @error('malop')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                   
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary"><i class="fal fa-save"></i> Thêm vào CSDL</button>
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