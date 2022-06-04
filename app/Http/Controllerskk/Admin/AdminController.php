<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;

use App\Leave;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        $employees=Employee::all();

        $color1=50;
        $color2=50;
        $data['dataset']=array();
        $data['totalTasks']=count(Task::where('status','Completed')->get());
        $data['pendingTasks']=count(Task::where('status','!=','Completed')->get());
        $data['leaves']=count(Leave::where('created_at',date('Y-m-d 00:00:00'))->get());
        foreach($employees as $employee){
            $val['totalTasks']=count(Task::where('assignee',$employee->id)->get());
            $tasks=collect();
            $tasks->jan=0;
            $tasks->feb=0;
            $tasks->mar=0;
            $tasks->apr=0;
            $tasks->may=0;
            $tasks->jun=0;
            $tasks->jul=0;
            $tasks->aug=0;
            $tasks->sep=0;
            $tasks->oct=0;
            $tasks->nov=0;
            $tasks->dec=0;
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '01')->get();
            $tasks->jan=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '02')->get();
            $tasks->feb=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '03')->get();
            $tasks->mar=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '04')->get();
            $tasks->apr=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '05')->get();
            $tasks->may=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '06')->get();
            $tasks->jun=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '07')->get();
            $tasks->jul=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '08')->get();
            $tasks->aug=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '09')->get();
            $tasks->sep=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '10')->get();
            $tasks->oct=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '11')->get();
            $tasks->nov=count($jan);
            $jan=Task::where('assignee',$employee->id)->whereMonth('created_at', '=', '12')->get();
            $tasks->dec=count($jan);
            $val['tasks']=$tasks;
            $val['employee']=$employee->first_name." ".$employee->last_name;
            $val['color']="rgb(255,".$color1.",".$color2.",.50)";
            array_push($data['dataset'],$val);
            $color1=$color1+50;
            $color2=$color2+50;
        }
        return view('admin.index')->with($data);
    }

    public function reset_password() {
        return view('auth.reset-password');
    }

    public function update_password(Request $request) {
        $user = Auth::user();
        dd($user->password);
        if($user->password == Hash::make($request->old_password)) {
            dd($request->all());
        } else {
            $request->session()->flash('error', 'Wrong Password');
            return back();
        }
    }
}
