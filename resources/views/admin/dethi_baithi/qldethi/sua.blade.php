@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý đề thi | Sửa
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý đề thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>

	  <li class="breadcrumb-item"><a href="{{route('admin.dethi_baithi.qldethi.danhsach')}}">Quản lý đề thi</a></li>
	  <li class="breadcrumb-item active">Sửa đề thi</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa đề thi</h5>
              
              <form action="{{ route('admin.dethi_baithi.qldethi.sua', ['id' => $ktdethi->id]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Kỳ thi <span class="text-danger">*</span></label>
                      <select class="form-control"  onchange="testb(this)" id="statesKyThi" name="kythi_id" required>
                        <option value="">-- Chọn kỳ thi --</option>
                        @foreach($ktkythi as $value){ 
                          @if($value->id==$ktdethi->kythi_id){
                            <option value="{{$value->id}}" selected="selected">{{$value->tenkythi}}</option>
                          }
                          @else
                          {
                            <option value="{{$value->id}}">{{$value->tenkythi}}</option>
                          }
                          @endif
                        }
                        @endforeach
                      </select>
                      @error('kythi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Học phần <span class="text-danger">*</span></label>
                    <select class="form-control"  onchange="test(this)" id="statesHocPhan" name="mahocphan" required>
                        <option value="">-- Chọn học phần --</option>
                        @foreach($kthocphan as $value){ 
                          @if($value->mahocphan==$ktdethi->mahocphan){
                            <option value="{{$value->mahocphan}}" selected="selected">{{$value->tenhocphan}} - {{$value->mahocphan}}</option>
                          }
                          @else
                          {
                            <option value="{{$value->mahocphan}}">{{$value->tenhocphan}} - {{$value->mahocphan}}</option>
                          }
                          @endif
                        }
                        @endforeach
                      </select>
                      @error('mahocphan')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    
                    <div class="form-group">
                    <input type="hidden" id="hocphan" required>
                      <input type="hidden" id="kythi" required>
                      <label for="validationCustom02" class="form-label">Tên đề thi <span class="text-danger">*</span></label>
                      <input type="hidden" id="hocphan" required>
                      <input type="hidden" id="kythi" required>
                      <input type="text" class="form-control @error('tendethi') is-invalid @enderror" id="tendethi" name="tendethi" value="{{ $ktdethi->tendethi }}" required>
                      @error('tendethi')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="form-group col-sm-6">
                      <label for="validationCustom02" class="form-label">Thời gian làm bài (đơn vị: phút) <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('thoigianlambai') is-invalid @enderror" id="thoigianlambai" name="thoigianlambai" value="{{ $ktdethi->thoigianlambai }}" required>
                      @error('thoigianlambai')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    
                    <div class="form-group col-sm-6">
                      <label for="MaLoai" class="form-label">Hình thức <span class="text-danger">*</span></label>
                      <select class="form-control" id="hinhthuc" name="hinhthuc" required>
                          <option value="">-- Chọn hình thức --</option>
                          @if($ktdethi->hinhthuc=="tuluan"){
                            <option value="tuluan" selected="selected">Tự luận</option>
                            <option value="thuchanh">Thực hành</option>
                          }
                          @else
                            <option value="tuluan">Tự luận</option>
                            <option value="thuchanh" selected="selected">Thực hành</option>
                          }
                          @endif
                          
                      </select>
                      @error('hinhthuc')
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
    function test(a) {
  var x = a.options[a.selectedIndex].text;
  var kythi=document.getElementById('kythi').value;
  $('#hocphan').val(x);
  $('#tendethi').val(kythi+' - học phần: '+x);
  
  }
  function testb(a) {
    var x = a.options[a.selectedIndex].text;
    var ten=document.getElementById('hocphan').value;
    $('#kythi').val(x);
    $('#tendethi').val(x+ ' - học phần: '+ten);
  }


        $(document).ready(function() {
            $("#statesKyThi").select2({         
              theme: "bootstrap-5",
              });
            $("#statesHocPhan").select2({         
              theme: "bootstrap-5",
              });   
        });
</script>
@endsection