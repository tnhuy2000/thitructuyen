@extends('layouts.giamthi-layout')
@section('title','Dashboard')

@section('css')

@endsection('css')
@section('content')

    <!-- Pricing Start -->
    <div class="container-xxl">
        <div class="container py-3">
            <div class="text-center wow" data-wow-delay="0.1s">
                <h6 class="text-secondary text-uppercase">Online Exams</h6>
                <h1 class="">Hồ sơ cá nhân</h1>
            </div>
            
            <br>
            <div class="row g-4">
                <!-- Left side columns -->

                <div class="col-md-3">
                    <div class="team-item p-4">
                        <div class="overflow-hidden text-center mb-4">
                            <img class="profile-user-img img-fluid  user_picture"
                                    src="{{ Auth::user()->picture }}" alt="User profile picture">
                        </div>
                        <h5 class="profile-username text-center user_name">{{ Auth::user()->name }}</h5>
                        @if(Auth::user()->role==2)
                        <h6 class="text-muted text-center">Thư ký</h6>
                        @elseif(Auth::user()->role==3)
                        <h6 class="text-muted text-center">Cán bộ coi thi</h6>
                        @endif
                        <div class="btn-slide mt-1">
                            <i class="fa fa-share"></i>
                            <span >
                                <div class="d-grid gap-2">
                                    <input type="file" name="user_image" id="user_image"
                                        style="opacity: 0;height:1px;display:none">
                                    <a href="javascript:void(0)" class="text-white"
                                        id="change_picture_btn"><b>Đổi ảnh đại diện</b></a>
                                </div>
                            </span>
                        </div>
                    </div>
                    <!-- Profile Image -->
                    


                </div>
                <!-- /.col -->
                <div class="col-md-9">

                    <div class="card">
                        <div class="card-header p-2">

                            <div class="card-body">
                                <!-- Bordered Tabs Justified -->
                                <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100 active fw-bold" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-profile" type="button" role="tab"
                                            aria-controls="home" aria-selected="true">Thông tin tài khoản</button>
                                    </li>
                                    <li class="nav-item flex-fill" role="presentation">
                                        <button class="nav-link w-100 fw-bold" id="password-tab" data-bs-toggle="tab"
                                            data-bs-target="#bordered-justified-changepassword" type="button" role="tab"
                                            aria-controls="profile" aria-selected="false">Đổi mật khẩu</button>
                                    </li>

                                </ul>
                                <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                                    <div class="tab-pane fade show active" id="bordered-justified-profile"
                                        role="tabpanel" aria-labelledby="home-tab">

                                        <form class="form-horizontal" method="POST"
                                            action="{{ route('giamthi.giamthiUpdateInfo') }}" id="InfoForm">
                                            @csrf
                                            <h4>Thông tin tài khoản</h4>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-3 form-label">Tên hiển thị</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="inputName"
                                                        placeholder="Họ tên" value="{{ Auth::user()->name }}" name="name">

                                                    <span class="text-danger error-text name_error"></span>
                                                </div>
                                            </div>
                                            
                                                @if (!empty($giamthi->dienthoai))
                                                    <div class="form-group row mt-2">
                                                        <label for="inputName" class="col-sm-3 form-label">Điện
                                                            thoại</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="inputPhone"
                                                                placeholder="Điện thoại"
                                                                value="{{ $giamthi->dienthoai }}" name="dienthoai">
                                                            <span class="text-danger error-text dienthoai_error"></span>
                                                       
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if (!empty($giamthi->tenkhoa))
                                                    <div class="form-group row mt-2">
                                                        <label for="inputName" class="col-sm-3 form-label">Khoa/Phòng ban</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="" readonly
                                                                value="{{ $giamthi->tenkhoa }}">


                                                        </div>
                                                    </div>
                                                @endif
                                           
                                            <div class="form-group row mt-2">
                                                <label for="inputEmail" class="col-sm-3 form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="inputEmail" readonly
                                                        placeholder="Email" value="{{ Auth::user()->email }}"
                                                        name="email">

                                                </div>
                                            </div>

                                            <div class="form-group row mt-2">
                                                <div class="offset-sm-3 col-sm-9">
                                                    <button type="submit" class="btn btn-primary fw-bold"><i class="fas fa-save"></i> Cập nhật hồ sơ</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="tab-pane fade" id="bordered-justified-changepassword" role="tabpanel"
                                        aria-labelledby="contact-tab">
                                        <form class="form-horizontal" action="{{ route('giamthi.giamthiChangePassword')}}" method="POST" id="changePasswordForm">
                                          @csrf
                                          <h4>Đổi mật khẩu</h4>
                                            <div class="form-group row mt-2">
                                                <label for="inputName" class="col-sm-3 form-label">Mật khẩu hiện tại</label>
                                                <div class="col-sm-9">
                                                  <input type="password" class="form-control" id="oldpassword" placeholder="Nhập mật khẩu hiện tại" name="oldpassword">
                                                  <span class="text-danger error-text oldpassword_error"></span>
                                                </div>
                                              </div>
                                              <div class="form-group row mt-2">
                                                <label for="inputName2" class="col-sm-3 form-label">Mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                  <input type="password" class="form-control" id="newpassword" placeholder="Nhập mật khẩu mới " name="newpassword">
                                                  <span class="text-danger error-text newpassword_error mt-2"></span>
                                                </div>
                                              </div>
                                              <div class="form-group row mt-2">
                                                <label for="inputName3" class="col-sm-3 form-label">Nhập lại mật khẩu mới</label>
                                                <div class="col-sm-9">
                                                  <input type="password" class="form-control" id="cnewpassword" placeholder="Nhập lại mật khẩu mới" name="cnewpassword">
                                                  <span class="text-danger error-text cnewpassword_error mt-2"></span>
                                                 
                                                  <p><button type="submit" class="btn btn-primary fw-bold mt-2"><i class="fas fa-save"></i> Cập nhật</button></p>
                                                </div>
                                              </div>
                                             
                                              
                                            </form>
                                    </div>
                                </div><!-- End Bordered Tabs Justified -->
                            </div>


                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
   
  @endsection

  @section('javascript')
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

  <script src="{{ asset('public/js/ijaboCropTool/ijaboCropTool.min.js') }}"></script>

  <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $(function() {

          /* UPDATE giamthi PERSONAL INFO */

          $('#InfoForm').on('submit', function(e) {
              e.preventDefault();

              $.ajax({
                  url: $(this).attr('action'),
                  method: $(this).attr('method'),
                  data: new FormData(this),
                  processData: false,
                  dataType: 'json',
                  contentType: false,
                  beforeSend: function() {
                      $(document).find('span.error-text').text('');
                  },
                  success: function(data) {
                      if (data.status == 0) {
                          $.each(data.error, function(prefix, val) {
                              $('span.' + prefix + '_error').text(val[0]);
                          });
                      } else {
                          $('.user_name').each(function() {
                              $(this).html($('#InfoForm').find($(
                                  'input[name="name"]')).val());
                          });
                          
                          // alert(data.msg);
                          toastr.success(data.msg);
                      }
                  }
              });
          });



          $(document).on('click', '#change_picture_btn', function() {
              $('#user_image').click();
          });


          $('#user_image').ijaboCropTool({
              preview: '.user_picture',
              setRatio: 1,
              allowedExtensions: ['jpg', 'jpeg', 'png'],
              buttonsText: ['CROP', 'QUIT'],
              buttonsColor: ['#30bf7d', '#ee5155', -15],
              processUrl: '{{ route('giamthi.giamthiPictureUpdate') }}',
              // withCSRF:['_token','{{ csrf_token() }}'],
              onSuccess: function(message, element, status) {
                  toastr.success(message);
              },
              onError: function(message, element, status) {
                  toastr.error(message);
              }
          });



          $('#changePasswordForm').on('submit', function(e){
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
                  $('#changePasswordForm')[0].reset();
                  toastr.success(data.msg);
                }
              }
          });
      });


      });
  </script>
@endsection