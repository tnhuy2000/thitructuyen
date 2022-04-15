<?php

namespace App\Http\Controllers;

use App\Models\VanBan;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class VanBanController extends Controller
{
    public function getDanhSach($id)
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$path = config('app.url') . '/storage/app/file/posts/' . str_pad($id, 7, '0', STR_PAD_LEFT) . '/';
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = 'Files';
		
		$thongbao = ThongBao::where('id', $id)->first();
		$vanban = VanBan::where('thongbao_id', $id)->get();
	
		return view('admin.thongbao.vanban', compact('thongbao', 'vanban'));
	}
	
	public function postThem(Request $request)
	{
		$rules = array();
		$rules['tenvanban'] = 'required|string';
		$rules['duongdan'] = 'required';
		$this->validate($request, $rules);
		
		$orm = new VanBan();
		$orm->thongbao_id = $request->thongbao_id;
		$orm->tenvanban = $request->tenvanban;
		$orm->tenvanbankhongdau = Str::slug($request->tenvanban, '-');
		$orm->duongdan = $request->duongdan;
		$orm->save();
		toastr()->success('Thêm dữ liệu thành công!');
		return redirect()->route('admin.thongbao.vanban', ['id' => $request->thongbao_id]);
	}
	
	public function postSua(Request $request)
	{
		$rules = array();
		$rules['tenvanban_edit'] = 'required|string';
		$rules['duongdan_edit'] = 'required';
		$this->validate($request, $rules);
		
		$orm = VanBan::find($request->id_edit);
		$orm->tenvanban = $request->tenvanban_edit;
		$orm->tenvanbankhongdau = Str::slug($request->tenvanban_edit, '-');
		$orm->duongdan = $request->duongdan_edit;
		$orm->save();
		toastr()->success('Cập nhật dữ liệu thành công!');
		return redirect()->route('admin.thongbao.vanban', ['id' => $request->thongbao_id_edit]);
	}
	
	public function getSuaNhanh()
	{
		$vanban = VanBan::where('kiemduyet', 0)
			->orderBy('thongbao_id', 'desc')
			->limit(10)->get();
		return view('admin.thongbao.suanhanh_vanban', compact('vanban'));
	}
	
	public function postSuaNhanh(Request $request)
	{
		foreach($request->id as $value)
		{
			$orm = VanBan::find($value);
			$orm->tenvanban = $request->tenvanban[$value];
			$orm->tenvanbankhongdau = Str::slug($request->tenvanban[$value], '-');
			$orm->duongdan = $request->duongdan[$value];
			$orm->kiemduyet = 1;
			$orm->save();
		}
		return redirect()->route('admin.thongbao.danhsach')->with('status', 'Đã cập nhật nhanh các văn bản kèm theo bài viết.');
	}
	
	public function postXoa(Request $request)
	{
		$orm = VanBan::find($request->id_delete);
		$orm->delete();
		toastr()->success('Xoá dữ liệu thành công!');
		return redirect()->route('admin.thongbao.vanban', ['id' => $request->thongbao_id_delete]);
	}
	
	public function getKichHoat($idthongbao, $id)
	{
		$orm = VanBan::find($id);
		$orm->kichhoat = 1 - $orm->kichhoat;
		$orm->save();
		
		return redirect()->route('admin.thongbao.vanban', ['id' => $idthongbao]);
	}
	
	public function postVanBanAjax(Request $request)
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$path = config('app.url') . '/storage/app/file/posts/' . str_pad($request->id, 7, '0', STR_PAD_LEFT) . '/';
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = 'Files';
		
		return 1;
	}
	public function getTaiVanBan(Request $request)
	{
	
		$thongbao_vanban = VanBan::where('id', $request->id)
			->firstOrFail();
		$file_path = config('app.url') . '/storage/app/file/posts/' . str_pad($thongbao_vanban->thongbao_id, 7, '0', STR_PAD_LEFT) . '/';
		$file = $file_path . $thongbao_vanban->duongdan;
		
		// Cập nhật lượt download
		// Chính sách: 1 máy chỉ tăng 1 lần
		$idXem = 'VB' . $request->id;
		if(!session()->has($idXem))
		{
			$orm = VanBan::find($request->id);
			$orm->luotdownload = $thongbao_vanban->luotdownload + 1;
			$orm->save();
			session()->put($idXem, 1);
		}
		
		return redirect($file);
	}
	
}
