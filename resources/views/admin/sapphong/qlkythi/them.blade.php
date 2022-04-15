@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý kỳ thi | Thêm
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
                    <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Tên kỳ thi</label>
                      <input type="text" class="form-control @error('tenkythi') is-invalid @enderror" id="tenkythi" name="tenkythi" value="{{ old('tenkythi') }}" required>
                      
                      @error('tenkythi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Học kỳ</label>
                      <select class="form-control" id="hocky" name="hocky" required>
                        <option value="" {{old('hocky')=='' ?'selected':''}}>-- Chọn học kỳ --</option>
                          <option value="1" {{old('hocky')=='1' ?'selected':''}}>1</option>
                          <option value="2" {{old('hocky')=='2' ?'selected':''}}>2</option>
                          <option value="3" {{old('hocky')=='3' ?'selected':''}}>3 (hè)</option>
                      </select>
                      @error('hocky')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Năm học bắt đầu</label>
                      <input type="number"   class="form-control @error('namhocbatdau') is-invalid @enderror" id="namhocbatdau" name="namhocbatdau" value="{{ old('namhocbatdau') }}" required>
                     
                      @error('namhocbatdau')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                  
                    <div class="col-md-4">
                      <label for="validationCustom02" class="form-label">Năm học kết thúc</label>
                      <input type="number"  class="form-control @error('namhocketthuc') is-invalid @enderror" id="namhocketthuc" name="namhocketthuc" value="{{ old('namhocketthuc') }}" readonly required>
                    
                      @error('namhocketthuc')
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