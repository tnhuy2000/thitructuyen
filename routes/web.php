<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SinhVienController;
use App\Http\Controllers\HoiDongThiController;
use App\Http\Controllers\HocPhanController;
use App\Http\Controllers\KyThiController;
use App\Http\Controllers\CaThiController;
use App\Http\Controllers\PhongThiController;
use App\Http\Controllers\DeThiController;
use App\Http\Controllers\DuLieuDeThiController;
use App\Http\Controllers\SinhVienPhongThiController;
use App\Http\Controllers\HoiDongThiPhongThiController;
use App\Http\Controllers\DeThiPhongThiController;
use App\Http\Controllers\KhoaController;
use App\Http\Controllers\BaiThiController;
use App\Http\Controllers\LopController;
use App\Http\Controllers\RestoreDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZipController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\VanBanController;
use App\Http\Controllers\ThongKeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});

// Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'getHome'])->name('frontend');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Google OAuth
Route::get('/login/google', [HomeController::class, 'getGoogleLogin'])->name('google.login');
Route::get('/login/google/callback', [HomeController::class, 'getGoogleCallback'])->name('google.callback');
// Cấu hình
Route::prefix('app')->middleware(['isAdmin','auth','PreventBackHistory'])->group(function() {
	Route::get('/v', function() {
		$laravel = app();
		return redirect()->route('admin.dashboard')->with('status', 'Version: Laravel ' . $laravel::VERSION);
	})->name('app.version');
	

	Route::get('/down', function() {
		Artisan::call('down');
		return redirect()->route('admin.dashboard')->with('status', 'Application is now in maintenance mode.');
	})->name('app.down');
	
	Route::get('/up', function() {
		Artisan::call('up');
		return redirect()->route('admin.dashboard')->with('status', 'Application is now live.');
	})->name('app.up');
	
  Route::get('/backupAll', function() {
		Artisan::call('backup:run');
		return redirect()->route('admin.dashboard')->with('status', 'Đã sao lưu dữ liệu hệ thống. Vui lòng truy cập email để xem thông tin chi tiết.');
	})->name('app.backupAll');
  Route::get('/backupDB', function() {
		Artisan::call('backup:run --only-db');
		return redirect()->route('admin.dashboard')->with('status', 'Đã sao lưu database. Vui lòng truy cập email để xem thông tin chi tiết.');
	})->name('app.backupDB');
});
Route::prefix('admin')->name('admin.')->middleware(['isHoiDongThi','auth','PreventBackHistory'])->group(function() {
    
        Route::get('/', [AdminController::class, 'getDashboard'])->name('getdashboard');
        Route::get('/403', [AdminController::class,'getForbidden'])->name('forbidden');
        Route::get('dashboard',[AdminController::class,'index'])->name('dashboard');

        //Route::get('saoluu',[RestoreDataController::class,'Backup'])->name('saoluu');
        Route::post('restoreDB',[RestoreDataController::class,'Restore'])->name('restoreDB');
      
        Route::get('bieumau',[AdminController::class,'getBieuMau'])->name('bieumau');
        Route::get('taibieumau/{tenbieumau}',[AdminController::class,'TaiBieuMau'])->name('taibieumau');
        Route::get('/dashboard/chitietthongbao/{id}',  [ThongBaoController::class, 'getChiTietThongBao'])->name('dashboard.chitietthongbao');
        Route::get('/dashboard/tatcathongbao',  [ThongBaoController::class, 'getTatCaThongBao'])->name('dashboard.tatcathongbao');
        Route::get('/dashboard/taivanban/{id}',  [VanBanController::class, 'getTaiVanBan'])->name('dashboard.taivanban');


        Route::prefix('thongbao')->name('thongbao.')->group(function() {
          
          Route::get('/quanly/danhsach', [ThongBaoConTroller::class, 'getDanhSach'])->name('danhsach');
          Route::get('/dangthongbao',  [ThongBaoConTroller::class, 'getThem'])->name('them');
          Route::post('/dangthongbao',  [ThongBaoConTroller::class, 'postThem']);
          Route::get('/quanly/sua/{id}',  [ThongBaoConTroller::class, 'getSua'])->name('sua');
          Route::post('/quanly/sua/{id}',  [ThongBaoConTroller::class, 'postSua'])->name('sua');
          Route::post('/xoa',  [ThongBaoConTroller::class, 'postXoa'])->name('xoa');
          Route::get('/quantrong/{id}',  [ThongBaoConTroller::class, 'getQuanTrong'])->name('quantrong');
          Route::get('/kichhoat/{id}',  [ThongBaoConTroller::class, 'getKichHoat'])->name('kichhoat');
          
          
          Route::get('/quanly/vanban/{id}',  [VanBanController::class, 'getDanhSach'])->name('vanban');
          Route::post('/quanly/vanban/them',  [VanBanController::class, 'postThem'])->name('vanban.them');
          Route::post('/quanly/vanban/sua',  [VanBanController::class, 'postSua'])->name('vanban.sua');
          Route::post('/quanly/vanban/xoa',  [VanBanController::class, 'postXoa'])->name('vanban.xoa');
          Route::get('/quanly/vanban/{idthongbao}/kichhoat/{id}',  [VanBanController::class, 'getKichHoat'])->name('vanban.kichhoat');
          Route::post('/vanban/ajax',  [VanBanController::class, 'postVanBanAjax'])->name('vanban.ajax');
          
         
          
        });
        Route::prefix('thongke')->name('thongke.')->group(function() {
          
          Route::get('/diemdanhsv', [ThongKeController::class, 'getTKDiemDanh'])->name('diemdanhsinhvien');
          Route::get('/bailamsinhvien',  [ThongKeController::class, 'getTKBaiLam'])->name('bailamsinhvien');
          Route::get('/xuat', [ThongKeController::class, 'getXuatTKBaiLam'])->name('xuat');
          Route::post('/bailamsinhvien/timkiem', [ThongKeController::class, 'postTKBaiLamTimKiem'])->name('tkbailamtimkiem');
          
          
        });
        Route::prefix('danhmuc')->name('danhmuc.')->group(function() {
        // Quản lý khoa
        Route::get('qlkhoa', [KhoaController::class, 'getDanhSach'])->name('qlkhoa.danhsach');
        Route::post('qlkhoa/them', [KhoaController::class, 'postThem'])->name('qlkhoa.them');
        Route::post('qlkhoa/sua', [KhoaController::class, 'postSua'])->name('qlkhoa.sua');       
        Route::post('qlkhoa/xoa', [KhoaController::class, 'postXoa'])->name('qlkhoa.xoa');
        Route::post('qlkhoa/nhap', [KhoaController::class, 'postNhap'])->name('qlkhoa.nhap');
        Route::get('qlkhoa/xuat', [KhoaController::class, 'getXuat'])->name('qlkhoa.xuat');
    
        // Quản lý lớp
        Route::get('qllop', [LopController::class, 'getDanhSach'])->name('qllop.danhsach');
        Route::get('qllop/them', [LopController::class, 'getThem'])->name('qllop.them');
        Route::post('qllop/them', [LopController::class, 'postThem'])->name('qllop.them');
        Route::get('qllop/sua/{malop}', [LopController::class, 'getSua'])->name('qllop.sua');
        Route::post('qllop/sua/{malop}', [LopController::class, 'postSua'])->name('qllop.sua');       
        Route::post('qllop/xoa', [LopController::class, 'postXoa'])->name('qllop.xoa');

        Route::post('qllop/nhap', [LopController::class, 'postNhap'])->name('qllop.nhap');
        Route::get('qllop/xuat', [LopController::class, 'getXuat'])->name('qllop.xuat');
        
        // Quản lý sinh viên
        Route::get('qlsinhvien', [SinhVienController::class, 'getDanhSach'])->name('qlsinhvien.danhsach');
        Route::get('qlsinhvien/them', [SinhVienController::class, 'getThem'])->name('qlsinhvien.them');
        Route::post('qlsinhvien/them', [SinhVienController::class, 'postThem'])->name('qlsinhvien.them');
        Route::get('qlsinhvien/sua/{masinhvien}', [SinhVienController::class, 'getSua'])->name('qlsinhvien.sua');
        Route::post('qlsinhvien/sua/{masinhvien}', [SinhVienController::class, 'postSua'])->name('qlsinhvien.sua');       
        Route::post('qlsinhvien/xoa', [SinhVienController::class, 'postXoa'])->name('qlsinhvien.xoa');

        Route::post('qlsinhvien/nhap', [SinhVienController::class, 'postNhap'])->name('qlsinhvien.nhap');
        Route::get('qlsinhvien/xuat', [SinhVienController::class, 'getXuat'])->name('qlsinhvien.xuat');
        
        // Quản lý hoidongthi
        Route::get('qlhoidongthi', [HoiDongThiController::class, 'getDanhSach'])->name('qlhoidongthi.danhsach');
        Route::get('qlhoidongthi/them', [HoiDongThiController::class, 'getThem'])->name('qlhoidongthi.them');
        Route::post('qlhoidongthi/them', [HoiDongThiController::class, 'postThem'])->name('qlhoidongthi.them');
        Route::get('qlhoidongthi/sua/{macanbo}', [HoiDongThiController::class, 'getSua'])->name('qlhoidongthi.sua');
        Route::post('qlhoidongthi/sua/{macanbo}', [HoiDongThiController::class, 'postSua'])->name('qlhoidongthi.sua');       
        Route::post('qlhoidongthi/xoa', [HoiDongThiController::class, 'postXoa'])->name('qlhoidongthi.xoa');

        Route::post('qlhoidongthi/nhap', [HoiDongThiController::class, 'postNhap'])->name('qlhoidongthi.nhap');
        Route::get('qlhoidongthi/xuat', [HoiDongThiController::class, 'getXuat'])->name('qlhoidongthi.xuat');
        
        // Quản lý học phần
        Route::get('qlhocphan', [HocPhanController::class, 'getDanhSach'])->name('qlhocphan.danhsach');
        Route::get('qlhocphan/them', [HocPhanController::class, 'getThem'])->name('qlhocphan.them');
        Route::post('qlhocphan/them', [HocPhanController::class, 'postThem'])->name('qlhocphan.them');
        Route::get('qlhocphan/sua/{mahocphan}', [HocPhanController::class, 'getSua'])->name('qlhocphan.sua');
        Route::post('qlhocphan/sua/{mahocphan}', [HocPhanController::class, 'postSua'])->name('qlhocphan.sua');       
        Route::post('qlhocphan/xoa', [HocPhanController::class, 'postXoa'])->name('qlhocphan.xoa');

        Route::post('qlhocphan/nhap', [HocPhanController::class, 'postNhap'])->name('qlhocphan.nhap');
        Route::get('qlhocphan/xuat', [HocPhanController::class, 'getXuat'])->name('qlhocphan.xuat');

        });
        //Sắp phòng
        Route::prefix('sapphong')->name('sapphong.')->group(function() {
        // Quản lý kỳ thi
        Route::get('qlkythi', [KyThiController::class, 'getDanhSach'])->name('qlkythi.danhsach');
        Route::get('qlkythi/them', [KyThiController::class, 'getThem'])->name('qlkythi.them');
        Route::post('qlkythi/them', [KyThiController::class, 'postThem'])->name('qlkythi.them');
        Route::get('qlkythi/sua/{id}', [KyThiController::class, 'getSua'])->name('qlkythi.sua');
        Route::post('qlkythi/sua/{id}', [KyThiController::class, 'postSua'])->name('qlkythi.sua');       
        Route::post('qlkythi/xoa', [KyThiController::class, 'postXoa'])->name('qlkythi.xoa');
        
         // Quản lý ca thi
         Route::get('qlcathi', [CaThiController::class, 'getDanhSach'])->name('qlcathi.danhsach');
         Route::get('qlcathi/them', [CaThiController::class, 'getThem'])->name('qlcathi.them');
         Route::post('qlcathi/them', [CaThiController::class, 'postThem'])->name('qlcathi.them');
         Route::get('qlcathi/sua/{id}', [CaThiController::class, 'getSua'])->name('qlcathi.sua');
         Route::post('qlcathi/sua/{id}', [CaThiController::class, 'postSua'])->name('qlcathi.sua');       
         Route::post('qlcathi/xoa', [CaThiController::class, 'postXoa'])->name('qlcathi.xoa');
         Route::post('qlcathi/nhap', [CaThiController::class, 'postNhap'])->name('qlcathi.nhap');
         Route::post('qlcathi/xuat', [CaThiController::class, 'postXuat'])->name('qlcathi.xuat');

          // Quản lý phòng thi
          Route::get('qlphongthi', [PhongThiController::class, 'getDanhSach'])->name('qlphongthi.danhsach');
          Route::get('qlphongthi/them', [PhongThiController::class, 'getThem'])->name('qlphongthi.them');
          Route::post('qlphongthi/them', [PhongThiController::class, 'postThem'])->name('qlphongthi.them');
          Route::get('qlphongthi/sua/{id}', [PhongThiController::class, 'getSua'])->name('qlphongthi.sua');
          Route::post('qlphongthi/sua/{id}', [PhongThiController::class, 'postSua'])->name('qlphongthi.sua');       
          Route::post('qlphongthi/xoa', [PhongThiController::class, 'postXoa'])->name('qlphongthi.xoa');

          Route::post('qlphongthi/nhap', [PhongThiController::class, 'postNhap'])->name('qlphongthi.nhap');

          //sinh vien phong thi
        
          Route::get('qlphongthi/qlsv_pt/{id}', [SinhVienPhongThiController::class, 'getDanhSach'])->name('qlsv_pt.danhsach');
          Route::post('qlphongthi/qlsv_pt/xoa', [SinhVienPhongThiController::class, 'postXoa'])->name('qlsv_pt.xoa');
          Route::post('qlphongthi/qlsv_pt/them/{phongthi_id}', [SinhVienPhongThiController::class, 'postThem'])->name('qlsv_pt.them');
          Route::post('qlphongthi/qlsv_pt/sua', [SinhVienPhongThiController::class, 'postSua'])->name('qlsv_pt.sua');

          Route::get('qlphongthi/qlsv_pt/diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getDiemDanh'])->name('qlsv_pt.diemdanh');

          Route::post('qlphongthi/qlsv_pt/nhap/{phongthi_id}', [SinhVienPhongThiController::class, 'postNhap'])->name('qlsv_pt.nhap');
          Route::get('qlphongthi/qlsv_pt/xuat/{phongthi_id}', [SinhVienPhongThiController::class, 'getXuat'])->name('qlsv_pt.xuat');


          //hoi dong thi phong thi
         
          Route::get('qlphongthi/qlhdt_pt/{id}', [HoiDongThiPhongThiController::class, 'getDanhSach'])->name('qlhdt_pt.danhsach');

          Route::post('qlphongthi/qlhdt_pt/xoa', [HoiDongThiPhongThiController::class, 'postXoa'])->name('qlhdt_pt.xoa');
          Route::post('qlphongthi/qlhdt_pt/them/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postThem'])->name('qlhdt_pt.them');
          Route::post('qlphongthi/qlhdt_pt/sua', [HoiDongThiPhongThiController::class, 'postSua'])->name('qlhdt_pt.sua');

          Route::post('qlphongthi/qlhdt_pt/nhap/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postNhap'])->name('qlhdt_pt.nhap');
          Route::get('qlphongthi/qlhdt_pt/xuat/{phongthi_id}', [HoiDongThiPhongThiController::class, 'getXuat'])->name('qlhdt_pt.xuat');
        });
          Route::prefix('dethi_baithi')->name('dethi_baithi.')->group(function() {
          // Quản lý đề thi
          Route::get('qldethi', [DeThiController::class, 'getDanhSach'])->name('qldethi.danhsach');
          Route::get('qldethi/them', [DeThiController::class, 'getThem'])->name('qldethi.them');
          Route::post('qldethi/them', [DeThiController::class, 'postThem'])->name('qldethi.them');
          Route::get('qldethi/sua/{id}', [DeThiController::class, 'getSua'])->name('qldethi.sua');
          Route::post('qldethi/sua/{id}', [DeThiController::class, 'postSua'])->name('qldethi.sua');       
          Route::post('qldethi/xoa', [DeThiController::class, 'postXoa'])->name('qldethi.xoa');

          Route::get('qldethi/dulieudethi/{id}', [DeThiController::class, 'getDuLieuDeThi'])->name('qldethi.dulieudethi');
          
        //mới
          Route::get('qldulieudethi/{id}', [DuLieuDeThiController::class, 'getDanhSachDuLieu'])->name('qldulieudethi.danhsach');
          Route::post('qldulieudethi/themmoi/{dethi_id}', [DuLieuDeThiController::class, 'postThemMoi'])->name('qldulieudethi.themmoi');
          Route::post('qldulieudethi/sua', [DuLieuDeThiController::class, 'postSua'])->name('qldulieudethi.sua');
          Route::post('qldulieudethi/xoa', [DuLieuDeThiController::class, 'postXoa'])->name('qldulieudethi.xoa');
          Route::post('qldulieudethi/ajax', [DuLieuDeThiController::class, 'postHinhAnhAjax'])->name('qldulieudethi.ajax');

        //ql đề thi-phong thi
          Route::get('qldethi/qldt_pt/{id}', [DeThiPhongThiController::class, 'getDanhSach'])->name('qldethi_phongthi.danhsach');
          Route::post('qldethi/qldt_pt/xoa', [DeThiPhongThiController::class, 'postXoa'])->name('qldethi_phongthi.xoa');
          Route::post('qldethi/qldt_pt/them/{phongthi_id}', [DeThiPhongThiController::class, 'postThem'])->name('qldethi_phongthi.them');
          Route::post('qldethi/qldt_pt/sua', [DeThiPhongThiController::class, 'postSua'])->name('qldethi_phongthi.sua');
        
         // Quản lý bài thi
      
        Route::get('qlbaithi', [BaiThiController::class, 'getDanhSach'])->name('qlbaithi.danhsach');
        Route::get('qlbaithi/ngaythi_{ngaythi}', [BaiThiController::class, 'getCathi'])->name('qlbaithi.cathi');
        Route::get('qlbaithi/zipNgayThi/{ngaythi}', [ZipController::class, 'zipFile_DLNgayThi'])->name('qlbaithi.zipNgayThi');
        Route::get('qlbaithi/zipCaThi/ngaythi_{ngaythi}/cathi_{cathi}', [ZipController::class, 'zipFile_DLCaThi'])->name('qlbaithi.zipCaThi');
        Route::get('qlbaithi/ngaythi_{ngaythi}/cathi_{cathi}', [BaiThiController::class, 'getPhongthi'])->name('qlbaithi.phongthi');       
        Route::get('qlbaithi/zipPhongThi/ngaythi_{ngaythi}/cathi_{cathi}/phongthi_{phongthi}', [ZipController::class, 'zipFile_DLPhongThi'])->name('qlbaithi.zipPhongThi');

        Route::get('qlbaithi/ketqua/phongthi_{phongthi}', [BaiThiController::class, 'getKetQuaBaiThi'])->name('qlbaithi.ketquabaithi');
        Route::post('ajax', [BaiThiController::class,'postHinhAnhAjax'])->name('qlbaithi.hinhanh.ajax');

        Route::post('lambailai', [BaiThiController::class, 'postLamBaiLai'])->name('qlbaithi.lambailai');
    
        Route::post('zip', [ZipController::class,'zipFile_SVBaiThi'])->name('qlbaithi.zipFile');
        Route::post('zipFile_PhongThi', [ZipController::class,'zipFile_PhongThi'])->name('qlbaithi.zipFile_PhongThi');
        Route::post('suaghichu', [BaiThiController::class, 'postBaiThiSuaGhiChu'])->name('qlbaithi.suaghichu');
        });

       
    
        Route::prefix('qlnguoidung')->name('qlnguoidung.')->middleware(['isAdmin','auth','PreventBackHistory'])->group(function() {
          // Quản lý người dùng sinh viên
          Route::get('qltksinhvien', [UserController::class, 'getDanhSachSV'])->name('qltksinhvien.danhsach');
          Route::post('qltksinhvien/trangthai', [UserController::class, 'postTrangThai'])->name('qltksinhvien.trangthai');
          Route::post('qltksinhvien/them', [UserController::class, 'postThem'])->name('qltksinhvien.them');     
          Route::post('qltksinhvien/xoa', [UserController::class, 'postXoa'])->name('qltksinhvien.xoa');

          Route::post('qltksinhvien/nhap', [UserController::class, 'postNhap'])->name('qltksinhvien.nhap');
         // Route::get('qltksinhvien/xuat', [UserController::class, 'getXuat'])->name('qltksinhvien.xuat');

          // Quản lý người dùng cán bộ coi thi
          Route::get('qltkcanbocoithi', [UserController::class, 'getDanhSachCB'])->name('qltkcanbocoithi.danhsach');
          Route::post('qltkcanbocoithi/trangthai', [UserController::class, 'postTrangThai'])->name('qltkcanbocoithi.trangthai');
          Route::post('qltkcanbocoithi/them', [UserController::class, 'postThem'])->name('qltkcanbocoithi.them');     
          Route::post('qltkcanbocoithi/xoa', [UserController::class, 'postXoa'])->name('qltkcanbocoithi.xoa');
          Route::post('qltkcanbocoithi/nhap', [UserController::class, 'postNhap'])->name('qltkcanbocoithi.nhap');

          Route::post('phanquyen', [UserController::class, 'postPhanQuyen'])->name('phanquyen');

          Route::get('qltkthuky', [UserController::class, 'getDanhSachTK'])->name('qltkthuky.danhsach');
          Route::post('qltkthuky/trangthai', [UserController::class, 'postTrangThai'])->name('qltkthuky.trangthai');
          Route::post('qltkthuky/them', [UserController::class, 'postThem'])->name('qltkthuky.them');     
          Route::post('qltkthuky/xoa', [UserController::class, 'postXoa'])->name('qltkthuky.xoa');
          Route::post('qltkthuky/nhap', [UserController::class, 'postNhap'])->name('qltkthuky.nhap');

          Route::get('qltkhoidongthi', [UserController::class, 'getDanhSachHDT'])->name('qltkhoidongthi.danhsach');
          Route::post('qltkhoidongthi/trangthai', [UserController::class, 'postTrangThai'])->name('qltkhoidongthi.trangthai');
          Route::post('qltkhoidongthi/them', [UserController::class, 'postThem'])->name('qltkhoidongthi.them');     
          Route::post('qltkhoidongthi/xoa', [UserController::class, 'postXoa'])->name('qltkhoidongthi.xoa');
          Route::post('qltkhoidongthi/nhap', [UserController::class, 'postNhap'])->name('qltkhoidongthi.nhap');

        });
          
        
        Route::get('profile',[AdminController::class,'profile'])->name('profile');
    
        Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
        Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
        Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
        
       
});

