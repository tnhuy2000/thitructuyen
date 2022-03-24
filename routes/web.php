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
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZipController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});

// Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'getHome'])->name('frontend');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Google OAuth
Route::get('/login/google', [HomeController::class, 'getGoogleLogin'])->name('google.login');
Route::get('/login/google/callback', [HomeController::class, 'getGoogleCallback'])->name('google.callback');

Route::prefix('admin')->name('admin.')->middleware(['isAdmin','auth','PreventBackHistory'])->group(function() {
// Route::group(['prefix'=>'admin','name'=>'admin.', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
    
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');

        Route::get('dashboard',[AdminController::class,'index'])->name('dashboard');
        /*
        Route::get('profile',[AdminController::class,'profile'])->name('profile');
        Route::get('settings',[AdminController::class,'settings'])->name('settings');

        Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
        Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
        Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
        */
        
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
        Route::get('qllop/xoa/{malop}', [LopController::class, 'getXoa'])->name('qllop.xoa');

        Route::post('qllop/nhap', [LopController::class, 'postNhap'])->name('qllop.nhap');
        Route::get('qllop/xuat', [LopController::class, 'getXuat'])->name('qllop.xuat');
        
        // Quản lý sinh viên
        Route::get('qlsinhvien', [SinhVienController::class, 'getDanhSach'])->name('qlsinhvien.danhsach');
        Route::get('qlsinhvien/them', [SinhVienController::class, 'getThem'])->name('qlsinhvien.them');
        Route::post('qlsinhvien/them', [SinhVienController::class, 'postThem'])->name('qlsinhvien.them');
        Route::get('qlsinhvien/sua/{masinhvien}', [SinhVienController::class, 'getSua'])->name('qlsinhvien.sua');
        Route::post('qlsinhvien/sua/{masinhvien}', [SinhVienController::class, 'postSua'])->name('qlsinhvien.sua');       
        Route::get('qlsinhvien/xoa/{masinhvien}', [SinhVienController::class, 'getXoa'])->name('qlsinhvien.xoa');

        Route::post('qlsinhvien/nhap', [SinhVienController::class, 'postNhap'])->name('qlsinhvien.nhap');
        Route::get('qlsinhvien/xuat', [SinhVienController::class, 'getXuat'])->name('qlsinhvien.xuat');
        
        // Quản lý hoidongthi
        Route::get('qlhoidongthi', [HoiDongThiController::class, 'getDanhSach'])->name('qlhoidongthi.danhsach');
        Route::get('qlhoidongthi/them', [HoiDongThiController::class, 'getThem'])->name('qlhoidongthi.them');
        Route::post('qlhoidongthi/them', [HoiDongThiController::class, 'postThem'])->name('qlhoidongthi.them');
        Route::get('qlhoidongthi/sua/{macanbo}', [HoiDongThiController::class, 'getSua'])->name('qlhoidongthi.sua');
        Route::post('qlhoidongthi/sua/{macanbo}', [HoiDongThiController::class, 'postSua'])->name('qlhoidongthi.sua');       
        Route::get('qlhoidongthi/xoa/{macanbo}', [HoiDongThiController::class, 'getXoa'])->name('qlhoidongthi.xoa');

        Route::post('qlhoidongthi/nhap', [HoiDongThiController::class, 'postNhap'])->name('qlhoidongthi.nhap');
        Route::get('qlhoidongthi/xuat', [HoiDongThiController::class, 'getXuat'])->name('qlhoidongthi.xuat');
        
        // Quản lý học phần
        Route::get('qlhocphan', [HocPhanController::class, 'getDanhSach'])->name('qlhocphan.danhsach');
        Route::get('qlhocphan/them', [HocPhanController::class, 'getThem'])->name('qlhocphan.them');
        Route::post('qlhocphan/them', [HocPhanController::class, 'postThem'])->name('qlhocphan.them');
        Route::get('qlhocphan/sua/{mahocphan}', [HocPhanController::class, 'getSua'])->name('qlhocphan.sua');
        Route::post('qlhocphan/sua/{mahocphan}', [HocPhanController::class, 'postSua'])->name('qlhocphan.sua');       
        Route::get('qlhocphan/xoa/{mahocphan}', [HocPhanController::class, 'getXoa'])->name('qlhocphan.xoa');

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
        Route::get('qlkythi/xoa/{id}', [KyThiController::class, 'getXoa'])->name('qlkythi.xoa');
        
         // Quản lý ca thi
         Route::get('qlcathi', [CaThiController::class, 'getDanhSach'])->name('qlcathi.danhsach');
         Route::get('qlcathi/them', [CaThiController::class, 'getThem'])->name('qlcathi.them');
         Route::post('qlcathi/them', [CaThiController::class, 'postThem'])->name('qlcathi.them');
         Route::get('qlcathi/sua/{id}', [CaThiController::class, 'getSua'])->name('qlcathi.sua');
         Route::post('qlcathi/sua/{id}', [CaThiController::class, 'postSua'])->name('qlcathi.sua');       
         Route::get('qlcathi/xoa/{id}', [CaThiController::class, 'getXoa'])->name('qlcathi.xoa');
         Route::post('qlcathi/nhap', [CaThiController::class, 'postNhap'])->name('qlcathi.nhap');
         Route::post('qlcathi/xuat', [CaThiController::class, 'postXuat'])->name('qlcathi.xuat');

          // Quản lý phòng thi
          Route::get('qlphongthi', [PhongThiController::class, 'getDanhSach'])->name('qlphongthi.danhsach');
          Route::get('qlphongthi/them', [PhongThiController::class, 'getThem'])->name('qlphongthi.them');
          Route::post('qlphongthi/them', [PhongThiController::class, 'postThem'])->name('qlphongthi.them');
          Route::get('qlphongthi/sua/{id}', [PhongThiController::class, 'getSua'])->name('qlphongthi.sua');
          Route::post('qlphongthi/sua/{id}', [PhongThiController::class, 'postSua'])->name('qlphongthi.sua');       
          Route::get('qlphongthi/xoa/{id}', [PhongThiController::class, 'getXoa'])->name('qlphongthi.xoa');

          Route::post('qlphongthi/nhap', [PhongThiController::class, 'postNhap'])->name('qlphongthi.nhap');

          //sinh vien phong thi
          Route::get('qlsv_pt/all', [SinhVienPhongThiController::class, 'getAllDanhSach'])->name('qlsv_pt.all');
          Route::get('qlsv_pt/{id}', [SinhVienPhongThiController::class, 'getDanhSach'])->name('qlsv_pt.danhsach');
          Route::post('qlsv_pt/xoa', [SinhVienPhongThiController::class, 'postXoa'])->name('qlsv_pt.xoa');
          Route::post('qlsv_pt/them/{phongthi_id}', [SinhVienPhongThiController::class, 'postThem'])->name('qlsv_pt.them');
          Route::post('qlsv_pt/sua', [SinhVienPhongThiController::class, 'postSua'])->name('qlsv_pt.sua');

          Route::get('qlsv_pt/diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getDiemDanh'])->name('qlsv_pt.diemdanh');

          Route::post('qlsv_pt/nhap/{phongthi_id}', [SinhVienPhongThiController::class, 'postNhap'])->name('qlsv_pt.nhap');
          Route::get('qlsv_pt/xuat/{phongthi_id}', [SinhVienPhongThiController::class, 'getXuat'])->name('qlsv_pt.xuat');


          //hoi dong thi phong thi
          Route::get('qlhdt_pt/all', [HoiDongThiPhongThiController::class, 'getAllDanhSach'])->name('qlhdt_pt.all');
          Route::get('qlhdt_pt/{id}', [HoiDongThiPhongThiController::class, 'getDanhSach'])->name('qlhdt_pt.danhsach');

          Route::post('qlhdt_pt/xoa', [HoiDongThiPhongThiController::class, 'postXoa'])->name('qlhdt_pt.xoa');
          Route::post('qlhdt_pt/them/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postThem'])->name('qlhdt_pt.them');
          Route::post('qlhdt_pt/sua', [HoiDongThiPhongThiController::class, 'postSua'])->name('qlhdt_pt.sua');

          Route::post('qlhdt_pt/nhap/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postNhap'])->name('qlhdt_pt.nhap');
          Route::get('qlhdt_pt/xuat/{phongthi_id}', [HoiDongThiPhongThiController::class, 'getXuat'])->name('qlhdt_pt.xuat');
        });
          Route::prefix('dethi_baithi')->name('dethi_baithi.')->group(function() {
          // Quản lý đề thi
          Route::get('qldethi', [DeThiController::class, 'getDanhSach'])->name('qldethi.danhsach');
          Route::get('qldethi/them', [DeThiController::class, 'getThem'])->name('qldethi.them');
          Route::post('qldethi/them', [DeThiController::class, 'postThem'])->name('qldethi.them');
          Route::get('qldethi/sua/{id}', [DeThiController::class, 'getSua'])->name('qldethi.sua');
          Route::post('qldethi/sua/{id}', [DeThiController::class, 'postSua'])->name('qldethi.sua');       
          Route::get('qldethi/xoa/{id}', [DeThiController::class, 'getXoa'])->name('qldethi.xoa');

          Route::get('qldethi/dulieudethi/{id}', [DeThiController::class, 'getDuLieuDeThi'])->name('qldethi.dulieudethi');
          
        //mới
          Route::get('qldulieudethi/{id}', [DuLieuDeThiController::class, 'getDanhSachDuLieu'])->name('qldulieudethi.danhsach');
          Route::post('qldulieudethi/themmoi/{dethi_id}', [DuLieuDeThiController::class, 'postThemMoi'])->name('qldulieudethi.themmoi');
          Route::post('qldulieudethi/sua', [DuLieuDeThiController::class, 'postSua'])->name('qldulieudethi.sua');
          Route::post('qldulieudethi/xoa', [DuLieuDeThiController::class, 'postXoa'])->name('qldulieudethi.xoa');
          Route::post('qldulieudethi/ajax', [DuLieuDeThiController::class, 'postHinhAnhAjax'])->name('qldulieudethi.ajax');

        //ql đề thi-phong thi
          Route::get('qldt_pt/{id}', [DeThiPhongThiController::class, 'getDanhSach'])->name('qldethi_phongthi.danhsach');
          Route::post('qldt_pt/xoa', [DeThiPhongThiController::class, 'postXoa'])->name('qldethi_phongthi.xoa');
          Route::post('qldt_pt/them/{phongthi_id}', [DeThiPhongThiController::class, 'postThem'])->name('qldethi_phongthi.them');
          Route::post('qldt_pt/sua', [DeThiPhongThiController::class, 'postSua'])->name('qldethi_phongthi.sua');
        
         // Quản lý bài thi
        Route::get('qlbaithi', [BaiThiController::class, 'getDanhSach'])->name('qlbaithi.danhsach');
        Route::get('qlbaithi/ngaythi_{ngaythi}', [BaiThiController::class, 'getCathi'])->name('qlbaithi.cathi');
        Route::get('qlbaithi/zipNgayThi/{ngaythi}', [ZipController::class, 'zipFile_DLNgayThi'])->name('qlbaithi.zipNgayThi');
        Route::get('qlbaithi/zipCaThi/ngaythi_{ngaythi}/cathi_{cathi}', [ZipController::class, 'zipFile_DLCaThi'])->name('qlbaithi.zipCaThi');
        Route::get('qlbaithi/ngaythi_{ngaythi}/cathi_{cathi}', [BaiThiController::class, 'getPhongthi'])->name('qlbaithi.phongthi');       
        Route::get('qlbaithi/zipPhongThi/ngaythi_{ngaythi}/cathi_{cathi}/phongthi_{phongthi}', [ZipController::class, 'zipFile_DLPhongThi'])->name('qlbaithi.zipPhongThi');
        });

       

        Route::prefix('qlnguoidung')->name('qlnguoidung.')->group(function() {
          // Quản lý người dùng sinh viên
          Route::get('qltksinhvien', [UserController::class, 'getDanhSachSV'])->name('qltksinhvien.danhsach');
          Route::get('qltksinhvien/{id}/trangthai/{trangthai}', [UserController::class, 'getTrangThai'])->name('qltksinhvien.trangthai');
          Route::post('qltksinhvien/them', [UserController::class, 'postThem'])->name('qltksinhvien.them');     
          Route::get('qltksinhvien/xoa/{id}', [UserController::class, 'getXoa'])->name('qltksinhvien.xoa');

          Route::post('qltksinhvien/nhap', [UserController::class, 'postNhap'])->name('qltksinhvien.nhap');
         // Route::get('qltksinhvien/xuat', [UserController::class, 'getXuat'])->name('qltksinhvien.xuat');

          // Quản lý người dùng cán bộ coi thi
          Route::get('qltkcanbocoithi', [UserController::class, 'getDanhSachCB'])->name('qltkcanbocoithi.danhsach');
          Route::get('qltkcanbocoithi/{id}/trangthai/{trangthai}', [UserController::class, 'getTrangThai'])->name('qltkcanbocoithi.trangthai');
          Route::post('qltkcanbocoithi/them', [UserController::class, 'postThem'])->name('qltkcanbocoithi.them');     
          Route::get('qltkcanbocoithi/xoa/{id}', [UserController::class, 'getXoa'])->name('qltkcanbocoithi.xoa');
          Route::post('qltkcanbocoithi/nhap', [UserController::class, 'postNhap'])->name('qltkcanbocoithi.nhap');

          Route::get('qltkthuky', [UserController::class, 'getDanhSachTK'])->name('qltkthuky.danhsach');
          Route::get('qltkthuky/{id}/trangthai/{trangthai}', [UserController::class, 'getTrangThai'])->name('qltkthuky.trangthai');
          Route::post('qltkthuky/them', [UserController::class, 'postThem'])->name('qltkthuky.them');     
          Route::get('qltkthuky/xoa/{id}', [UserController::class, 'getXoa'])->name('qltkthuky.xoa');
          Route::post('qltkthuky/nhap', [UserController::class, 'postNhap'])->name('qltkthuky.nhap');

          Route::get('qltkhoidongthi', [UserController::class, 'getDanhSachHDT'])->name('qltkhoidongthi.danhsach');
          Route::get('qltkhoidongthi/{id}/trangthai/{trangthai}', [UserController::class, 'getTrangThai'])->name('qltkhoidongthi.trangthai');
          Route::post('qltkhoidongthi/them', [UserController::class, 'postThem'])->name('qltkhoidongthi.them');     
          Route::get('qltkhoidongthi/xoa/{id}', [UserController::class, 'getXoa'])->name('qltkhoidongthi.xoa');
          Route::post('qltkhoidongthi/nhap', [UserController::class, 'postNhap'])->name('qltkhoidongthi.nhap');

        });
          
          /*
        Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
        Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
        Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
       */
});

