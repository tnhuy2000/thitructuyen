@extends('layouts.admin-layout')
@section('title','Quản lý hội đồng thi')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý hội đồng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qlhoidongthi.danhsach')}}">Quản lý hội đồng thi</a></li>
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
              
              <form action="{{ route('admin.danhmuc.qlhoidongthi.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Mã cán bộ</label>
                      <input type="text" placeholder="Vd: DTH185437" class="form-control @error('macanbo') is-invalid @enderror" id="macanbo" name="macanbo" value="{{ old('macanbo') }}" required>
                      
                      @error('macanbo')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-3">
                      <label for="validationCustom02" class="form-label">Họ lót</label>
                      <input type="text" placeholder="Vd: Nguyễn"  class="form-control @error('holot') is-invalid @enderror" id="holot" name="holot" value="{{ old('holot') }}" required>
                     
                      @error('holot')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-5">
                      <label for="validationCustom02" class="form-label">Tên điệm và tên</label>
                      <input type="text" placeholder="Vd: Văn A" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ old('ten') }}" required>
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
                   
                    <div class="col-md-6">
                      <label for="MaLoai" class="form-label">Khoa</label>
                      <select class="form-control" id="makhoa" name="makhoa" required>
                        <option value="">-- Chọn Khoa --</option>
                        @foreach($ktkhoa as $value){
                          <option value="{{$value->makhoa}}" {{(old('makhoa')==$value->makhoa)?'selected':''}}>{{$value->tenkhoa}}</option>
                        }
                        @endforeach
 
                      </select>
                      @error('makhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Vai trò</label>
                      <select class="form-control" id="vaitro" name="vaitro" required>
                        <option value="">-- Chọn vai trò --</option>
                        
                          <option value="canbocoithi">Giám thị (Cán bộ coi thi)</option>
                          <option value="thuky">Thư ký</option>
                          <option value="hoidongthi">Hội đồng thi</option>
 
                      </select>
                      @error('vaitro')
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