<?php

namespace App\Http\Controllers;
use App\Models\PhongThi;
use App\Models\SinhVien;
use App\Models\SinhVien_PhongThi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Auth;
use App\Exports\ThongKeBaiLamExport;
use Excel;
class ThongKeController extends Controller
{
  public function postTKBaiLamTimKiem(Request $request)
  {
    $baithi = \DB::table('baithi as bt')
          ->join('dethi_phongthi as dtpt', 'dtpt.id', '=', 'bt.dethiphongthi_id')
          ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
          ->join('cathi as ct', 'pt.cathi_id', '=', 'ct.id')
          ->select('ct.id','ct.tenca','pt.cathi_id','pt.maphong','dtpt.phongthi_id','ct.ngaythi','ct.giobatdau','pt.soluongthisinh',DB::raw('count(bt.id) as slbaithi'))
            ->where('bt.trangthai', 1)
            ->where('ct.tenca','like','%'.$request->tenca.'%')
            ->where('ct.ngaythi','like','%'.$request->ngaythi.'%')
            ->groupBy('ct.id','pt.maphong','ct.tenca','ct.ngaythi','ct.giobatdau','dtpt.phongthi_id','pt.soluongthisinh')->get();
      $phongthi = \DB::table('phongthi as p')
          ->orderBy('p.maphong', 'asc')->get(); 
      $cathi = \DB::table('cathi')->get();
     
    $dem=\DB::table('cathi as ct')
              ->join('phongthi as pt', 'pt.cathi_id', '=', 'ct.id')
              ->select('ct.tenca','ct.id',DB::raw('count(pt.id) as slphong'))
              ->groupBy('ct.tenca','ct.id')->get();
      
              // $tenphong='';
              // $id='';
              // foreach($baithi as $value){
              //   if($value->cathi_id!=$id){
              //   foreach($baithi as $value1){
              //         if($value1->cathi_id==$value->cathi_id && $value1->phongthi_id !=$value->phongthi_id)
              //         {
              //           foreach($dem as $item)
              //           {
              //             if($item->id==$value->cathi_id){
              //                 $value->soluong=$item->slphong;
              //                 $value->maphong.='-'.$value1->maphong;
              //                 $value->soluongthisinh.='-'.$value1->soluongthisinh;
              //                 $value->slbaithi.='-'.$value1->slbaithi;
              //             }
              //           }
              //           $id=$value1->cathi_id;
              //         }
              //   } 
              // }
        $cathi_phongthi = \DB::table('baithi as bt')
              ->join('dethi_phongthi as dtpt', 'dtpt.id', '=', 'bt.dethiphongthi_id')
              ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
              ->join('cathi as ct', 'pt.cathi_id', '=', 'ct.id')
              ->select('ct.tenca','pt.cathi_id','ct.ngaythi','ct.giobatdau')
                ->where('bt.trangthai', 1)
                ->where('ct.tenca','like','%'.$request->tenca.'%')
                ->where('ct.ngaythi','like','%'.$request->ngaythi.'%')
                ->groupBy('pt.cathi_id','ct.tenca','ct.ngaythi','ct.giobatdau')->get();
    
      $ngaythi=$request->ngaythi;
      $tenca=$request->tenca;
      if(Auth::user()->role==1)
          return view('admin.thongke.bailamsinhvien',compact('baithi','cathi','dem','phongthi','cathi_phongthi','ngaythi','tenca'));
      elseif(Auth::user()->role==4)
          return view('hoidongthi.thongke.bailamsinhvien',compact('baithi','cathi','dem','phongthi','cathi_phongthi','ngaythi','tenca'));
  }
  public function getTKBaiLam()
    {
      $baithi = \DB::table('baithi as bt')
            ->join('dethi_phongthi as dtpt', 'dtpt.id', '=', 'bt.dethiphongthi_id')
            ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
            ->join('cathi as ct', 'pt.cathi_id', '=', 'ct.id')
            ->select('ct.tenca','pt.cathi_id','pt.maphong','dtpt.phongthi_id','ct.ngaythi','ct.giobatdau','pt.soluongthisinh',DB::raw('count(bt.id) as slbaithi'))
              ->where('bt.trangthai', 1)
              ->groupBy('pt.maphong','ct.tenca','ct.ngaythi','ct.giobatdau','dtpt.phongthi_id','pt.soluongthisinh')->get();

              
        $phongthi = \DB::table('phongthi as p')
            ->orderBy('p.maphong', 'asc')->get(); 
        $cathi = \DB::table('cathi')->get();
       
      $dem=\DB::table('cathi as ct')
                ->join('phongthi as pt', 'pt.cathi_id', '=', 'ct.id')
                ->select('ct.tenca','ct.id',DB::raw('count(pt.id) as slphong'))
                ->groupBy('ct.tenca','ct.id')->get();

      $cathi_phongthi = \DB::table('baithi as bt')
                ->join('dethi_phongthi as dtpt', 'dtpt.id', '=', 'bt.dethiphongthi_id')
                ->join('phongthi as pt', 'pt.id', '=', 'dtpt.phongthi_id')
                ->join('cathi as ct', 'pt.cathi_id', '=', 'ct.id')
                ->select('ct.tenca','pt.cathi_id','ct.ngaythi','ct.giobatdau')
                  ->where('bt.trangthai', 1)
                  ->groupBy('pt.cathi_id','ct.tenca','ct.ngaythi','ct.giobatdau')->get();
     
                // $tenphong='';
                // $id='';
                // foreach($baithi as $value){
                //   if($value->cathi_id!=$id){
                //   foreach($baithi as $value1){
                //         if($value1->cathi_id==$value->cathi_id && $value1->phongthi_id !=$value->phongthi_id)
                //         {
                //           foreach($dem as $item)
                //           {
                //             if($item->id==$value->cathi_id){
                //                 $value->soluong=$item->slphong;
                //                 $value->maphong.='-'.$value1->maphong;
                //                 $value->soluongthisinh.='-'.$value1->soluongthisinh;
                //                 $value->slbaithi.='-'.$value1->slbaithi;
                //             }
                //           }
                //           $id=$value1->cathi_id;
                //         }
                //   } 
                // }
                // }  
                
                
        if(Auth::user()->role==1)
            return view('admin.thongke.bailamsinhvien',compact('baithi','cathi','dem','phongthi','cathi_phongthi'));
        elseif(Auth::user()->role==4)
            return view('hoidongthi.thongke.bailamsinhvien',compact('baithi','cathi','dem','phongthi','cathi_phongthi'));
    }


