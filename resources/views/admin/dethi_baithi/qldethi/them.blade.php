@extends('layouts.admin-layout')
@section('title','Quản lý đề thi')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý đề thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>

	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qldethi.danhsach')}}">Quản lý đề thi</a></li>
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
              
              <form action="{{ route('admin.dethi_baithi.qldethi.them') }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Kỳ thi</label>
                      <select class="form-control @error('kythi_id') is-invalid @enderror" onchange="testb(this)" id="" name="kythi_id" required>
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){ 
                            <option value="{{$value->id}}">{{$value->tenkythi}} năm học {{$value->namhoc}}</option>
                        }
                        @endforeach
                      </select>
                      @error('kythi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Học phần</label>
                    <select class="form-control @error('mahocphan') is-invalid @enderror" onchange="test(this)" id="sv" name="mahocphan" class="required">
                        <option value="">-- Chọn học phần --</option>
                        @foreach($kthocphan as $value){ 
                            <option value="{{$value->mahocphan}}">{{$value->tenhocphan}} - {{$value->mahocphan}}</option>
                        }
                        @endforeach
                      </select>
                      @error('mahocphan')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    
                    <div class="form-group">
                      <label for="validationCustom02" class="form-label">Tên đề thi</label>
                      <input type="hidden" id="hocphan" required>
                      <input type="hidden" id="kythi" required>
                      <input type="text" class="form-control @error('tendethi') is-invalid @enderror" id="tendethi" name="tendethi" value="{{ old('tendethi') }}" required>
                      @error('tendethi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="validationCustom02" class="form-label">Thời gian làm bài (đơn vị: phút)</label>
                      <input type="text" class="form-control @error('thoigianlambai') is-invalid @enderror" id="thoigianlambai" name="thoigianlambai" value="{{ old('thoigianlambai') }}" required>
                      @error('thoigianlambai')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                    <div class="form-group col-sm-6">
                      <label for="MaLoai" class="form-label">Hình thức</label>
                      <select class="form-control" id="hinhthuc" name="hinhthuc" required>
                          <option value="">-- Chọn hình thức --</option>
                          <option value="tuluan">Tự luận</option>
                          <option value="thuchanh">Thực hành</option>
                      
                      </select>
                      @error('hinhthuc')
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
@section('javascript')    
<script type="text/javascript">
  function test(a) {
  var x = a.options[a.selectedIndex].text;
  var kythi=document.getElementById('kythi').value;
  $('#hocphan').val(x);
  $('#tendethi').val("Đề thi "+kythi+' học phần '+x);
  
  }
  function testb(a) {
    var x = a.options[a.selectedIndex].text;
    var ten=document.getElementById('hocphan').value;
    $('#kythi').val(x);
    $('#tendethi').val("Đề thi "+x+ ' học phần '+ten);
  }
</script>
@endsection
