<?php

namespace App\Http\Controllers;

use App\ZoomMeeting;
use Illuminate\Http\Request;
use App\Traits\ZoomMeetingTrait;

class ZoomMeetingController extends Controller
{
    public function meeting()
    {
        return view('employee.zoom.index');
    }
}