    public function getTKDiemDanh()
    {
        $phongthi = \DB::table('phongthi as p')
				->join('cathi as c', 'p.cathi_id', '=', 'c.id')
				->select('p.id','p.maphong','p.soluongthisinh','p.ma_meeting','p.ghichu','c.tenca','c.ngaythi','c.giobatdau')
				->orderBy('p.id', 'desc')->get();
        $cathi = \DB::table('cathi')->get();
       
        $sinhvien_phongthi_comat =DB::table('sinhvien_phongthi as svpt')
                    ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
                    ->join('phongthi as pt', 'pt.id', '=', 'svpt.phongthi_id')
                    ->select('pt.maphong','svpt.phongthi_id',DB::raw('count(svpt.masinhvien) as slsvcomat'))
                    ->where('svpt.diemdanh', 1)
                    ->groupBy('pt.maphong','svpt.phongthi_id')
                    ->get();
        $sinhvien_phongthi_vang =DB::table('sinhvien_phongthi as svpt')
                    ->join('sinhvien as sv', 'sv.masinhvien', '=', 'svpt.masinhvien')
                    ->join('phongthi as pt', 'pt.id', '=', 'svpt.phongthi_id')
                    ->select('pt.maphong','svpt.phongthi_id',DB::raw('count(svpt.masinhvien) as slsvvang'))
                    ->where('svpt.diemdanh', 0)
                    ->groupBy('pt.maphong','svpt.phongthi_id')
                    ->get();
       
        return view('admin.thongke.diemdanhsinhvien',compact('sinhvien_phongthi_comat','sinhvien_phongthi_vang','cathi','phongthi'));
    }

    
    // Xuất ra Excel
    public function getXuatTKBaiLam()
    {
    return Excel::download(new ThongKeBaiLamExport, 'thong-ke-bai-lam.xlsx');
    }
}