Route::group(['prefix'=>'sinhvien', 'middleware'=>['isSinhVien','auth','PreventBackHistory']], function(){
    Route::get('/', [SinhVienController::class, 'index'])->name('sinhvien.dashboard');
   
    Route::get('dashboard',[SinhVienController::class,'index'])->name('dashboard');
    Route::get('nopbai',[SinhVienController::class,'getNopBai'])->name('sinhvien.nopbai');
    Route::post('nopbai/them',[SinhVienController::class,'postThemBaiThi'])->name('sinhvien.nopbai.them');

    Route::get('phongthi/{phongthi_id}',[SinhVienController::class,'getPhongThi'])->name('sinhvien.phongthi');
    Route::get('thamgiadiemdanh/{phongthi_id}',[PhongThiController::class,'getPhongThiDiemDanh'])->name('sinhvien.thamgiadiemdanh');
    
    Route::post('batdaulambai',[BaiThiController::class,'ChonDeThi'])->name('sinhvien.chondethi');
    Route::post('baithi',[BaiThiController::class,'MatKhauCaThi'])->name('sinhvien.matkhaucathi');
    Route::get('lambaithi/{phongthi_id}',[BaiThiController::class,'getLamBaiThi'])->name('sinhvien.lambaithi');

    Route::get('hoanthanh',[BaiThiController::class,'HoanThanh'])->name('sinhvien.hoanthanh');
    Route::post('kethuc',[BaiThiController::class,'KetThuc'])->name('sinhvien.ketthuc');
    //Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    //Route::get('settings',[UserController::class,'settings'])->name('user.settings');

    //Route::post('update-profile-info',[UserController::class,'updateInfo'])->name('userUpdateInfo');
    //Route::post('change-profile-picture',[UserController::class,'updatePicture'])->name('userPictureUpdate');
   // Route::post('change-password',[UserController::class,'changePassword'])->name('userChangePassword');
});
   //hội đồng thi(giám thị)
