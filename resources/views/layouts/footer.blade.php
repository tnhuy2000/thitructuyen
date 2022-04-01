<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span> 2022. Trường Đại học An Giang</span></strong>
    </div>
    <div class="credits">
      
      Bạn đang đăng nhập với tên <a href="{{route('logout')}}" style="text-decoration: underline;" onclick="event.preventDefault();
       document.getElementById('logout-form').submit();">{{Auth::user()->name}} (Thoát)</a>
     
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 
  <!-- Vendor JS Files -->

  <script src="{{asset('public/themes/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('public/themes/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('public/themes/vendor/php-email-form/validate.js')}}"></script>
 
  <script src="{{ asset('public/vendor/popper.js/1.16.1/popper.min.js') }}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('public/themes/js/main.js')}}"></script>


  <script type="text/javascript">
 
</script>
  @jquery
  @toastr_js
  @toastr_render
  @yield('javascript')
