<?php

namespace App\Imports;
use App\Models\DeThi_PhongThi;
use App\Models\CaThi;
use App\Models\PhongThi;
use App\Models\DeThi;
use Maatwebsite\Excel\Concerns\ToModel;
use MacsiDigital\Zoom\Facades\Zoom;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
class PhongThiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
        $cathi = CaThi::where('tenca', $row['ca_thi'])->first();


          //zoom
        $user = Zoom::user()->first();
        $cathi = CaThi::where('id', $cathi->id)->first();
        $ngaygiothi=Carbon::parse($cathi->ngaythi)->setTimeFromTimeString($cathi->giobatdau);
        $ngaygiothi->subMinutes(15);
      
        $meetingData = [
            'topic' => 'Điểm danh - '.$row['phong_thi'],
            'duration' => '180',
            'start_time' => $ngaygiothi,
            'timezone' => config('zoom.timezone')
          //'timezone' => 'Africa/Cairo'
        ];
        $meeting = Zoom::meeting()->make($meetingData);

        $meeting->settings()->make([
            'join_before_host' => true,
            'host_video' => true,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => false,
            'approval_type' => config('zoom.approval_type'),
            'audio' => config('zoom.audio'),
            'auto_recording' => config('zoom.auto_recording')
        ]);

        $meeting =  $user->meetings()->save($meeting);

        // $phongthi= new PhongThi([
        //     'cathi_id' => $cathi->id,
        //     'maphong' => $row['phong_thi'],
        //     'soluongthisinh' => $row['so_luong_thi_sinh'],
        //     'ma_meeting' => $meeting->id,
        //     'join_url' => $meeting->join_url,
        //     'ghi_chu' => $row['ghi_chu'],
        //     ]);

        $data = new PhongThi();
        $data->cathi_id = $cathi->id;
        $data->maphong = $row['phong_thi'];
        $data->soluongthisinh = $row['so_luong_thi_sinh'];
        $data->ma_meeting = $meeting->id;
        $data->join_url =  $meeting->join_url;
        $data->ghichu = $row['ghi_chu'];
        $data->save();
        

        $dethi = DeThi::where('tendethi', $row['de_thi'])->first();
       
        $dethi_phongthi= new DeThi_PhongThi();
        $dethi_phongthi->dethi_id = $dethi->id;
        $dethi_phongthi->phongthi_id = $data->id;
        $dethi_phongthi->ghichu = $row['ghi_chu'];
        $dethi_phongthi->save();
 
    }
    public function headingRow(): int
    {
        return 6;
    }
}
