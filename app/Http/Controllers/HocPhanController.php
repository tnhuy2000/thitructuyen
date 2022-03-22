<?php

namespace App\Http\Controllers;

use App\Models\HocPhan;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Imports\HocPhanImport;
use App\Exports\HocPhanExport;
use Excel;
class HocPhanController extends Controller
{
    public function getDanhSach()
    {
        $hocphan = HocPhan::all();
        return view('admin.danhmuc.qlhocphan.danhsach',compact('hocphan'));
    }
    public function getXoa(Request $request)
    {
       
        try {  
            \DB::table('hocphan')->where('mahocphan', '=', $request->mahocphan)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qlhocphan.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.danhmuc.qlhocphan.danhsach');
        }
    }
    public function getThem()
    {
        return view('admin.danhmuc.qlhocphan.them');
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
			'mahocphan' => 'required|max:255|unique:hocphan,mahocphan',
            'tenhocphan' => 'required|max:255|unique:hocphan,tenhocphan',
            'sotinchi' => 'required|max:10|min:2|numeric:hocphan,sotinchi'
		],
        [
            'mahocphan.required'=>'Mã học phần không được bỏ trống',
            'tenhocphan.required'=>'Tên học phần không được bỏ trống',
            'sotinchi.required'=>'Số tín chỉ không được bỏ trống',
            'mahocphan.unique'=>'Mã học phần đã tồn tại',
            'tenhocphan.unique'=>'Tên học phần đã tồn tại',
            'sotinchi.max'=>'Số tín chỉ không vượt quá 10',
            'sotinchi.min'=>'Số tín chỉ không nhỏ hơn 1'
            
        ]);
		
		\DB::table('hocphan')->insert([
            'mahocphan' => $request->mahocphan,
			'tenhocphan' => $request->tenhocphan,
            'sotinchi' => $request->sotinchi,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.danhmuc.qlhocphan.danhsach');
    }
    public function getSua($mahocphan)
    {
        $hocphan=\DB::table('hocphan')->where('mahocphan',$mahocphan)->first();
        return view('admin.danhmuc.qlhocphan.sua')->with('kthocphan',$hocphan);
        
    }
    public function postSua(Request $request, $mahocphan)
    {
        $this->validate($request, [
            'tenhocphan'=>'required|max:255|unique:hocphan,tenhocphan,' . $request->mahocphan . ',mahocphan',
            'sotinchi'=>'required|max:10|min:2|numeric:hocphan,sotinchi,'
        ],[
            'mahocphan.required'=>'Mã học phần không được bỏ trống',
            'tenhocphan.required'=>'Tên học phần không được bỏ trống',
            'sotinchi.required'=>'Số tín chỉ không được bỏ trống',
            'tenhocphan.unique'=>'Tên học phần '.$request->tenhocphan.' đã tồn tại',
            'sotinchi.max'=>'Số tín chỉ không vượt quá 10',
            'sotinchi.min'=>'Số tín chỉ không nhỏ hơn 1'
        ]);
       
        \DB::table('hocphan')->where('mahocphan', $request->mahocphan)->update([
            'tenhocphan' => $request->tenhocphan,
            'sotinchi' => $request->sotinchi
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.danhmuc.qlhocphan.danhsach');
    }
    // Nhập từ Excel
    public function postNhap(Request $request)
    {
        toastr()->info('Nhập dữ liệu thành công');
    Excel::import(new HocPhanImport, $request->file('file_excel'));
    return redirect()->route('admin.danhmuc.qlhocphan.danhsach');
    }
    // Xuất ra Excel
    public function getXuat()
    {
    return Excel::download(new HocPhanExport, 'danh-sach-hoc-phan.xlsx');
    }
}
