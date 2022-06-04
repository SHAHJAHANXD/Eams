<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Key_stork;
use App\laravel_logger_activity;
use App\Leave;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
    public function key_storking($id)

    {

        $list = laravel_logger_activity::where('userId', $id)->orderBy('id','desc')->get();
        foreach($list as $key => $value)
        {
            $list[$key]['listed'] = $value->created_at->diffForHumans();
        }
        return view('admin.key.list', compact('list'));
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
    public function adminProfile() {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->get();
        return view('admin.profile', compact('data'));
    }
    public function adminProfile_edit ($employee_id) {
        $data = User::where('id', $employee_id)->get();
        return view('admin.profile-edit', compact('data'));
    }
    public function adminProfile_update (Request $request, $employee_id) {



        $employee = User::findOrFail($employee_id);

        if ($request->hasfile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $employee->photo = $imageName;
            $request->photo->move(public_path('images'), $imageName);
        }
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->save();
        $request->session()->flash('success', 'Your profile has been successfully updated!');
        return redirect('/admin/profile');
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
