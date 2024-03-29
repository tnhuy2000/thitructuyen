@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý lớp | Thêm
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý lớp</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qllop.danhsach')}}">Quản lý lớp</a></li>
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
              
              <form action="{{ route('admin.danhmuc.qllop.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Mã lớp <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('malop') is-invalid @enderror" placeholder="Ví dụ: DH19TH1" id="malop" name="malop" value="{{ old('malop') }}" required>
                      
                      @error('malop')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Tên lớp <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('tenlop') is-invalid @enderror" placeholder="Ví dụ: Đại học chính quy - Công nghệ thông tin 1 - 2018" id="tenlop" name="tenlop" value="{{ old('tenlop') }}" required>
                     
                      @error('tenlop')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Niên khoá <span class="text-danger">*</span></label>
                      <input type="text" placeholder="Ví dụ: 2018-2022" class="form-control @error('nienkhoa') is-invalid @enderror" id="nienkhoa" name="nienkhoa" value="{{ old('nienkhoa') }}" required>
                      @error('nienkhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                    <div class="col-md-12">
                      <label for="MaLoai" class="form-label">Khoa <span class="text-danger">*</span></label>
                     
                      <select class="form-select" id="statesKhoa" name="makhoa" required>
                        <option value="">-- Chọn Khoa --</option>
                        @foreach($ktkhoa as $value){
                          <option  value="{{$value->makhoa}}" {{(old('makhoa')==$value->makhoa)?'selected':''}}>{{$value->tenkhoa}}</option>
                        }
                        @endforeach
                        
                      </select>
                      @error('makhoa')
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
            $("#statesKhoa").select2({         
              theme: "bootstrap-5",
              });   
        });
</script>

@endsection