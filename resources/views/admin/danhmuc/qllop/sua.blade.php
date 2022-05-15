@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý lớp | Sửa
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý lớp</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
	  <li class="breadcrumb-item"><a href="{{route('admin.danhmuc.qllop.danhsach')}}">Quản lý lớp</a></li>
	  <li class="breadcrumb-item active">Sửa lớp</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa lớp</h5>
              
              <form action="{{ route('admin.danhmuc.qllop.sua', ['malop' => $ktlop->malop]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Mã lớp</label>
                      <input type="text" class="form-control" id="malop" name="malop" value="{{ $ktlop->malop }}" readonly  required>
                      @error('malop')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Tên lớp</label>
                      <input type="text" class="form-control @error('tenlop') is-invalid @enderror" value="{{ $ktlop->tenlop }}"  id="tenlop" name="tenlop" required>
                      @error('tenlop')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Niên khoá</label>
                      <input type="text" class="form-control @error('nienkhoa') is-invalid @enderror" value="{{ $ktlop->nienkhoa }}"  id="nienkhoa" name="nienkhoa" required>
                      @error('nienkhoa')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                     
                    </div>
                    <div class="form-group col-md-12 ">
                      <label for="makhoa" class="form-label">Khoa</label>
                      <select class="form-select" id="statesKhoa" name="makhoa" required>
                        <option value="">-- Chọn Khoa --</option>
                        @foreach($ktkhoa as $value){
                          @if($ktlop->makhoa == $value->makhoa)
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
            $("#statesKhoa").select2();   
        });

</script>

@endsection