Route::group(['prefix'=>'canbocoithi', 'middleware'=>['isCanBoCoiThi','auth','PreventBackHistory']], function(){
    Route::get('/', [HoiDongThiController::class, 'index'])->name('canbocoithi.dashboard');
   
    Route::get('dashboard',[HoiDongThiController::class,'index'])->name('dashboard');


    Route::post('suaghichu', [BaiThiController::class, 'postBaiThiSuaGhiChu'])->name('canbocoithi.suaghichu');

    Route::get('diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getCanBoDiemDanh'])->name('canbocoithi.diemdanh');
    Route::get('danhsachthisinh/{phongthi_id}',[SinhVienPhongThiController::class,'DanhSachThiSinh'])->name('canbocoithi.danhsachthisinh');
    
    Route::get('phongthi/{phongthi_id}',[HoiDongThiController::class,'getPhongThi'])->name('canbocoithi.phongthi');
    Route::post('dethi',[BaiThiController::class,'HDTChonDeThi'])->name('canbocoithi.chondethi');
    Route::post('xemdethi',[BaiThiController::class,'HDTMatKhauCaThi'])->name('canbocoithi.matkhaucathi');
    Route::get('dethi/{phongthi_id}',[BaiThiController::class,'getHDTXemDeThi'])->name('canbocoithi.dethi');


    Route::get('ketquabaithi/{phongthi_id}',[BaiThiController::class,'KetQuaBaiThi'])->name('canbocoithi.ketquabaithi');
    Route::post('ajax', [BaiThiController::class,'postHinhAnhAjax'])->name('canbocoithi.hinhanh.ajax');

});

