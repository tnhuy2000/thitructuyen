<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

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

            {{-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Đổi mật khẩu</span>
              </a>
            </li> --}}
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
           
              <a class="dropdown-item d-flex align-items-center" href="#dangxuat" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
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
            <a href="{{route('admin.danhmuc.qlsinhvien.danhsach')}}" class="{{ request()->is('*/qlsinhvien*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sinh viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qlhoidongthi.danhsach')}}" class="{{ request()->is('*/qlhoidongthi*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Hội đồng thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.danhmuc.qlhocphan.danhsach')}}" class="{{ request()->is('*/qlhocphan*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Học phần</span>
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

    
<!--      
      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Biểu mẫu</span>
        </a>
      </li> -->

      <li class="nav-heading">Hồ sơ</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('*/profile') ? '' : 'collapsed' }}" href="{{ route('admin.profile')}}">
          <i class="bi bi-person"></i>
          <span>Hồ sơ cá nhân</span>
        </a>
      </li><!-- End Profile Page Nav -->

     

     

     

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('logout')}}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
      </li><!-- End Login Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  
  @yield('content')
  @include('layouts.footer')

</body>

</html>