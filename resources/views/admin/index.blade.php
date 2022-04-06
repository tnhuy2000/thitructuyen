@extends('layouts.admin-layout')
@section('title','Dashboard')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Bảng điều khiển</h1>
      
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Quản lý</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{route('admin.danhmuc.qlkhoa.danhsach')}}">Khoa</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.danhmuc.qllop.danhsach')}}">Lớp</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.danhmuc.qlsinhvien.danhsach')}}">Sinh viên</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.danhmuc.qlhoidongthi.danhsach')}}">Hội đồng thi</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.danhmuc.qlhocphan.danhsach')}}">Học phần</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">DANH MỤC <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bx bxs-food-menu"></i>
                    </div>
                    
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Quản lý</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{route('admin.sapphong.qlkythi.danhsach')}}">Kỳ thi</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.sapphong.qlcathi.danhsach')}}">Ca thi</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.sapphong.qlphongthi.danhsach')}}">Phòng thi</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">SẮP PHÒNG THI <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bx bxs-institution"></i>
                    </div>
                    
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Quản lý</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{route('admin.dethi_baithi.qldethi.danhsach')}}">Đề thi</a></li>
                    <li><a class="dropdown-item" href="{{route('admin.dethi_baithi.qlbaithi.danhsach')}}">Bài thi</a></li>
                   
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">KHO DỮ LIỆU ĐỀ THI & BÀI THI <span></span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bx bxs-layer"></i>
                    </div>
                   
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

         
          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
        <!-- Recent Activity -->
        <div class="card">
            

            <div class="card-body">
              <h5 class="card-title">THÔNG BÁO <span>| Mới nhất</span></h5>

              <div class="activity">
              
              @foreach($thongbao as $value)
                <div class="activity-item d-flex">
                  <div class="activite-label">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</div>
              
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  
                  <div class="activity-content">
                       <a href="{{ route('admin.dashboard.chitietthongbao', ['id' => $value->id]) }}" class="fw-bold text-dark">  {{ $value->tieude }}</a>
                      <p><a href="{{ route('admin.dashboard.chitietthongbao', ['id' => $value->id]) }}" class="text-danger">Xem tiếp <i class="bi bi-arrow-right-circle"></i></a></p>
                  </div>
                </div><!-- End activity item-->
                @endforeach

              </div>
              <div class="text-center mt-1">
                <a class="card-link " href="{{ route('admin.dashboard.tatcathongbao') }}"><i class="bi bi-eye-fill"></i> Xem tất cả</a>
               </div>
            </div>
            
          </div><!-- End Recent Activity -->
        

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->


  
  @endsection