Route::group(['prefix'=>'sinhvien', 'middleware'=>['isSinhVien','auth','PreventBackHistory']], function(){
    Route::get('/', [SinhVienController::class, 'index'])->name('sinhvien.dashboard');
   
    Route::get('thongbao/moinhat',[ThongBaoController::class,'getThongBaoMoiNhat'])->name('sinhvien.thongbao.moinhat');
    Route::get('thongbao/tatca',[ThongBaoController::class,'TatCaThongBao'])->name('sinhvien.thongbao.tatca');
    Route::get('thongbao/chitiet/{id}',[ThongBaoController::class,'ChiTietThongBao'])->name('sinhvien.thongbao.chitiet');
    Route::get('thongbao/taivanban/{id}',  [VanBanController::class, 'getTaiVanBan'])->name('sinhvien.thongbao.taivanban');
  
    Route::get('nopbai',[SinhVienController::class,'getNopBai'])->name('sinhvien.nopbai');
    Route::post('nopbai/them',[SinhVienController::class,'postThemBaiThi'])->name('sinhvien.nopbai.them');

    Route::get('phongthi/{phongthi_id}',[SinhVienController::class,'getPhongThi'])->name('sinhvien.phongthi');
    Route::get('thamgiadiemdanh/{phongthi_id}',[PhongThiController::class,'getPhongThiDiemDanh'])->name('sinhvien.thamgiadiemdanh');
    
    Route::post('batdaulambai',[BaiThiController::class,'ChonDeThi'])->name('sinhvien.chondethi');
    Route::post('baithi',[BaiThiController::class,'MatKhauCaThi'])->name('sinhvien.matkhaucathi');
    Route::get('lambaithi/{phongthi_id}',[BaiThiController::class,'getLamBaiThi'])->name('sinhvien.lambaithi');

    Route::get('hoanthanh',[BaiThiController::class,'HoanThanh'])->name('sinhvien.hoanthanh');
    Route::post('kethuc',[BaiThiController::class,'KetThuc'])->name('sinhvien.ketthuc');

    
    Route::get('profile',[UserController::class,'profileSV'])->name('sinhvien.profile');
    

    Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('sinhvien.sinhvienUpdateInfo');
    Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('sinhvien.sinhvienPictureUpdate');
   Route::post('change-password',[UserController::class,'changePassword'])->name('sinhvien.sinhvienChangePassword');
});

