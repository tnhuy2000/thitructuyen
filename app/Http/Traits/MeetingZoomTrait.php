<?php

namespace App\Http\Traits;
use App\Models\CaThi;
use MacsiDigital\Zoom\Facades\Zoom;
use Carbon\Carbon;
trait MeetingZoomTrait
{
    public function createMeeting($request){

        $user = Zoom::user()->first();

        $cathi = CaThi::where('id', $request->cathi_id)->first();
        $ngaygiothi=Carbon::parse($cathi->ngaythi)->setTimeFromTimeString($cathi->giobatdau);
        $ngaygiothi->subMinutes(15);

        $meetingData = [
            'topic' => 'Điểm danh - '.$request->maphong,
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
        
        return  $user->meetings()->save($meeting);


    }
}