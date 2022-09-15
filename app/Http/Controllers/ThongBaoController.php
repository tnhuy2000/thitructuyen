<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use App\Models\VanBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
class ThongBaoController extends Controller
{
	
	public function getTatCaThongBao()
    {
		$thongbao = DB::table('thongbao')->orderBy('created_at', 'desc')
                                            ->orderBy('quantrong', 'desc')->get();
		return view('admin.thongbao.tatca',compact('thongbao'));
    }
	public function getChiTietThongBao($id)
    {
		$thongbao = ThongBao::where('id', $id)->first();
		$vanban = VanBan::where('thongbao_id', $id)->get();
		return view('admin.thongbao.chitiet',compact('thongbao','vanban'));
    }
    public function getDanhSach()
    {
		$thongbao = DB::table('thongbao')->orderBy('created_at', 'desc')
                                            ->orderBy('quantrong', 'desc')->get();
		return view('admin.thongbao.danhsach',compact('thongbao'));
    }

    public function getThem()
	{
		if(session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$thongbao_identity = DB::select("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . config('database.connections.mysql.database') . "' AND TABLE_NAME = 'thongbao'");
		$next_id = $thongbao_identity[0]->AUTO_INCREMENT;
		Storage::makeDirectory('file/posts/' . str_pad($next_id, 7, '0', STR_PAD_LEFT), 0775);
		
		$path = config('app.url') . '/storage/app/file/posts/' . str_pad($next_id, 7, '0', STR_PAD_LEFT) . '/';
		if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
		$_SESSION['ckAuth'] = true;
		if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
		$_SESSION['baseUrl'] = $path;
		if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
		$_SESSION['resourceType'] = '*';
		
		return view('admin.thongbao.them');
	}
	
	public function postThem(Request $request)
	{
		$rules = array();
        $rules['loai'] = 'required';
		$rules['tieude'] = 'required|string|unique:thongbao';
		$rules['noidung'] = 'required';
		if($request->MaLoai == 2) $rules['dinhkem'] = 'required';
		
		$this->validate($request, $rules);
		
		$orm = new ThongBao();
		$orm->loai = $request->loai;
		$orm->tieude = $request->tieude;
		$orm->noidung = $request->noidung;
	
		if(!empty($request->quantrong)) $orm->quantrong = $request->quantrong;
		$orm->save();
		
		if($request->loai == 'dinhkem' && isset($request->dinhkem))
		{
			$thongbao_id = $orm->id;
			$index = 0;
			foreach($request->dinhkem as $value)
			{
				if(!empty($value))
				{
					$vb = new VanBan();
					$vb->thongbao_id = $thongbao_id;
					$vb->tenvanban = $request->tenvanban[$index];
					$vb->tenvanbankhongdau = Str::slug($request->tenvanban[$index], '-');
					$vb->duongdan = $value;
					$vb->save();
					$index++;
				}
			}
		}
		toastr()->success('Thêm dữ liệu thành công!');
		return redirect()->route('admin.thongbao.danhsach');
	}
	
	public function getSua($id)
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
		
		return view('admin.thongbao.sua', compact('thongbao'));
	}
	
	public function postSua(Request $request, $id)
	{
		$rules = array();
		$rules['loai'] = 'required';
		$rules['tieude'] = 'required|string|unique:thongbao,tieude,' . $request->id . ',id';
		$rules['noidung'] = 'required';
		$this->validate($request, $rules);
		
		$orm = ThongBao::find($request->id);
		$orm->loai = $request->loai;
		$orm->tieude = $request->tieude;
		$orm->noidung = $request->noidung;
		$orm->quantrong = empty($request->quantrong) ? 0 : 1;
		$orm->save();
		toastr()->success('Cập nhật dữ liệu thành công');
		if($request->loai == 'dinhkem')
			return redirect()->route('admin.thongbao.vanban', ['id' => $request->id]);
		else
			return redirect()->route('admin.thongbao.danhsach');
	}
	
	
	
	public function postXoa(Request $request)
	{
		try { 
			$isExistHDT = VanBan::select('*')
            ->where('thongbao_id', $request->ID_delete)
            ->doesntExist();
			
			if($isExistHDT==false){
				VanBan::where('thongbao_id', $request->ID_delete)->delete();
			} 
			ThongBao::where('id', $request->ID_delete)->delete();
           
            Storage::deleteDirectory('file/posts/' . str_pad($request->ID_delete, 7, '0', STR_PAD_LEFT));
			toastr()->success('Xoá dữ liệu thành công!');
			return redirect()->route('admin.thongbao.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.thongbao.danhsach');
        }
		
		
	}
	
	public function getquantrong($id)
	{
		$orm = ThongBao::find($id);
		$orm->quantrong = 1 - $orm->quantrong;
		$orm->save();
		
		return redirect()->route('admin.thongbao.danhsach');
	}
	
	public function getkichhoat($id)
	{
		$orm = ThongBao::find($id);
		$orm->kichhoat = 1 - $orm->kichhoat;
		$orm->save();
		
		return redirect()->route('admin.thongbao.danhsach');
	}
	public function getThongBao($loai = '')
	{
		$no_image = config('app.url') . '/public/img/no-image.jpg';
		if(empty($loai))
		{
			$session_title = 'Tất cả bài viết';
			$thongbao = ThongBao::where([['kichhoat', 1], ['loai', '=', 'dinhkem']])
				->orderBy('quantrong', 'desc')
				->orderBy('created_at', 'desc')
				->paginate(20);
		}
		else
		{
			// $loai = loai::where('TenloaiKhongDau', $loai)->firstOrFail();
			$thongbao = ThongBao::where([['kichhoat', 1], ['loai', $loai]])
				->orderBy('quantrong', 'desc')
				->orderBy('created_at', 'desc')
				->paginate(20);
		}
		
		$thongbao_first_file = array();
		foreach($thongbao as $value)
		{
			$thongbao_dir = 'storage/app/file/posts/' . str_pad($value->id, 7, '0', STR_PAD_LEFT) . '/';
			if(file_exists($thongbao_dir))
			{
				$thongbao_files = scandir($thongbao_dir);
				$extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
				if(isset($thongbao_files[3]))
				{
					$extension = strtolower(pathinfo($thongbao_files[3], PATHINFO_EXTENSION));
					if(in_array($extension, $extensions))
						$thongbao_first_file[$value->id] = config('app.url') . '/'. $thongbao_dir . $thongbao_files[3];
					else
						$thongbao_first_file[$value->id] = $no_image;
				}
				else
					$thongbao_first_file[$value->id] = $no_image;
			}
			else
				$thongbao_first_file[$value->id] = $no_image;
		}
		
	
		
		// Xem nhiều nhất
		$thongbao_xnn = ThongBao::where([['kichhoat', 1], ['loai', '=', 'dinhkem']])
			->orderBy('luotxem', 'desc')
			->take(10)->get();
		
		$thongbao_xnn_first_file = array();
		foreach($thongbao_xnn as $value)
		{
			$thongbao_xnn_dir = 'storage/app/files/posts/' . str_pad($value->id, 7, '0', STR_PAD_LEFT) . '/';
			if(file_exists($thongbao_xnn_dir))
			{
				$thongbao_xnn_files = scandir($thongbao_xnn_dir);
				$extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
				if(isset($thongbao_xnn_files[3]))
				{
					$extension = strtolower(pathinfo($thongbao_xnn_files[3], PATHINFO_EXTENSION));
					if(in_array($extension, $extensions))
						$thongbao_xnn_first_file[$value->id] = config('app.url') . '/'. $thongbao_xnn_dir . $thongbao_xnn_files[3];
					else
						$thongbao_xnn_first_file[$value->id] = $no_image;
				}
				else
					$thongbao_xnn_first_file[$value->id] = $no_image;
			}
			else
				$thongbao_xnn_first_file[$value->id] = $no_image;
		}
		
		if(empty($loai))
			return view('admin.dashboard', compact('session_title', 'thongbao', 'thongbao_first_file', 'loai_thongke', 'thongbao_xnn', 'thongbao_xnn_first_file'));
		else
			return view('admin.dashboard', compact('loai', 'thongbao', 'thongbao_first_file', 'loai_thongke', 'thongbao_xnn', 'thongbao_xnn_first_file'));
	}
	
	public function getthongbao_ChiTiet($loai, $titleWithid)
	{
		$arrTitleWithid = explode('.', $titleWithid);
		$tieuDe = explode('-', $arrTitleWithid[0]);
		$mathongbao = $tieuDe[count($tieuDe) - 1];
		
		if(!is_numeric($mathongbao)) abort(404);
		
		$thongbao = ThongBao::where('id', $mathongbao)
			->firstOrFail();
		$thongbao_truoc = thongbao::where('id', $mathongbao - 1)
			->first();
		$thongbao_sau = thongbao::where('id', $mathongbao + 1)
			->first();
		
		// Cập nhật lượt xem
		$idXem = 'BV' . $mathongbao;
		if(!session()->has($idXem))
		{
			$orm = ThongBao::find($mathongbao);
			$orm->luotxem = $thongbao->luotxem + 1;
			$orm->save();
			session()->put($idXem, 1);
		}
		
		// Dữ liệu kèm theo bài viết
		$thongbao_vanban = array();
		$thongbao_nhanvien = array();
		if($thongbao->loai == 'dinhkem')
		{
			$thongbao_vanban = VanBan::where([['kichhoat', 1], ['thongbao_id', $thongbao->id]])
				->get();
			$thongbao_nhanvien = null;
		}
		
		else
		{
			$thongbao_vanban = null;
			$thongbao_nhanvien = null;
		}
		
		
		// Bài viết liên quan
		$no_image = config('app.url') . '/public/img/no-image.jpg';
		$thongbao_lq = thongbao::where([['kichhoat', 1], ['loai', $thongbao->loai]])
			->orderBy('created_at', 'desc')
			->take(5)->get();
		
		$thongbao_lq_first_file = array();
		foreach($thongbao_lq as $value)
		{
			$thongbao_lq_dir = 'storage/app/file/posts/' . str_pad($value->id, 7, '0', STR_PAD_LEFT) . '/';
			if(file_exists($thongbao_lq_dir))
			{
				$thongbao_lq_files = scandir($thongbao_lq_dir);
				$extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
				if(isset($thongbao_lq_files[3]))
				{
					$extension = strtolower(pathinfo($thongbao_lq_files[3], PATHINFO_EXTENSION));
					if(in_array($extension, $extensions))
						$thongbao_lq_first_file[$value->id] = config('app.url') . '/'. $thongbao_lq_dir . $thongbao_lq_files[3];
					else
						$thongbao_lq_first_file[$value->id] = $no_image;
				}
				else
					$thongbao_lq_first_file[$value->id] = $no_image;
			}
			else
				$thongbao_lq_first_file[$value->id] = $no_image;
		}
		
		return view('admin.thongbao-chitiet', compact('thongbao', 'thongbao_truoc', 'thongbao_sau', 'thongbao_vanban', 'thongbao_nhanvien', 'loai_thongke', 'thongbao_lq', 'thongbao_lq_first_file'));
	}

	public function ChiTietThongBao($id)
    {
		$thongbao = ThongBao::where('id', $id)->first();
		$vanban = VanBan::where('thongbao_id', $id)->get();
        $thongbao_cu = ThongBao::where([['kichhoat', 1]])
                    ->orderBy('quantrong', 'desc')
                    ->orderBy('created_at', 'desc')->get();
		if(Auth::user()->role==5){
			return view('sinhvien.thongbao.chitiet',compact('thongbao','vanban','thongbao_cu'));}
		else{
			return view('giamthi.thongbao.chitiet',compact('thongbao','vanban','thongbao_cu'));}
    }
    public function getThongBaoMoiNhat(){
        $thongbao = ThongBao::where([['kichhoat', 1],['quantrong',1]])
                    ->orderBy('quantrong', 'desc')
                    ->orderBy('created_at', 'desc')->first();

        $thongbao_cu = ThongBao::where([['kichhoat', 1]])
                    ->orderBy('quantrong', 'desc')
                    ->orderBy('created_at', 'desc')->get();
        $vanban = VanBan::where('thongbao_id', $thongbao->id)->get();
		if(Auth::user()->role==5){
			return view('sinhvien.thongbao.moinhat',compact('thongbao','vanban','thongbao_cu'));}
		else{
			return view('giamthi.thongbao.moinhat',compact('thongbao','vanban','thongbao_cu'));}
    }
    public function TatCaThongBao(){
        $thongbao = ThongBao::where([['kichhoat', 1]])
                    ->orderBy('quantrong', 'desc')
                    ->orderBy('created_at', 'desc')->get();
      
		if(Auth::user()->role==5){
			return view('sinhvien.thongbao.tatca',compact('thongbao'));}
		else{
			return view('giamthi.thongbao.tatca',compact('thongbao'));}
    
    }
}
