<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span> 2022. Trường Đại học An Giang</span></strong>
    </div>
    <div class="credits">
      
      Bạn đang đăng nhập với tên <a style="text-decoration: underline;" href="dangxuat" data-bs-target="#ModalDangXuat" data-bs-toggle="modal">{{Auth::user()->name}} (Thoát)</a>
     
              
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 
  <!-- Vendor JS Files -->
  @jquery
  <script src="{{asset('public/select/jquery-1.8.0.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>  

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
  $(document).ready(function(){
	$("#spinnerBackupDB").hide();
	$("#buttonBackupDB").click(function(){
		$("#spinnerBackupDB").toggle(1000);
	});

  $("#spinnerBackupAll").hide();
	$("#buttonBackupAll").click(function(){
		$("#spinnerBackupAll").toggle(1000);
	});
});
 
</script>

  @toastr_js
  @toastr_render
  @yield('javascript')
