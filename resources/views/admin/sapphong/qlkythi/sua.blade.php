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
	  <li class="breadcrumb-item active">Sửa kỳ thi</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa kỳ thi</h5>
              
              <form action="{{ route('admin.sapphong.qlkythi.sua', ['id' => $ktkythi->id]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Tên kỳ thi</label>
                      <input type="text" class="form-control" id="tenkythi" name="tenkythi" value="{{ $ktkythi->tenkythi }}"  required>
                      @error('tenkythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Học kỳ</label>
                      <select class="form-control" id="hocky" name="hocky" required>
                        <option value="">-- Chọn học kỳ --</option>
                        @if($ktkythi->hocky=='1'){
                          <option value="1" selected="selected">1</option>
                          <option value="2">2</option>
                          <option value="3">3 (hè)</option>
                        }
                        @elseif($ktkythi->hocky=='2'){
                          <option value="1" >1</option>
                          <option value="2" selected="selected">2</option>
                          <option value="3">3 (hè)</option>
                        }
                        @else{
                          <option value="1" >1</option>
                          <option value="2" >2</option>
                          <option value="3" selected="selected">3 (hè)</option>
                        }
                        @endif
                          
                      </select>
                      @error('hocky')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Năm học</label>
                      <input type="text" class="form-control @error('namhoc') is-invalid @enderror" value="{{ $ktkythi->namhoc }}"  id="namhoc" name="namhoc" required>
                      @error('namhoc')
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