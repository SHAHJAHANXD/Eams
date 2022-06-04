<?php

namespace App\Listeners;

use App\Attendance;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (!$event->user->hasRole('admin')) {
            $attendance = Attendance::where('employee_id', $event->user->employee->id)->orderBy('id', 'Desc')->first();
            // var_dump($attendance);die;
            $attendance->exit_ip = $attendance->entry_ip;
            $attendance->exit_location = $attendance->entry_ip;
            $attendance->registered = 'yes';
            $attendance->save();
        }

    }
}
