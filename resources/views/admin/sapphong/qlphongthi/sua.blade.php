@extends('layouts.admin-layout')
@section('pagetitle')
Quản lý phòng thi | Sửa
@endsection
@section('content')

<main id="main" class="main">

<div class="pagetitle">
  <h1>Quản lý phòng thi</h1>
  <nav>
	<ol class="breadcrumb">
	  <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
    <li class="breadcrumb-item">Sắp phòng thi</li>
    <li class="breadcrumb-item"><a href="{{route('admin.sapphong.qlphongthi.danhsach')}}">Quản lý phòng thi</a></li>
	  <li class="breadcrumb-item active">Sửa phòng thi</li>
	</ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
	<div class="col-lg-12">

	  <div class="card">
      <div class="card-body">
              <h5 class="card-title">Sửa phòng thi</h5>
              
              <form action="{{ route('admin.sapphong.qlphongthi.sua', ['id' => $ktphongthi->id]) }}" method="post" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                      <label for="MaLoai" class="form-label">Ca thi</label>
                      <select class="form-select @error('cathi_id') is-invalid @enderror" id="statesCaThi" name="cathi_id">
                        <option value="">-- Chọn ca thi --</option>
                        @foreach($ktcathi as $value){
                          @if($ktphongthi->cathi_id == $value->id)
                            <option value="{{$value->id}}" selected="selected">{{$value->tenca}} - ngày: {{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}} - giờ bắt đầu: {{$value->giobatdau}}</option>
                          
                          @else
                          {
                            <option value="{{$value->id}}">{{$value->tenca}} - ngày: {{ \Carbon\Carbon::parse($value->ngaythi)->format('d/m/Y')}} - giờ bắt đầu: {{$value->giobatdau}}</option>
                          }
                          @endif
                        }
                        @endforeach
                      </select>
                      @error('cathi_id')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                    <label for="validationCustom01" class="form-label">Mã phòng</label>
                      <input type="text" class="form-control @error('maphong') is-invalid @enderror" id="maphong" name="maphong" value="{{ $ktphongthi->maphong }}" required>
                      
                      @error('maphong')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror

                    </div>
                    <div class="col-md-6">
                      <label for="validationCustom02" class="form-label">Số lượng thí sinh</label>
                      <input type="number" class="form-control @error('soluongthisinh') is-invalid @enderror" id="soluongthisinh" name="soluongthisinh" value="{{ $ktphongthi->soluongthisinh }}" required>
                     
                      @error('soluongthisinh')
                      <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                      @enderror
                    </div>
                    <div class="col-md-12">
                      <label for="validationCustom02" class="form-label">Ghi chú</label>
                      <textarea class="form-control @error('ghichu') is-invalid @enderror" id="ghichu" name="ghichu">{{ $ktphongthi->ghichu }}</textarea>
                      @error('ghichu')
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
            $("#statesCaThi").select2({         
              theme: "bootstrap-5",
              });   
        });

</script>

@endsection