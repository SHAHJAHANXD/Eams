<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Key_stork;
use App\laravel_logger_activity;
use App\Leave;
use App\messageChat;
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
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = [
            'employees' => Employee::all()
        ];
        return view('admin.employees.index')->with($data);
    }
    public function chat($id)
    {
        $user_id = Auth::user()->id;

        $room_dev = messageChat::orderBy('id', 'asc')->get();


        $users = messageChat::where('sender_id', $user_id)->orWhere('receiver_id', $user_id)->get();

        $user = User::where('id', '<>', Auth::id())->get();

        $username = User::where('id', $id)->first();
        $userNames = User::where('id', $id)->get();
        return view('employee.chat', compact('user', 'users', 'username', 'userNames', 'room_dev'))->with([$id]);
    }
    public function chats($id)
    {
        $user_id = Auth::user()->id;

        $room_dev = messageChat::orderBy('id', 'asc')->get();


        $users = messageChat::where('sender_id', $user_id)->orWhere('receiver_id', $user_id)->get();

        $user = User::where('id', '<>', Auth::id())->get();

        $username = User::where('id', $id)->first();
        $userNames = User::where('id', $id)->get();
        return view('admin.chat', compact('user', 'users', 'username', 'userNames', 'room_dev'))->with([$id]);
    }
    public function create()
    {
        $data = [
            'departments' => Department::all(),
            'desgs' => ['Manager', 'Assistant Manager', 'Deputy Manager', 'Clerk']
        ];
        return view('admin.employees.create')->with($data);
    }

    public function store(Request $request)
    {
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
            'name' => $request->first_name . ' ' . $request->last_name,
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
            $filename_store = $filename . '_' . time() . '.' . $ext;
            // UPLOAD IMAGE
            // $path = $request->file('photo')->storeAs('public'.DIRECTORY_SEPARATOR.'employee_photos', $filename_store);
            // add new file name
            $image = $request->file('photo');
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(300, 300);
            $image_resize->save(public_path(DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'employee_photos' . DIRECTORY_SEPARATOR . $filename_store));
            $employeeDetails['photo'] = $filename_store;
        }

        Employee::create($employeeDetails);

        $request->session()->flash('success', 'Employee has been successfully added');
        return back();
    }

    public function attendance(Request $request)
    {
        $data = [
            'date' => null
        ];
        if ($request->all()) {
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

    public function attendanceByDate($date)
    {
        $employees = DB::table('employees')->select('id', 'first_name', 'last_name', 'desg', 'department_id')->get();
        $attendances = Attendance::all()->filter(function ($attendance, $key) use ($date) {
            return $attendance->created_at->dayOfYear == $date->dayOfYear;
        });
        return $employees->map(function ($employee, $key) use ($attendances) {
            $attendance = $attendances->where('employee_id', $employee->id)->first();
            $employee->attendanceToday = $attendance;
            $employee->department = Department::find($employee->department_id)->name;
            return $employee;
        });
    }

    public function destroy($employee_id)
    {
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

    public function attendanceDelete($attendance_id)
    {
        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->delete();
        request()->session()->flash('success', 'Attendance record has been successfully deleted!');
        return back();
    }

    public function employeeProfile($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        return view('admin.employees.profile')->with('employee', $employee);
    }

    public function employeeProductivity($employee_id)
    {
        $data['employee'] = Employee::findOrFail($employee_id);
        // $data['employee'] = Employee::where('user_id',$employee_id)->first();
        $key = laravel_logger_activity::where('userId', $employee_id)->count();
        $data['dataset'] = array();
        $data['completedTasks'] = count(Task::where('status', 'Completed')->where('assignee', $employee_id)->get());
        $data['pendingTasks'] = count(Task::where('status', '!=', 'Completed')->where('assignee', $employee_id)->get());
        $data['leaves'] = count(Leave::whereYear('created_at', date('Y'))->get());
        $data['totalTasks'] = count(Task::where('assignee', $employee_id)->get());
        $tasks = collect();
        $tasks->jan = 0;
        $tasks->feb = 0;
        $tasks->mar = 0;
        $tasks->apr = 0;
        $tasks->may = 0;
        $tasks->jun = 0;
        $tasks->jul = 0;
        $tasks->aug = 0;
        $tasks->sep = 0;
        $tasks->oct = 0;
        $tasks->nov = 0;
        $tasks->dec = 0;
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '01')->get();
        $tasks->jan = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '02')->get();
        $tasks->feb = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '03')->get();
        $tasks->mar = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '04')->get();
        $tasks->apr = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '05')->get();
        $tasks->may = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '06')->get();
        $tasks->jun = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '07')->get();
        $tasks->jul = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '08')->get();
        $tasks->aug = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '09')->get();
        $tasks->sep = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '10')->get();
        $tasks->oct = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '11')->get();
        $tasks->nov = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '12')->get();
        $tasks->dec = count($jan);
        $val['tasks'] = $tasks;
        $val['employee'] = $data['employee']->first_name . " " . $data['employee']->last_name;
        $val['color'] = "rgb(255,51,51,.50)";
        array_push($data['dataset'], $val);

        $users = Key_stork::select(DB::raw("COUNT(*) as count"))
            ->where('user_id', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = Key_stork::select(DB::raw("Month(created_at) as month"))
            ->where('user_id', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');
        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month] = $users[$index];
        }
        $users = Task::select(DB::raw("COUNT(*) as count"))
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = Task::select(DB::raw("Month(created_at) as month"))
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');
        $datass = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datass[$month] = $users[$index];
        }


        $users = Task::select(DB::raw("COUNT(*) as count"))
            ->where('status', 'Completed')
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = Task::select(DB::raw("Month(created_at) as month"))
            ->where('status', 'Completed')
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');
        $com_task = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $com_task[$month] = $users[$index];
        }

        $users = Task::select(DB::raw("COUNT(*) as count"))
            ->where('status', '!=', 'Completed')
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = Task::select(DB::raw("Month(created_at) as month"))
            ->where('status', '!=', 'Completed')
            ->where('assignee', $employee_id)
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('month');
        $pen_task = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $pen_task[$month] = $users[$index];
        }


        return view('admin.employees.productivity', compact('key', 'datas', 'datass', 'com_task', 'pen_task'))->with($data);
    }
    public function pdfcreate($employee_id)
    {
        $data['employee'] = Employee::where('user_id', $employee_id)->first();

        $data['dataset'] = array();
        $data['completedTasks'] = count(Task::where('status', 'Completed')->where('assignee', $employee_id)->get());
        $data['pendingTasks'] = count(Task::where('status', '!=', 'Completed')->where('assignee', $employee_id)->get());
        $data['leaves'] = count(Leave::whereYear('created_at', date('Y'))->get());
        $data['totalTasks'] = count(Task::where('assignee', $employee_id)->get());
        $tasks = collect();
        $tasks->jan = 0;
        $tasks->feb = 0;
        $tasks->mar = 0;
        $tasks->apr = 0;
        $tasks->may = 0;
        $tasks->jun = 0;
        $tasks->jul = 0;
        $tasks->aug = 0;
        $tasks->sep = 0;
        $tasks->oct = 0;
        $tasks->nov = 0;
        $tasks->dec = 0;
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '01')->get();
        $tasks->jan = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '02')->get();
        $tasks->feb = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '03')->get();
        $tasks->mar = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '04')->get();
        $tasks->apr = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '05')->get();
        $tasks->may = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '06')->get();
        $tasks->jun = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '07')->get();
        $tasks->jul = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '08')->get();
        $tasks->aug = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '09')->get();
        $tasks->sep = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '10')->get();
        $tasks->oct = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '11')->get();
        $tasks->nov = count($jan);
        $jan = Task::where('assignee', $employee_id)->whereMonth('created_at', '=', '12')->get();
        $tasks->dec = count($jan);
        $val['tasks'] = $tasks;
        $val['employee'] = $data['employee']->first_name . " " . $data['employee']->last_name;
        $val['color'] = "rgb(255,51,51,.50)";
        array_push($data['dataset'], $val);
        $pdf = PDF::loadHtml('

        <style>
        html
        {
            background: skyblue;
        }
        body
        {
            background: skyblue;
        }
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: center;
          padding: 8px;
        }


        </style>

        <h1 align="center">EAMS</h1>
        <h1 align="center">Employee Productivity Report</h1>
                                    <h2 align="center">Employee Name: ' . $val['employee'] . '</h2>
                                    <h2 align="center">Role: Employee</h2>
                                    <h2 align="center">Date: ' . Carbon::now()->format('m-d-Y') . '</h2>
                                    <table>
                                        <tr>
                                            <th>Total Assigned Task</th>
                                            <th>Completed Tasks</th>
                                            <th>Total Pending Task</th>
                                            <th>No. of Leaves</th>
                                        </tr>
                                        <tr>
                                        <td>' . $data['totalTasks'] . '</td>
                                        <td>' . $data['completedTasks'] . '</td>
                                        <td>' . $data['pendingTasks'] . '</td>
                                        <td>' . $data['leaves'] . '</td>
                                      </tr>
                                    </table>
                                    <h1 align="center" style="margin-bottom: auto;">Copyright © EMAS 2022</h1>

 ');
        // $pdf = PDF::loadView('admin.employees.productivity',$data);
        return $pdf->download('Nicesnippets.pdf');
    }
    public function monitoring()
    {
        $data = [
            'employees' => Employee::all()
        ];
        return view('admin.employees.monitoringListing')->with($data);
    }

    public function employeeMonitoring($employee_id)
    {

        $employee = Employee::find($employee_id);
        $monitoring = Monitoring::where('employee_id', $employee->user_id)->get();

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
