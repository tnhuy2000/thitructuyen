<?php

namespace App\Http\Controllers;

use App\Models\DeThi;
use App\Models\DuLieuDeThi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class DeThiController extends Controller
{
    
    public function getDanhSach()
    {
        $kythi = \DB::table('kythi')->get();
		$hocphan = \DB::table('hocphan')->get();
        $dt = Carbon::now();
        $dt1 = Carbon::now();
        $dt2 = Carbon::now();


        $nam1= $dt1->addYear(1);
        $nam2= $dt2->subYear(1);

        $year= $dt->year;
        $year1= $nam1->year;
        $year2= $nam2->year;

        $namhoc1= $year.'-'.$year1;
        $namhoc2= $year2.'-'.$year;

        $hocphan=\DB::table('hocphan')->get();
        $dethi = \DB::table('dethi as d')
				->join('hocphan as hp', 'd.mahocphan', '=', 'hp.mahocphan')
                ->join('kythi as kt', 'd.kythi_id', '=', 'kt.id')
				->select('d.id','d.tendethi', 'd.mahocphan','hp.tenhocphan','hp.sotinchi', 'd.kythi_id','kt.tenkythi','kt.hocky','kt.namhoc','d.thoigianlambai','d.hinhthuc')
				->orderBy('kt.namhoc', 'desc')->get();
		$dethimoi = \DB::table('dethi as d')
				->join('hocphan as hp', 'd.mahocphan', '=', 'hp.mahocphan')
                ->join('kythi as kt', 'd.kythi_id', '=', 'kt.id')
                ->where('kt.namhoc', '=', $namhoc1)
                ->orWhere('kt.namhoc','=', $namhoc2)
				->select('d.id','d.tendethi', 'd.mahocphan','hp.tenhocphan','hp.sotinchi', 'd.kythi_id','kt.tenkythi','kt.hocky','kt.namhoc','d.thoigianlambai','d.hinhthuc')
				->orderBy('kt.namhoc', 'desc')->get();
        $dethicu = \DB::table('dethi as d')
				->join('hocphan as hp', 'd.mahocphan', '=', 'hp.mahocphan')
                ->join('kythi as kt', 'd.kythi_id', '=', 'kt.id')
                ->orWhere('kt.namhoc','<', $namhoc2)
				->select('d.id','d.tendethi', 'd.mahocphan','hp.tenhocphan','hp.sotinchi', 'd.kythi_id','kt.tenkythi','kt.hocky','kt.namhoc','d.thoigianlambai','d.hinhthuc')
				->orderBy('kt.namhoc', 'desc')->get();
		return view('admin.dethi_baithi.qldethi.danhsach',compact('dethicu','dethi','dethimoi','hocphan'));
    }
    public function postXoa(Request $request)
    {
        
        try {  
            DuLieuDeThi::where('dethi_id', $request->id)->delete();
            \DB::table('dethi')->where('id', '=', $request->id)->delete();
            //Storage::deleteDirectory('file/dethi/' . str_pad($request->id, 7, '0', STR_PAD_LEFT));
            toastr()->success('Xoá dữ liệu thành công!');
            return redirect()->route('admin.dethi_baithi.qldethi.danhsach');
        } catch (\Illuminate\Database\QueryException $e) {
            toastr()->warning('Cảnh báo! Dữ liệu này không thể xoá vì để tránh mất dữ liệu.');
            return redirect()->route('admin.dethi_baithi.qldethi.danhsach');
        }
    }
    public function getThem()
    {
        $hocphan=\DB::table('hocphan')->get();
        $kythi=\DB::table('kythi')->orderBy('kythi.id', 'desc')->get();
        return view('admin.dethi_baithi.qldethi.them')->with('kthocphan',$hocphan)->with('ktkythi',$kythi);
    }
    public function postThem(Request $request)
    {
        $this->validate($request, [
			'mahocphan' => 'required|max:8:dethi,mahocphan',
            'kythi_id' => 'required|max:255:dethi,kythi_id',
            'tendethi' => 'required|max:255:dethi,tendethi',
            'thoigianlambai' => 'required|numeric|min:5|max:300',
            'hinhthuc' => 'required|max:255:dethi,hinhthuc'

		],
        [
            'thoigianlambai.max' => 'Thời gian làm bài tối đa là 300 phút',
            'thoigianlambai.min' => 'Thời gian làm bài tối thiểu là 5 phút',
        ]);
		
		\DB::table('dethi')->insert([
            'mahocphan' => $request->mahocphan,
			'kythi_id' => $request->kythi_id,
            'tendethi' => $request->tendethi,
            'thoigianlambai' => $request->thoigianlambai,
            'hinhthuc' => $request->hinhthuc,
            'updated_at' => Carbon::now()
		]);
        toastr()->success('Thêm dữ liệu thành công');
        return redirect()->route('admin.dethi_baithi.qldethi.danhsach');
    }
    public function getSua($id)
    {
        $dethi=\DB::table('dethi')->where('id',$id)->first();
        $hocphan=\DB::table('hocphan')->get();
        $kythi=\DB::table('kythi')->orderBy('kythi.id', 'desc')->get();
        return view('admin.dethi_baithi.qldethi.sua') ->with('ktdethi',$dethi)->with('kthocphan',$hocphan)->with('ktkythi',$kythi);
    }
    public function postSua(Request $request, $id)
    {
        $this->validate($request, [
            'mahocphan'=>'required|max:255:dethi,mahocphan,' . $request->id . ',id',
            'kythi_id'=>'required|max:255:dethi,kythi_id',
            'tendethi' => 'required|max:255:dethi,tendethi',
            'thoigianlambai' => 'required|numeric|min:5|max:300',
            'hinhthuc' => 'required|max:255:dethi,hinhthuc'
        ],[
            'thoigianlambai.max' => 'Thời gian làm bài tối đa là 300 phút',
            'thoigianlambai.min' => 'Thời gian làm bài tối thiểu là 5 phút',
        ]);
       
        \DB::table('dethi')->where('id', $request->id)->update([
            'mahocphan' => $request->mahocphan,
			'kythi_id' => $request->kythi_id,
            'tendethi' => $request->tendethi,
            'thoigianlambai' => $request->thoigianlambai,
            'hinhthuc' => $request->hinhthuc,
        ]);
        toastr()->success('Cập nhật dữ liệu thành công!');
        return redirect()->route('admin.dethi_baithi.qldethi.danhsach');}
        
    public function getDuLieuDeThi($dethi_id)
    {
        
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        $hinhanh_identity = \DB::select("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . config('database.connections.mysql.database') . "' AND TABLE_NAME = 'dulieudethi'");
        $next_id = $hinhanh_identity[0]->AUTO_INCREMENT;

        
        //tạo thư mục
        Storage::makeDirectory('file/dethi/' . str_pad($next_id, 7, '0', STR_PAD_LEFT), 0775);
        
        $path = config('app.url') . '/storage/app/file/dethi/' . str_pad($next_id, 7, '0', STR_PAD_LEFT) . '/';
        if(isset($_SESSION['ckAuth'])) unset($_SESSION['ckAuth']);
        $_SESSION['ckAuth'] = true;
        if(isset($_SESSION['baseUrl'])) unset($_SESSION['baseUrl']);
        $_SESSION['baseUrl'] = $path;
        if(isset($_SESSION['resourceType'])) unset($_SESSION['resourceType']);
        $_SESSION['resourceType'] = 'Files';
        
        $folder = 'file/dethi/' . str_pad($next_id, 7, '0', STR_PAD_LEFT);

       
        $ktdulieudethi = \DB::table('dulieudethi')
         ->where('dethi_id', '=', $dethi_id) ->get();

        $ktdethi = DeThi::where('id', $dethi_id)->first();
       
        return view('admin.dethi_baithi.qldulieudethi.danhsach', compact('folder','ktdulieudethi','ktdethi'));

    }
    
}
