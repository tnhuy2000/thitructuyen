<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body >

 
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 40px; height: 40px;" role="status">
      <span class="visually-hidden">
        <font style="vertical-align: inherit;">
          <font style="vertical-align: inherit;">Đang tải...</font>
        </font>
      </span>
    </div>
  </div>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    
      
      
      <a href="{{route('admin.dashboard')}}" class="logo d-flex align-items-center">
        <img src="{{asset('public/themes/img/logo.png')}}" alt=""  class="rounded mb-1">
        
        
       
        <span class="d-none d-lg-block e text-white">Online Exam</span>
        
      </a>
        
        
      <i class="bi bi-list toggle-sidebar-btn"></i>

     
    </div><!-- End Logo -->

    
   
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        @if(Auth::user()->role==1)
        <li class="nav-item dropdown pe-3">  
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            
            <span class="d-none d-md-block dropdown-toggle ps-2 user_name"> <i class="fa-brands fa-google-drive"></i> Sao lưu</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Sao lưu</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="" data-bs-target="#myModalBackupAll" data-bs-toggle="modal">
               
                <span><i class="fa-regular fa-clone"></i> Sao lưu toàn bộ dữ liệu</span>
              </a>
            </li>
           
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
           
              <a class="dropdown-item d-flex align-items-center" href="" data-bs-target="#myModalBackupDB" data-bs-toggle="modal">
              
                <span><i class="fa-solid fa-database"></i> Sao lưu Database</span>
              </a>
              
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        @endif
        <li class="nav-item pe-3">  
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="{{route('admin.bieumau')}}">
            <span class="d-none d-md-block ps-2 user_name"><i class="fa-solid fa-file-excel"></i> Biểu mẫu</span>
          </a>
        </li>
        <li class="nav-item dropdown pe-3">  
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{Auth::user()->picture}}" alt="Profile" class="rounded-circle profile-user-img user_picture">
            <span class="d-none d-md-block dropdown-toggle ps-2 user_name">{{ Auth::user()->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              @if(Auth::user()->role==1)
              <span>Quản trị viên</span>
              @endif
              @if(Auth::user()->role==4)
              <span>Hội đồng thi</span>
              @endif
            
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile')}}">
                <i class="bi bi-person"></i>
                <span>Hồ sơ cá nhân</span>
              </a>
            </li>
           
         
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
           
              <a class="dropdown-item d-flex align-items-center" href="#dangxuat" data-bs-target="#ModalDangXuat" data-bs-toggle="modal">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
              
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/dashboard*') ? '' : 'collapsed' }}" href="{{route('admin.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Bảng điều khiển</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/danhmuc*') ? '' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Danh mục</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse  {{ request()->is('*/danhmuc*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li >
            <a href="{{route('admin.danhmuc.qlkhoa.danhsach')}}" class="{{ request()->is('*/qlkhoa*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Khoa</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qllop.danhsach')}}" class="{{ request()->is('*/qllop*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Lớp</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qlhocphan.danhsach')}}" class="{{ request()->is('*/qlhocphan*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Học phần</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qlsinhvien.danhsach')}}" class="{{ request()->is('*/qlsinhvien*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sinh viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qlhoidongthi.danhsach')}}" class="{{ request()->is('*/qlhoidongthi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Hội đồng thi</span>
            </a>
          </li>
         
          
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/sapphong*') ? '' : 'collapsed' }}" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Sắp phòng thi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse {{ request()->is('*/sapphong*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.sapphong.qlkythi.danhsach')}}" class="{{ request()->is('*/qlkythi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Kỳ thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.sapphong.qlcathi.danhsach')}}" class="{{ request()->is('*/qlcathi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Ca thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.sapphong.qlphongthi.danhsach')}}" class="{{ request()->is('*/qlphongthi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Phòng thi</span>
            </a>
          </li>
         
          
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/dethi_baithi*') ? '' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Đề thi & bài thi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse {{ request()->is('*/dethi_baithi*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.dethi_baithi.qldethi.danhsach')}}" class="{{ request()->is('*/qldethi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Đề thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.dethi_baithi.qlbaithi.danhsach')}}" class="{{ request()->is('*/qlbaithi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Bài thi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->
      @if(Auth::user()->role==1)
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/qlnguoidung*') ? '' : 'collapsed' }}" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Quản lý người dùng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse {{ request()->is('*/qlnguoidung*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.qlnguoidung.qltksinhvien.danhsach')}}" class="{{ request()->is('*/qltksinhvien*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sinh viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.qlnguoidung.qltkcanbocoithi.danhsach')}}" class="{{ request()->is('*/qltkcanbocoithi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Cán bộ coi thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.qlnguoidung.qltkthuky.danhsach')}}" class="{{ request()->is('*/qltkthuky*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Thư ký</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.qlnguoidung.qltkhoidongthi.danhsach')}}" class="{{ request()->is('*/qltkhoidongthi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Hội đồng thi</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->
      @endif
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/thongbao*') ? '' : 'collapsed' }}" data-bs-target="#thongbao-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-envelope"></i><span>Thông báo</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="thongbao-nav" class="nav-content collapse {{ request()->is('*/thongbao*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.thongbao.them')}}" class="{{ request()->is('*/dangthongbao') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Đăng thông báo</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.thongbao.danhsach')}}" class="{{ request()->is('*/thongbao/quanly*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Thông báo đã đăng</span>
            </a>
          </li>
         
        </ul>
      </li><!-- End thongbao Nav -->

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/thongke*') ? '' : 'collapsed' }}" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Thống kê</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse {{ request()->is('*/thongke*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.thongke.diemdanhsinhvien')}}" class="{{ request()->is('*/thongke/diemdanhsv*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Thống kê điểm danh Sinh viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.thongke.bailamsinhvien')}}" class="{{ request()->is('*/thongke/bailamsinhvien*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Thống kê bài làm Sinh viên</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Charts Nav -->
      @if(Auth::user()->role==1)
      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/app*') ? '' : 'collapsed' }}" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i><span>Hệ thống</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="setting-nav" class="nav-content collapse {{ request()->is('*/app*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a  href="#backupall" data-bs-target="#myModalBackupAll" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Sao lưu toàn bộ hệ thống</span>
            </a>
          </li>
          <li>
            <a href="" data-bs-target="#myModalBackupDB" data-bs-toggle="modal" >
              <i class="bi bi-circle"></i><span>Sao lưu cơ sở dữ liệu</span>
            </a>
          </li>
          <li>
            <a href="{{route('app.version')}}" >
              <i class="bi bi-circle"></i><span>Xem phiên bản hệ thống</span>
            </a>
          </li>
          @if(app()->isDownForMaintenance())
          <li>
            <a href="tatbaotri" data-bs-target="#ModalTatBaoTri" data-bs-toggle="modal" >
              <i class="bi bi-circle"></i><span>Tắt chế độ bảo trì</span>
            </a>
          </li>
          @else
          <li>
            <a href="batbaotri" data-bs-target="#ModalBatBaoTri" data-bs-toggle="modal"  >
              <i class="bi bi-circle"></i><span>Bật chế độ bảo trì</span>
            </a>
          </li>
          @endif
        </ul>
      </li><!-- End Charts Nav -->
      @endif

      <li class="nav-heading">Hồ sơ</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/profile') ? '' : 'collapsed' }}" href="{{ route('admin.profile')}}">
          <i class="bi bi-person"></i>
          <span>Hồ sơ cá nhân</span>
        </a>
      </li><!-- End Profile Page Nav -->

     

     

     

      <li class="nav-item">
        <a class="nav-link collapsed" href="dangxuat" data-bs-target="#ModalDangXuat" data-bs-toggle="modal" >
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
              
      </li><!-- End Login Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  
  @yield('content')
  @include('layouts.footer')
  <form action="{{ route('app.backupAll')}}" method="get">
		@csrf
		<div class="modal fade" id="myModalBackupAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Sao lưu</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="fw-bold text-danger">Bạn muốn sao lưu toàn bộ dữ liệu hệ thống?</p>
            <div id="spinnerBackupAll">
              <a href="" disabled="">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Đang sao lưu dữ liệu...</font>
                </font>
              </a>
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button id="buttonBackupAll" type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
  <form action="{{ route('app.backupDB')}}" method="get">
		@csrf
		<div class="modal fade" id="myModalBackupDB" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Sao lưu</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="fw-bold text-danger">Bạn muốn chỉ sao lưu database?</p>
            <div id="spinnerBackupDB">
              <a href="" disabled="">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Đang sao lưu dữ liệu...</font>
                </font>
              </a>
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button id="buttonBackupDB" type="submit" class="btn btn-danger" onclick="myBackup()">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
  <form action="{{ route('logout') }}" method="POST">
		@csrf
		<div class="modal fade" id="ModalDangXuat" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Đăng xuất</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="fw-bold text-danger">Bạn chắc chắn muốn đăng xuất?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
  <form action="{{route('app.down')}}" method="GET">
		@csrf
		<div class="modal fade" id="ModalBatBaoTri" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Bật chế độ bảo trì</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="fw-bold text-danger">Bạn muốn BẬT chế độ bảo trì trang web?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
  <form action="{{route('app.up')}}" method="GET">
		@csrf
		<div class="modal fade" id="ModalTatBaoTri" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
                      <h5 class="modal-title">Tắt chế độ bảo trì</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" >
						<p class="fw-bold text-danger">Bạn muốn TẮT chế độ bảo trì trang web?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Hủy bỏ</button>
						<button type="submit" class="btn btn-danger">Thực hiện</button>
					</div>
				</div>
			</div>
		</div>
	</form>	
</body>

</html>