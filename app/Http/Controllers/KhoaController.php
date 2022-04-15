<?php

namespace App\Http\Controllers;

use App\Models\Khoa;
use Illuminate\Http\Request;
use App\Imports\KhoaImport;
use App\Exports\KhoaExport;
use Excel;
use DataTables;
use Carbon\Carbon;
use QueryException;
class KhoaController extends Controller
{
    
    public function getDanhSach(Request $request)
    {
        $khoa = Khoa::all();
        return view('admin.danhmuc.qlkhoa.danhsach',compact('khoa'));
        
    }
    
    public function postXoa(Request $request)
    {
        try {  
            $query = Khoa::where('makhoa', $request->makhoa_delete)->delete();
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qlkhoa.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            //Log::error($e->getMessage());
           
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.danhmuc.qlkhoa.danhsach');
        }
        
    }
   
    public function postThem(Request $request)
    {
       
        $rules = array();
		$rules['makhoa'] = 'required|max:100|unique:khoa';
		$rules['tenkhoa'] = 'required|max:255|unique:khoa';
		
		$this->validate($request, $rules);


		\DB::table('khoa')->insert([
            'makhoa' => $request->makhoa,
			'tenkhoa' => $request->tenkhoa,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.danhmuc.qlkhoa.danhsach');
    }
    public function postSua(Request $request)
    {
        $this->validate($request, [
            'tenkhoa_edit'=>'required|max:255|unique:khoa,tenkhoa,' . $request->makhoa_edit . ',makhoa'
        ],[
            'tenkhoa_edit.required'=>'Vui lòng nhập tên khoa',
            'tenkhoa_edit.unique'=>'Tên khoa '.$request->tenkhoa_edit.' đã tồn tại'
        ]);
       
        $query= \DB::table('khoa')->where('makhoa', $request->makhoa_edit)->update([
            'tenkhoa' => $request->tenkhoa_edit
        ]);

            toastr()->success('Cập nhật dữ liệu thành công!');
            return redirect()->route('admin.danhmuc.qlkhoa.danhsach');
    }
     // Nhập từ Excel
     public function postNhap(Request $request)
     {
        Excel::import(new KhoaImport, $request->file('file_excel'));
        return redirect()->route('admin.danhmuc.qlkhoa.danhsach');
     }
     // Xuất ra Excel
     public function getXuat()
     {
        return Excel::download(new KhoaExport, 'danh-sach-khoa.xlsx');
     }
     
}
