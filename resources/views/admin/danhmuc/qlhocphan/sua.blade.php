@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý học phần | Sửa
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý học phần</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qlhocphan.danhsach')}}">Quản lý học phần</a></li>
	  <li class="breadcrumb-item active">Sửa học phần</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa học phần</h5>
              
              <form action="{{ route('admin.danhmuc.qlhocphan.sua', ['mahocphan' => $kthocphan->mahocphan]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Mã học phần</label>
                      <input type="text" class="form-control" id="mahocphan" name="mahocphan" value="{{ $kthocphan->mahocphan }}" readonly  required>
                      @error('mahocphan')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Tên học phần</label>
                      <input type="text" class="form-control @error('tenhocphan') is-invalid @enderror" value="{{ $kthocphan->tenhocphan }}"  id="tenhocphan" name="tenhocphan" required>
                      @error('tenhocphan')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Số tín chỉ</label>
                      <input type="text" class="form-control @error('sotinchi') is-invalid @enderror" value="{{ $kthocphan->sotinchi }}"  id="sotinchi" name="sotinchi" required>
                      @error('sotinchi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary"><i class="fa-regular fa-floppy-disk"></i> Cập nhật</button>
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