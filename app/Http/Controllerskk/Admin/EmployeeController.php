<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Leave;
use App\Monitoring;
use App\Role;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Barryvdh\DomPDF\Facade\Pdf;

use function Ramsey\Uuid\v1;

class EmployeeController extends Controller
{
    public function index() {
        $data = [
            'employees' => Employee::all()
        ];
        return view('admin.employees.index')->with($data);
    }
    public function create() {
        $data = [
            'departments' => Department::all(),
            'desgs' => ['Manager', 'Assistant Manager', 'Deputy Manager', 'Clerk']
        ];
        return view('admin.employees.create')->with($data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'desg' => 'required',
            'department_id' => 'required',
            'salary' => 'required|numeric',
            'email' => 'required|email',
            'photo' => 'image|nullable',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $employeeRole = Role::where('name', 'employee')->first();
        $user->roles()->attach($employeeRole);
        $employeeDetails = [
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'sex' => $request->sex,
            'dob' => $request->dob,
            'join_date' => $request->join_date,
            'desg' => $request->desg,
            'department_id' => $request->department_id,
            'salary' => $request->salary,
            'photo'  => 'user.png'
        ];
        // Photo upload
        if ($request->hasFile('photo')) {
            // GET FILENAME
            $filename_ext = $request->file('photo')->getClientOriginalName();
            // GET FILENAME WITHOUT EXTENSION
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            // GET EXTENSION
            $ext = $request->file('photo')->getClientOriginalExtension();
            //FILNAME TO STORE
            $filename_store = $filename.'_'.time().'.'.$ext;
            // UPLOAD IMAGE
            // $path = $request->file('photo')->storeAs('public'.DIRECTORY_SEPARATOR.'employee_photos', $filename_store);
            // add new file name
            $image = $request->file('photo');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(public_path(DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'employee_photos'.DIRECTORY_SEPARATOR.$filename_store));
            $employeeDetails['photo'] = $filename_store;
        }

        Employee::create($employeeDetails);

        $request->session()->flash('success', 'Employee has been successfully added');
        return back();
    }

    public function attendance(Request $request) {
        $data = [
            'date' => null
        ];
        if($request->all()) {
            $date = Carbon::create($request->date);
            $employees = $this->attendanceByDate($date);
            $data['date'] = $date->format('d M, Y');
        } else {
            $employees = $this->attendanceByDate(Carbon::now());
        }
        $data['employees'] = $employees;
        // dd($employees->get(4)->attendanceToday->id);
        return view('admin.employees.attendance')->with($data);
    }

    public function attendanceByDate($date) {
        $employees = DB::table('employees')->select('id', 'first_name', 'last_name', 'desg', 'department_id')->get();
        $attendances = Attendance::all()->filter(function($attendance, $key) use ($date){
            return $attendance->created_at->dayOfYear == $date->dayOfYear;
        });
        return $employees->map(function($employee, $key) use($attendances) {
            $attendance = $attendances->where('employee_id', $employee->id)->first();
            $employee->attendanceToday = $attendance;
            $employee->department = Department::find($employee->department_id)->name;
            return $employee;
        });
    }

    public function destroy($employee_id) {
        $employee = Employee::findOrFail($employee_id);
        $user = User::findOrFail($employee->user_id);
        // detaches all the roles
        DB::table('leaves')->where('employee_id', '=', $employee_id)->delete();
        DB::table('attendances')->where('employee_id', '=', $employee_id)->delete();
        DB::table('expenses')->where('employee_id', '=', $employee_id)->delete();
        $employee->delete();
        $user->roles()->detach();
        // deletes the users
        $user->delete();
        request()->session()->flash('success', 'Employee record has been successfully deleted');
        return back();
    }

    public function attendanceDelete($attendance_id) {
        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->delete();
        request()->session()->flash('success', 'Attendance record has been successfully deleted!');
        return back();
    }

    public function employeeProfile($employee_id) {
        $employee = Employee::findOrFail($employee_id);
        return view('admin.employees.profile')->with('employee', $employee);
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
        return view('admin.employees.productivity')->with($data);
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
                                    <h2  align="center" style="margin-bottom:auto;">Copyright © EMAS 2022</h2>
 ');
       // $pdf = PDF::loadView('admin.employees.productivity',$data);
       return $pdf->download('Nicesnippets.pdf');

    }
    public function monitoring() {
        $data = [
            'employees' => Employee::all()
        ];
        return view('admin.employees.monitoringListing')->with($data);
    }

    public function employeeMonitoring($employee_id) {

        $employee = Employee::find($employee_id);
        $monitoring=Monitoring::where('employee_id',$employee->user_id)->get();

        return view('admin.employees.monitoringEmployee')->with('monitoring', $monitoring);
    }

    public function status0(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && $update_id > 0) {
            $userr = User::find($update_id);
            $userr->status = 0;
            $userr->save();
            return view('employee.end');
        }
    }
    public function status1(Request $request)
    {
        $update_id = $request->id;
        if (isset($update_id) && $update_id > 0) {
            $userr = User::find($update_id);
            $userr->status = 1;
            $userr->save();
            return view('employee.start');
        }
    }
}
