@extends('layouts.admin-layout')
@section('title','Quản lý kỳ thi')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý kỳ thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
    <li class="breadcrumb-item">Sắp phòng thi</li>
	  <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlkythi.danhsach')}}">Quản lý kỳ thi</a></li>
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
              
              <form action="{{ route('admin.sapphong.qlkythi.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Tên kỳ thi</label>
                      <input type="text" class="form-control @error('tenkythi') is-invalid @enderror" id="tenkythi" name="tenkythi" value="{{ old('tenkythi') }}" required>
                      
                      @error('tenkythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Học kỳ</label>
                      <select class="form-control" id="hocky" name="hocky" required>
                        <option value="">-- Chọn học kỳ --</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3 (hè)</option>
                      </select>
                      @error('hocky')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Năm học bắt đầu</label>
                      <input type="number" placeholder="vd: 2022" class="form-control @error('namhoc') is-invalid @enderror" id="namhoc" name="namhoc" value="{{ old('namhoc') }}" required>
                     
                      @error('namhoc')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                   
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Năm học kết thúc</label>
                      <input type="number" placeholder="vd: 2023" class="form-control @error('namhoc') is-invalid @enderror" id="namhoc" name="namhoc" value="{{ old('namhoc') }}" required>
                     
                      @error('namhoc')
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