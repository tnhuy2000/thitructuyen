<?php

namespace App\Http\Controllers;

use App\Models\CaThi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Imports\CaThiImport;
use App\Exports\CaThiExport;
use Excel;
use Illuminate\Support\Facades\Hash;
class CaThiController extends Controller
{
   
    public function getDanhSach()
    {
        $cathi = \DB::table('cathi')->get();
		$ktkythi = \DB::table('kythi')->get();
        
        $today = Carbon::today();
       
		$cathi_dangdienra = \DB::table('cathi as c')
				->join('kythi as k', 'c.kythi_id', '=', 'k.id')
                ->where('c.ngaythi', '=', $today )
				->select('c.id','c.tenca','c.ngaythi','c.giobatdau', 'k.tenkythi','k.hocky','k.namhoc')
				->orderBy('k.namhoc', 'asc')->get();
       
        $cathi_sapdienra = \DB::table('cathi as c')
            ->join('kythi as k', 'c.kythi_id', '=', 'k.id')
            ->where('c.ngaythi', '>', $today )
            ->select('c.id','c.tenca','c.ngaythi','c.giobatdau', 'k.tenkythi','k.hocky','k.namhoc')
            ->orderBy('k.namhoc', 'asc')->get();
        $cathi_dathi = \DB::table('cathi as c')
            ->join('kythi as k', 'c.kythi_id', '=', 'k.id')
            ->where('c.ngaythi', '<', $today )
            ->select('c.id','c.tenca','c.ngaythi','c.giobatdau', 'k.tenkythi','k.hocky','k.namhoc')
            ->orderBy('c.ngaythi', 'desc')->get();
		return view('admin.sapphong.qlcathi.danhsach',compact('cathi_dangdienra','cathi_dathi','cathi_sapdienra','ktkythi'));
    }
    public function getXoa(Request $request)
    {
        try {  
            \DB::table('cathi')->where('id', '=', $request->id)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.sapphong.qlcathi.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.sapphong.qlcathi.danhsach');
        }
    }
    public function getThem()
    {
        $cathi=\DB::table('cathi')->get();
        $kythi=\DB::table('kythi')->get();

        return view('admin.sapphong.qlcathi.them')->with('ktcathi',$cathi)->with('ktkythi',$kythi);
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
            'tenca' => 'required|max:255|unique:cathi,tenca',
            'ngaythi' => 'required|max:255:cathi,ngaythi',
            'giobatdau' => 'required|max:255:cathi,giobatdau',
            'password' => 'required|min:6:cathi,matkhaucathi',
            'kythi_id' => 'required|max:255:cathi,kythi_id'
		],
        [
            'tenca.unique'=>'Tên ca thi đã tồn tại',
            
        ]);
		
		\DB::table('cathi')->insert([
			'tenca' => $request->tenca,
            'ngaythi' => $request->ngaythi,
            'giobatdau' => $request->giobatdau,
            'matkhaucathi' => Hash::make($request->password),
            'kythi_id' => $request->kythi_id,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.sapphong.qlcathi.danhsach');
    }
    public function getSua($id)
    {
        $cathi=\DB::table('cathi')->where('id',$id)->first();
        $kythi=\DB::table('kythi')->get();
        return view('admin.sapphong.qlcathi.sua') ->with('ktcathi',$cathi)->with('ktkythi',$kythi);
    }
    public function postSua(Request $request, $malop)
    {
        $this->validate($request, [
            'tenca'=>'required|max:255|unique:cathi,tenca,' . $request->id . ',id',
            'ngaythi' => 'required|max:255:cathi,ngaythi',
            'giobatdau' => 'required|max:255:cathi,giobatdau',
            'kythi_id' => 'required|max:255:cathi,kythi_id'
        ],[
            'tenca.required'=>'Vui lòng nhập tên ca thi',
            'ngaythi.required'=>'Vui lòng nhập ngày thi',
            'tenca.unique'=>'Tên ca thi '.$request->tenca.' đã tồn tại'
        ]);

        $orm = CaThi::find($request->id);
		$orm->tenca = $request->tenca;
		$orm->ngaythi = $request->ngaythi;
		$orm->giobatdau = $request->giobatdau;
		if(!empty($request->password)) $orm->matkhaucathi = Hash::make($request->password);
		$orm->kythi_id = $request->kythi_id;
		$orm->save();
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.sapphong.qlcathi.danhsach');}

        public function postNhap(Request $request)
        {
            Excel::import(new CaThiImport($request->kythi_id), $request->file('file_excel'));
    
            return redirect()->route('admin.sapphong.qlphongthi.danhsach');
        }

        public function postXuat(Request $request)
        {
            $kythi=\DB::table('kythi')->where('id', '=', $request->kythi_id )->first();
            return Excel::download(new CaThiExport($request->kythi_id,$kythi->tenkythi,$kythi->hocky,$kythi->namhoc), 'danh-sach-ca-thi.xlsx');
        }
}
