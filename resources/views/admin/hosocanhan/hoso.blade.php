@extends('layouts.admin-layout')
@section('title','Hồ sơ cá nhân')

@section('content')

<main id="main" class="main">

        <div class="pagetitle">
        <h1>Hồ sơ cá nhân</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Bảng điều khiển</a></li>
            <li class="breadcrumb-item active">Hồ sơ cá nhân</li>
            
            </ol>
        </nav>
        </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->

        <div class="col-md-4">
  
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
        <br>
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle user_picture" src="{{ Auth::user()->picture }}" alt="User profile picture">
                </div>

                <h3 class="mt-3"><p class="profile-username text-center user_name">{{Auth::user()->name}}</p></h3>

                <h6 class="text-muted text-center">Quyền hạn: Admin</h6>
                <div class="d-grid gap-2">
                <input type="file" name="user_image" id="user_image" style="opacity: 0;height:1px;display:none">
                <a href="javascript:void(0)" class="btn btn-primary btn-block" id="change_picture_btn"><b>Đổi ảnh đại diện</b></a>
                </div>
                
            </div>
            <!-- /.card-body -->
           
        </div>
        <!-- /.card -->


    </div>
<!-- /.col -->
<div class="col-md-8">

  <div class="card">
    <div class="card-header p-2">
    
 
    
       <div class="card-body">
        <form class="form-horizontal" method="POST" action="{{ route('admin.adminUpdateInfo') }}" id="InfoForm">
        @csrf  
        <h4>Thông tin tài khoản</h4>
            <div class="form-group row">
              <label for="inputName" class="col-sm-2 col-form-label">Họ tên</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="Họ tên" value="{{ Auth::user()->name }}" name="name">

                <span class="text-danger error-text name_error"></span>
              </div>
            </div>
            @if(Auth::user()->role!=1)
              @if(!empty($hoidongthi->dienthoai))
            <div class="form-group row mt-2">
              <label for="inputName" class="col-sm-2 col-form-label">Điện thoại</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPhone" placeholder="Điện thoại" value="{{ $hoidongthi->dienthoai }}" name="name">
                <span class="text-danger error-text name_error"></span>
              </div>
            </div>
              @endif
              @if(!empty($hoidongthi->tenkhoa))
            <div class="form-group row mt-2">
              <label for="inputName" class="col-sm-2 col-form-label">Khoa/phòng ban</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="" readonly value="{{ $hoidongthi->tenkhoa }}">

               
              </div>
            </div>
              @endif
            @endif
            <div class="form-group row mt-2">
              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" readonly placeholder="Email" value="{{ Auth::user()->email }}" name="email">
                
              </div>
            </div>
            
            <div class="form-group row mt-2">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-danger fw-bold">Cập nhật</button>
              </div>
            </div>
        </form>
      </div>
     
    
      <!-- /.tab-content -->
    </div><!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.col -->
</div>
    </section>

  </main><!-- End #main -->


  
  @endsection
  @section('javascript')
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    
  <script src="{{ asset('public/js/ijaboCropTool/ijaboCropTool.min.js') }}"></script>
  
    <script type="text/javascript">
       
        $.ajaxSetup({
     headers:{
       'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
     }
  });
  
  $(function(){

    /* UPDATE ADMIN PERSONAL INFO */

    $('#InfoForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
           url:$(this).attr('action'),
           method:$(this).attr('method'),
           data:new FormData(this),
           processData:false,
           dataType:'json',
           contentType:false,
           beforeSend:function(){
               $(document).find('span.error-text').text('');
           },
           success:function(data){
                if(data.status == 0){
                  $.each(data.error, function(prefix, val){
                    $('span.'+prefix+'_error').text(val[0]);
                  });
                }else{
                  $('.user_name').each(function(){
                     $(this).html( $('#InfoForm').find( $('input[name="name"]') ).val() );
                  });
                 // alert(data.msg);
                  toastr.success(data.msg);
                }
           }
        });
    });



    $(document).on('click','#change_picture_btn', function(){
      $('#user_image').click();
    });


    $('#user_image').ijaboCropTool({
          preview : '.user_picture',
          setRatio:1,
          allowedExtensions: ['jpg', 'jpeg','png'],
          buttonsText:['CROP','QUIT'],
          buttonsColor:['#30bf7d','#ee5155', -15],
          processUrl:'{{ route("admin.adminPictureUpdate") }}',
          // withCSRF:['_token','{{ csrf_token() }}'],
          onSuccess:function(message, element, status){
             toastr.success(message);
          },
          onError:function(message, element, status){
              toastr.error(message);
          }
       });


    

    
  });


</script>
@endsection
   