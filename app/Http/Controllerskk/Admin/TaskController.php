<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\Notification;
use App\Role;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;

class TaskController extends Controller
{
    public function index() {
        $data = [
            'tasks' => Task::with('employee')->get()
        ];

        return view('admin.tasks.index')->with($data);
    }

    public function create() {
        $data = [
            'employees' => Employee::all(),
        ];
        return view('admin.tasks.create')->with($data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'assignee' => 'required',
            'deadline' => 'required',
        ]);
        $task=Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assignee' => $request->assignee,
            'status' => 'To do',
            'deadline' => Carbon::parse($request->deadline)->format('Y-m-d H:i:s'),
            'is_active' => true,
            'created_by'=>Auth::id()
        ])->id;

        Notification::create([
            'subject'=>'Task assigned to you by '.Auth::user()->name,
            'body'=>url('/employee/task/view/'.$task),
            'notification_to'=>$request->assignee,
            'notification_by'=>Auth::id(),
            'is_readed'=>false
        ]);

        $request->session()->flash('success', 'Task has been successfully added');
        return back();
    }
    public function viewTask($task_id) {
        $task = Task::findOrFail($task_id);
        return view('admin.tasks.view')->with('task', $task);
    }

    public function destroy($task_id) {
        $employee = Task::findOrFail($task_id);
        $employee->delete();
        request()->session()->flash('success', 'Task has been successfully deleted');
        return back();
    }

}
