<?php

namespace App\Http\Controllers;

use App\Models\KyThi;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Auth;
class KyThiController extends Controller
{
    public function getDanhSach()
    {
        $kythi = KyThi::all();
        
            return view('admin.sapphong.qlkythi.danhsach',compact('kythi'));
       
    }
    public function getXoa(Request $request)
    {
        try {  
            \DB::table('kythi')->where('id', '=', $request->id)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.sapphong.qlkythi.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            
                return redirect()->route('admin.sapphong.qlkythi.danhsach');
          
            
        }
    }
    public function getThem()
    {
      
            return view('admin.sapphong.qlkythi.them');
       
        
    }
    public function postThem(Request $request)
    {
        $namhoc=explode('-',$request->namhoc);
        $min=$namhoc[0];
        $max=$namhoc[0]+1;
        $this->validate($request, [
			'tenkythi' => 'required|max:255|unique:kythi,tenkythi',
            'hocky' => 'required|max:255:kythi,hocky',
            'namhoc' => 'required|numeric|min:'.$min.'|max:'.$max,
		],
        [
            'tenkythi.unique'=>'Tên kỳ thi '.$request->tenkythi.' đã tồn tại',
            
        ]);
		
		\DB::table('kythi')->insert([
            'tenkythi' => $request->tenkythi,
			'hocky' => $request->hocky,
            'namhoc' => $request->namhoc,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');     
        return redirect()->route('admin.sapphong.qlkythi.danhsach');
        
    }
    public function getSua($id)
    {
        $kythi=\DB::table('kythi')->where('id',$id)->first();
        return view('admin.sapphong.qlkythi.sua')->with('ktkythi',$kythi);
        //return view('admin.qlkhoa.sua', compact('khoa'));
    }
    public function postSua(Request $request, $id)
    {
        $this->validate($request, [
            'tenkythi'=>'required|max:255|unique:kythi,tenkythi,' . $request->id . ',id',
            'hocky' => 'required|max:255:kythi,hocky',
            'namhoc' => 'required|max:255:kythi,namhoc'
        ],[
            'tenkythi.unique'=>'Tên kỳ thi '.$request->tenkythi.' đã tồn tại'
        ]);
       
        \DB::table('kythi')->where('id', $request->id)->update([
            'tenkythi' => $request->tenkythi,
            'hocky' => $request->hocky,
            'namhoc' => $request->namhoc
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
       
            return redirect()->route('admin.sapphong.qlkythi.danhsach');
      
        
    }
}
