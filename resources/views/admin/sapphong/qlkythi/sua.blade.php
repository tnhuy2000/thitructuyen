@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý kỳ thi | Sửa
@endsection
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
              <h6 >Chú ý: (<span class="text-danger">*</span>) là bắt buộc.</h6>
              <form action="{{ route('admin.sapphong.qlkythi.sua', ['id' => $ktkythi->id]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Tên kỳ thi <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('tenkythi') is-invalid @enderror" id="tenkythi" name="tenkythi" value="{{ $ktkythi->tenkythi }}"  required>
                      @error('tenkythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Học kỳ <span class="text-danger">*</span></label>
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
                    @php
                    $namhoc=explode("-", $ktkythi->namhoc);
                    $namhocbatdau= $namhoc[0];
                    $namhocketthuc= $namhoc[1];
                    @endphp
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Năm học bắt đầu <span class="text-danger">*</span></label>
                      <input type="number"  class="form-control @error('namhocbatdau') is-invalid @enderror" id="namhocbatdau" name="namhocbatdau" value="{{$namhocbatdau}}" required>
                     
                      @error('namhocbatdau')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                  
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Năm học kết thúc <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('namhocketthuc') is-invalid @enderror" id="namhocketthuc" name="namhocketthuc" value="{{ $namhocketthuc }}" readonly required>
                     
                      @error('namhocketthuc')
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
@section('javascript')    
<script type="text/javascript">

  const source = document.getElementById('namhocbatdau');
  const result = document.getElementById('namhocketthuc');

  const inputHandler = function(e) {
    var namkethuc= e.target.value;
    result.value = parseInt(namkethuc) +1;
  }

  source.addEventListener('input', inputHandler);
  source.addEventListener('propertychange', inputHandler); // for IE8

</script>
@endsection