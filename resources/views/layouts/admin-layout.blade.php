<!DOCTYPE html>
<html lang="en">

@include('layouts.header')

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
     
      <a href="{{route('admin.dashboard')}}" class="logo d-flex align-items-center">
        <img src="{{asset('public/themes/img/logo.png')}}" alt="">
        <span class="d-none d-lg-block e">Online Exam</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>

     
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-danger badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">  
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{Auth::user()->picture}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              @if(Auth::user()->role==1)
              <span>Quản trị viên</span>
              @endif
              @if(Auth::user()->role==2)
              <span>Thư ký</span>
              @endif
              @if(Auth::user()->role==3)
              <span>Cán bộ coi thi</span>
              @endif
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Hồ sơ cá nhân</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
           
              <a class="dropdown-item d-flex align-items-center" href="{{route('logout')}}" onclick="event.preventDefault();
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
        <a class="nav-link " href="{{route('admin.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Bảng điều khiển</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
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
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
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
          <li>
            <a href="{{route('admin.sapphong.qlsv_pt.all')}}" class="{{ request()->is('*/qlsv_pt*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Sinh viên - Phòng thi</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.sapphong.qlhdt_pt.all')}}" class="{{ request()->is('*/qlhdt_pt*') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Hội đồng thi - Phòng thi</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
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
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
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
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Thống kê</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="charts-chartjs.html">
              <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
          </li>
          <li>
            <a href="charts-apexcharts.html">
              <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
          </li>
          <li>
            <a href="charts-echarts.html">
              <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Charts Nav -->

      

      <li class="nav-heading">Hồ sơ</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Thông báo</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Biểu mẫu</span>
        </a>
      </li><!-- End Register Page Nav -->

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