//giám thị(thư ký + cán bộ coi thi)

Route::group(['prefix'=>'giamthi', 'middleware'=>['isCanBoCoiThi','auth','PreventBackHistory']], function(){
    Route::get('/', [HoiDongThiController::class, 'index'])->name('giamthi.dashboard');
   
    Route::get('thongbao/moinhat',[ThongBaoController::class,'getThongBaoMoiNhat'])->name('giamthi.thongbao.moinhat');
    Route::get('thongbao/tatca',[ThongBaoController::class,'TatCaThongBao'])->name('giamthi.thongbao.tatca');
    Route::get('thongbao/chitiet/{id}',[ThongBaoController::class,'ChiTietThongBao'])->name('giamthi.thongbao.chitiet');
    Route::get('thongbao/taivanban/{id}',  [VanBanController::class, 'getTaiVanBan'])->name('giamthi.thongbao.taivanban');
    Route::post('ghichudiemdanh', [SinhVienPhongThiController::class, 'postGhiChuDiemDanh'])->name('giamthi.ghichudiemdanh');
    Route::post('suaghichu', [BaiThiController::class, 'postBaiThiSuaGhiChu'])->name('giamthi.suaghichu');

    Route::get('thamgiadiemdanh/{phongthi_id}',[PhongThiController::class,'getPhongThiGiamThiDiemDanh'])->name('giamthi.thamgiadiemdanh');
    Route::get('diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getCanBoDiemDanh'])->name('giamthi.diemdanh');
    Route::get('danhsachthisinh/{phongthi_id}',[SinhVienPhongThiController::class,'DanhSachThiSinh'])->name('giamthi.danhsachthisinh');
    
    Route::get('phongthi/{phongthi_id}',[HoiDongThiController::class,'getPhongThi'])->name('giamthi.phongthi');
    Route::post('dethi',[BaiThiController::class,'HDTChonDeThi'])->name('giamthi.chondethi');
    Route::post('xemdethi',[BaiThiController::class,'HDTMatKhauCaThi'])->name('giamthi.matkhaucathi');
    Route::get('dethi/{phongthi_id}',[BaiThiController::class,'getHDTXemDeThi'])->name('giamthi.dethi');

    Route::get('ketquabaithi/{phongthi_id}',[BaiThiController::class,'KetQuaBaiThi'])->name('giamthi.ketquabaithi');

    Route::post('ajax', [BaiThiController::class,'postHinhAnhAjax'])->name('giamthi.hinhanh.ajax');
    
    Route::post('lambailai', [BaiThiController::class, 'postLamBaiLai'])->name('giamthi.lambailai');
    Route::post('zip', [ZipController::class,'zipFile_SVBaiThi'])->name('giamthi.zipFile');
    Route::post('zipFile_PhongThi', [ZipController::class,'zipFile_PhongThi'])->name('giamthi.zipFile_PhongThi');


    Route::get('profile',[UserController::class,'profileGiamThi'])->name('giamthi.profile');
    

    Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('giamthi.giamthiUpdateInfo');
    Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('giamthi.giamthiPictureUpdate');
   Route::post('change-password',[UserController::class,'changePassword'])->name('giamthi.giamthiChangePassword');

});




