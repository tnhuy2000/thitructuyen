@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý hội đồng thi | Sửa
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý hội đồng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qlhoidongthi.danhsach')}}">Quản lý hội đồng thi</a></li>
	  <li class="breadcrumb-item active">Sửa hội đồng thi</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa hội đồng thi</h5>
              
              <form action="{{ route('admin.danhmuc.qlhoidongthi.sua', ['macanbo' => $kthoidongthi->macanbo]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Mã cán bộ <span class="text-danger">*</span></label>
                      <input type="text" readonly class="form-control @error('macanbo') is-invalid @enderror" id="macanbo" name="macanbo" value="{{ $kthoidongthi->macanbo }}" required>
                      
                      @error('macanbo')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-3">
                      <label for="validationCustom02" class="form-label">Họ <span class="text-danger">*</span></label>
                      <input type="text"  class="form-control @error('holot') is-invalid @enderror" id="holot" name="holot" value="{{ $kthoidongthi->holot }}" required>
                     
                      @error('holot')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-5">
                      <label for="validationCustom02" class="form-label">Tên điệm và tên <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('ten') is-invalid @enderror" id="ten" name="ten" value="{{ $kthoidongthi->ten }}" required>
                      @error('ten')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                      <div class="form-group col-sm-6">
                        <label for="validationCustom02" class="form-label">Địa chỉ email <span class="text-danger">*</span></label>
                        <input type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $kthoidongthi->email }}" required>
                        @error('email')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                      </div>
                      <div class="form-group col-sm-6">
                      <label for="validationCustom02" class="form-label">Điện thoại <span class="text-danger">*</span></label>
                        <input type="number" placeholder="Điện thoại" class="form-control @error('dienthoai') is-invalid @enderror" id="dienthoai" name="dienthoai" value="{{ $kthoidongthi->dienthoai }}" required>
                        @error('dienthoai')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                      </div>
                
                      <div class="col-md-6">
                      <label for="makhoa" class="form-label">Khoa/Phòng ban <span class="text-danger">*</span></label>
                      <select class="form-control" id="makhoa" name="makhoa" required>
                        <option value="">-- Chọn Khoa/Phòng ban --</option>
                        @foreach($ktkhoa as $value){
                          @if($kthoidongthi->makhoa == $value->makhoa)
                            <option value="{{$value->makhoa}}" selected="selected">{{$value->tenkhoa}}</option>
                          
                          @else
                          {
                            <option value="{{$value->makhoa}}">{{$value->tenkhoa}}</option>
                          }
                          @endif
                          
                        }
                        @endforeach
 
                      </select>
                      @error('makhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="makhoa" class="form-label">Vai trò <span class="text-danger">*</span></label>
                      <select class="form-control" id="vaitro" name="vaitro" required>
                        <option value="">-- Chọn vai trò --</option>
                        
                          @if($kthoidongthi->vaitro=='canbocoithi'){
                            <option value="canbocoithi" selected="selected">Cán bộ coi thi</option>
                            <option value="thuky" >Thư ký</option>
                            <option value="hoidongthi" >Hội đồng thi</option>
                          }
                          @elseif($kthoidongthi->vaitro=='thuky')
                          {
                            <option value="canbocoithi" >Cán bộ coi thi</option>
                            <option value="thuky" selected="selected">Thư ký</option>
                            <option value="hoidongthi" >Hội đồng thi</option>
                          }
                          @else
                          {
                            <option value="canbocoithi" >Cán bộ coi thi</option>
                            <option value="thuky" >Thư ký</option>
                            <option value="hoidongthi" selected="selected">Hội đồng thi</option>
                          }
                          @endif
                      </select>
                      @error('vaitro')
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
        $(document).ready(function() {
            $("#makhoa").select2({         
              theme: "bootstrap-5",
              });   
        });
</script>

@endsection