Route::group(['prefix'=>'thuky', 'middleware'=>['isThuKy','auth','PreventBackHistory']], function(){
    Route::get('/', [HoiDongThiController::class, 'index'])->name('thuky.dashboard');
   
    Route::get('dashboard',[HoiDongThiController::class,'index'])->name('dashboard');


    Route::post('suaghichu', [BaiThiController::class, 'postBaiThiSuaGhiChu'])->name('thuky.suaghichu');

    Route::get('diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getCanBoDiemDanh'])->name('thuky.diemdanh');
    Route::get('danhsachthisinh/{phongthi_id}',[SinhVienPhongThiController::class,'DanhSachThiSinh'])->name('thuky.danhsachthisinh');
    
    Route::get('phongthi/{phongthi_id}',[HoiDongThiController::class,'getPhongThi'])->name('thuky.phongthi');
    Route::post('dethi',[BaiThiController::class,'HDTChonDeThi'])->name('thuky.chondethi');
    Route::post('xemdethi',[BaiThiController::class,'HDTMatKhauCaThi'])->name('thuky.matkhaucathi');
    Route::get('dethi/{phongthi_id}',[BaiThiController::class,'getHDTXemDeThi'])->name('thuky.dethi');

    Route::get('ketquabaithi/{phongthi_id}',[BaiThiController::class,'KetQuaBaiThi'])->name('thuky.ketquabaithi');
    Route::post('ajax', [BaiThiController::class,'postHinhAnhAjax'])->name('thuky.hinhanh.ajax');
    Route::post('zip', [ZipController::class,'zipFile_SVBaiThi'])->name('thuky.zipFile');
    Route::post('zipFile_PhongThi', [ZipController::class,'zipFile_PhongThi'])->name('thuky.zipFile_PhongThi');


});

