<?php

namespace App\Http\Controllers\Employee;

use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Monitoring;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    public function index() {
        $data = [
            'employee' => Auth::user()->employee
        ];
        return view('employee.index')->with($data);
    }

    public function profile() {
        $data = [
            'employee' => Auth::user()->employee
        ];
        return view('employee.profile')->with($data);
    }

    public function profile_edit($employee_id) {
        $data = [
            'employee' => Employee::findOrFail($employee_id),
            'departments' => Department::all(),
            'desgs' => ['Manager', 'Assistant Manager', 'Deputy Manager', 'Clerk']
        ];
        Gate::authorize('employee-profile-access', intval($employee_id));
        return view('employee.profile-edit')->with($data);
    }

    public function profile_update(Request $request, $employee_id) {
        Gate::authorize('employee-profile-access', intval($employee_id));
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'photo' => 'image|nullable'
        ]);

        $employee = Employee::findOrFail($employee_id);

        if ($request->hasfile('photo')) {
            $imageName = time() . '.' . $request->photo->extension();
            $employee->photo = $imageName;
            $request->photo->move(public_path('images'), $imageName);
        }
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->dob = $request->dob;
        $employee->sex = $request->gender;
        $employee->join_date = $request->join_date;
        $employee->desg = $request->desg;
        $employee->department_id = $request->department_id;
        $employee->save();
        $request->session()->flash('success', 'Your profile has been successfully updated!');
        return redirect()->route('employee.profile');
    }


    public function saveImage(Request $request){
        if ($request->has('screenShot')) {
            $user = User::find($request->id);
            $image      = $request->screenShot;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);
            $dateTime=\Carbon\Carbon::now();
            $fileName   = $dateTime->format('d_m_y_H_i_s').$user->id.'.png';

//            $img = Image::make($image->getRealPath());
//            $img->resize(120, 120, function ($constraint) {
//                $constraint->aspectRatio();
//            });
//
//            $img->stream(); // <-- Key point

            //$image->move(public_path('/images'),$fileName);
           Storage::disk('monitoring')->put('images'.'/'.$fileName, $image, 'public');

            Monitoring::insert([
                ['employee_id' => $user->id, 'screenshot' => $fileName, 'created_at'=>$dateTime->format('Y-m-d H:i:s')]
            ]);

            return response()->json('saved');
        }
    }
    public function employeeProductivity($employee_id) {
        $data['employee'] = Employee::findOrFail($employee_id);

        $data['dataset']=array();
        $data['completedTasks']=count(Task::where('status','Completed')->where('assignee',$employee_id)->get());
        $data['pendingTasks']=count(Task::where('status','!=','Completed')->where('assignee',$employee_id)->get());
        $data['leaves']=count(Leave::whereYear('created_at',date('Y'))->get());
        $data['totalTasks']=count(Task::where('assignee',$employee_id)->get());
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
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '01')->get();
            $tasks->jan=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '02')->get();
            $tasks->feb=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '03')->get();
            $tasks->mar=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '04')->get();
            $tasks->apr=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '05')->get();
            $tasks->may=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '06')->get();
            $tasks->jun=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '07')->get();
            $tasks->jul=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '08')->get();
            $tasks->aug=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '09')->get();
            $tasks->sep=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '10')->get();
            $tasks->oct=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '11')->get();
            $tasks->nov=count($jan);
            $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '12')->get();
            $tasks->dec=count($jan);
            $val['tasks']=$tasks;
            $val['employee']=$data['employee']->first_name." ".$data['employee']->last_name;
            $val['color']="rgb(255,51,51,.50)";
            array_push($data['dataset'],$val);
        return view('employee.moniterlisting')->with($data);
    }
    public function pdfcreate($employee_id)
    {
        $data['employee'] = Employee::findOrFail($employee_id);

        $data['dataset']=array();
        $data['completedTasks']=count(Task::where('status','Completed')->where('assignee',$employee_id)->get());
        $data['pendingTasks']=count(Task::where('status','!=','Completed')->where('assignee',$employee_id)->get());
        $data['leaves']=count(Leave::whereYear('created_at',date('Y'))->get());
        $data['totalTasks']=count(Task::where('assignee',$employee_id)->get());
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
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '01')->get();
        $tasks->jan=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '02')->get();
        $tasks->feb=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '03')->get();
        $tasks->mar=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '04')->get();
        $tasks->apr=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '05')->get();
        $tasks->may=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '06')->get();
        $tasks->jun=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '07')->get();
        $tasks->jul=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '08')->get();
        $tasks->aug=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '09')->get();
        $tasks->sep=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '10')->get();
        $tasks->oct=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '11')->get();
        $tasks->nov=count($jan);
        $jan=Task::where('assignee',$employee_id)->whereMonth('created_at', '=', '12')->get();
        $tasks->dec=count($jan);
        $val['tasks']=$tasks;
        $val['employee']=$data['employee']->first_name." ".$data['employee']->last_name;
        $val['color']="rgb(255,51,51,.50)";
        array_push($data['dataset'],$val);
        $pdf = PDF::loadHtml('<h1 align="center">Employee Productivity Report</h1>
                                    <h2  align="center">Employee Name: '. $val['employee'].'</h2>
                                    <h3>Total Assigned Task: '.$data['totalTasks'].'</h3>
                                    <h3>Completed Tasks : '.$data['completedTasks'].'</h3>
                                    <h3>Total Pending Task: '.$data['pendingTasks'].'</h3>
                                    <h3>No. of Leaves : '.$data['leaves'].'</h3>
                                    <h2  align="center">Copyright © EMAS 2022</h2>
 ');
       // $pdf = PDF::loadView('admin.employees.productivity',$data);
       return $pdf->download('Nicesnippets.pdf');

    }
}