Route::group(['prefix'=>'hoidongthi', 'middleware'=>['isHoiDongThi','auth','PreventBackHistory']], function(){
    
    Route::get('/', [AdminController::class, 'getHoiDongThi'])->name('hoidongthi.dashboard');

    Route::get('dashboard',[AdminController::class,'getHoiDongThi'])->name('hoidongthi.dashboard');
    
    //Sắp phòng

    // Quản lý kỳ thi
    Route::get('qlkythi', [KyThiController::class, 'getDanhSach'])->name('hoidongthi.qlkythi.danhsach');
    Route::get('qlkythi/them', [KyThiController::class, 'getThem'])->name('hoidongthi.qlkythi.them');
    Route::post('qlkythi/them', [KyThiController::class, 'postThem'])->name('hoidongthi.qlkythi.them');
    Route::get('qlkythi/sua/{id}', [KyThiController::class, 'getSua'])->name('hoidongthi.qlkythi.sua');
    Route::post('qlkythi/sua/{id}', [KyThiController::class, 'postSua'])->name('hoidongthi.qlkythi.sua');       
    Route::get('qlkythi/xoa/{id}', [KyThiController::class, 'getXoa'])->name('hoidongthi.qlkythi.xoa');
    
     // Quản lý ca thi
     Route::get('qlcathi', [CaThiController::class, 'getDanhSach'])->name('hoidongthi.qlcathi.danhsach');
     Route::get('qlcathi/them', [CaThiController::class, 'getThem'])->name('hoidongthi.qlcathi.them');
     Route::post('qlcathi/them', [CaThiController::class, 'postThem'])->name('hoidongthi.qlcathi.them');
     Route::get('qlcathi/sua/{id}', [CaThiController::class, 'getSua'])->name('hoidongthi.qlcathi.sua');
     Route::post('qlcathi/sua/{id}', [CaThiController::class, 'postSua'])->name('hoidongthi.qlcathi.sua');       
     Route::get('qlcathi/xoa/{id}', [CaThiController::class, 'getXoa'])->name('hoidongthi.qlcathi.xoa');
     

      // Quản lý phòng thi
      Route::get('qlphongthi', [PhongThiController::class, 'getDanhSach'])->name('hoidongthi.qlphongthi.danhsach');
      Route::get('qlphongthi/them', [PhongThiController::class, 'getThem'])->name('hoidongthi.qlphongthi.them');
      Route::post('qlphongthi/them', [PhongThiController::class, 'postThem'])->name('hoidongthi.qlphongthi.them');
      Route::get('qlphongthi/sua/{id}', [PhongThiController::class, 'getSua'])->name('hoidongthi.qlphongthi.sua');
      Route::post('qlphongthi/sua/{id}', [PhongThiController::class, 'postSua'])->name('hoidongthi.qlphongthi.sua');       
      Route::get('qlphongthi/xoa/{id}', [PhongThiController::class, 'getXoa'])->name('v.qlphongthi.xoa');

      //sinh vien phong thi
      Route::get('qlsv_pt/{id}', [SinhVienPhongThiController::class, 'getDanhSach'])->name('hoidongthi.qlsv_pt.danhsach');
      Route::post('qlsv_pt/xoa', [SinhVienPhongThiController::class, 'postXoa'])->name('v.qlsv_pt.xoa');
      Route::post('qlsv_pt/them/{phongthi_id}', [SinhVienPhongThiController::class, 'postThem'])->name('hoidongthi.qlsv_pt.them');
      Route::post('qlsv_pt/suaghichu', [SinhVienPhongThiController::class, 'postSuaGhiChu'])->name('hoidongthi.qlsv_pt.suaghichu');

      Route::get('qlsv_pt/diemdanh/{id}/{phongthi_id}', [SinhVienPhongThiController::class, 'getDiemDanh'])->name('hoidongthi.qlsv_pt.diemdanh');

      Route::post('qlsv_pt/nhap/{phongthi_id}', [SinhVienPhongThiController::class, 'postNhap'])->name('hoidongthi.qlsv_pt.nhap');
      Route::get('qlsv_pt/xuat/{phongthi_id}', [SinhVienPhongThiController::class, 'getXuat'])->name('hoidongthi.qlsv_pt.xuat');


      //hoi dong thi phong thi
      Route::get('qlhdt_pt/{id}', [HoiDongThiPhongThiController::class, 'getDanhSach'])->name('hoidongthi.qlhdt_pt.danhsach');

      Route::post('qlhdt_pt/xoa', [HoiDongThiPhongThiController::class, 'postXoa'])->name('hoidongthi.qlhdt_pt.xoa');
      Route::post('qlhdt_pt/them/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postThem'])->name('hoidongthi.qlhdt_pt.them');
      Route::post('qlhdt_pt/suaghichu', [HoiDongThiPhongThiController::class, 'postSuaGhiChu'])->name('hoidongthi.qlhdt_pt.suaghichu');

      //Route::get('qlhdt_pt/diemdanh/{id}/{phongthi_id}', [HoiDongThiPhongThiController::class, 'getDiemDanh'])->name('qlhdt_pt.diemdanh');

      Route::post('qlhdt_pt/nhap/{phongthi_id}', [HoiDongThiPhongThiController::class, 'postNhap'])->name('hoidongthi.qlhdt_pt.nhap');
      Route::get('qlhdt_pt/xuat/{phongthi_id}', [HoiDongThiPhongThiController::class, 'getXuat'])->name('hoidongthi.qlhdt_pt.xuat');



      // Quản lý đề thi
      Route::get('qldethi', [DeThiController::class, 'getDanhSach'])->name('hoidongthi.qldethi.danhsach');
      Route::get('qldethi/them', [DeThiController::class, 'getThem'])->name('hoidongthi.qldethi.them');
      Route::post('qldethi/them', [DeThiController::class, 'postThem'])->name('hoidongthi.qldethi.them');
      Route::get('qldethi/sua/{id}', [DeThiController::class, 'getSua'])->name('hoidongthi.qldethi.sua');
      Route::post('qldethi/sua/{id}', [DeThiController::class, 'postSua'])->name('hoidongthi.qldethi.sua');       
      Route::get('qldethi/xoa/{id}', [DeThiController::class, 'getXoa'])->name('hoidongthi.qldethi.xoa');

     
    //mới
      Route::get('qldulieudethi/{id}', [DuLieuDeThiController::class, 'getDanhSachDuLieu'])->name('hoidongthi.qldulieudethi.danhsach');
      Route::post('qldulieudethi/themmoi/{dethi_id}', [DuLieuDeThiController::class, 'postThemMoi'])->name('hoidongthi.qldulieudethi.themmoi');
      Route::post('qldulieudethi/sua', [DuLieuDeThiController::class, 'postSua'])->name('hoidongthi.qldulieudethi.sua');
      Route::post('qldulieudethi/xoa', [DuLieuDeThiController::class, 'postXoa'])->name('hoidongthi.qldulieudethi.xoa');
      Route::post('qldulieudethi/ajax', [DuLieuDeThiController::class, 'postHinhAnhAjax'])->name('hoidongthi.qldulieudethi.ajax');

    //ql đề thi-phong thi
      Route::get('qldethi_phongthi/{id}', [DeThiPhongThiController::class, 'getDanhSach'])->name('hoidongthi.qldethi_phongthi.danhsach');
      Route::post('qldethi_phongthi/xoa', [DeThiPhongThiController::class, 'postXoa'])->name('hoidongthi.qldethi_phongthi.xoa');
      Route::post('qldethi_phongthi/them/{phongthi_id}', [DeThiPhongThiController::class, 'postThem'])->name('hoidongthi.qldethi_phongthi.them');
      Route::post('qldethi_phongthi/sua', [DeThiPhongThiController::class, 'postSua'])->name('hoidongthi.qldethi_phongthi.sua');


      

});


