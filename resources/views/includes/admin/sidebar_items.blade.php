<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-users color-white m-r-10"></i>
        <p class="color-white">
            Employees
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.employees.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white"> Add Employee</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.employees.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">List Employees</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.employees.attendance') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Employee Attendance</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-user-cog color-white m-r-10"></i>
        <p class="color-white">
            View Productivity
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    @php
        $employee = App\Employee::get();
    @endphp
    <ul class="nav nav-treeview">

        @foreach ($employee as $employee)
            <li class="nav-item">
                <a href="/admin/employees/productivity/{{ $employee->user_id }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="color-white">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                </a>
            </li>
        @endforeach

    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-user-cog color-white m-r-10"></i>
        <p class="color-white">
            Key Stroks
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    @php
        $employee = App\Employee::get();
    @endphp
    <ul class="nav nav-treeview">

        @foreach ($employee as $employee)
            <li class="nav-item">
                <a href="/admin/employees/key-storking/{{ $employee->user_id }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="color-white">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                </a>
            </li>
        @endforeach

    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-tasks color-white m-r-10"></i>
        <p class="color-white">
            Tasks
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.task.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Add Task</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.task.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">List Tasks</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="fas fa-lock color-white m-r-10 "></i>
        <p class="color-white">
            Authorization
            <i class="fas fa-angle-left right"></i>
            {{-- <span class="badge badge-info right">2</span> --}}
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.leaves.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Leaves</p>
            </a>
        </li>
        {{-- <li class="nav-item"> --}}
        {{-- <a --}}
        {{-- href="{{ route('admin.expenses.index') }}" --}}
        {{-- class="nav-link" --}}
        {{-- > --}}
        {{-- <i class="far fa-circle nav-icon"></i> --}}
        {{-- <p class="color-white">Expenses</p> --}}
        {{-- </a> --}}
        {{-- </li> --}}
    </ul>
</li>
{{-- <li class="nav-item has-treeview"> --}}
{{-- <a href="#" class="nav-link"> --}}
{{-- <i class="nav-icon fa fa-calendar-minus-o"></i> --}}
{{-- <p class="color-white"> --}}
{{-- Holidays --}}
{{-- <i class="fas fa-angle-left right"></i> --}}
{{-- <span class="badge badge-info right">2</span> --}}
{{-- </p> --}}
{{-- </a> --}}
{{-- <ul class="nav nav-treeview"> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('admin.holidays.create') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">Add Holiday</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('admin.holidays.index') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">List Holidays</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- </ul> --}}
{{-- </li> --}}

<li class="nav-item has-treeview">
    <a href="{{ route('admin.monitoring.index') }}" class="nav-link">
        <i class="fas fa-chart-line color-white m-r-10"></i>
        <p class="color-white">
            Activity Monitoring
        </p>
    </a>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link" @if (Auth::user()->status == 1) target="_block" @endif>
        <i class="fas fa-tasks color-white m-r-10"></i>
        <p class="color-white">
            Meetings
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/admin/chat-with/2" @if (Auth::user()->status == 1) target="_block" @endif
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Chat</p>
            </a>
        </li>
        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif href="/admin/zoom-meeting"
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white"> Zoom Meeting</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="/admin/logout" class="nav-link">
        <i class="fas fa-power-off color-white m-r-10"></i>
        <p class="color-white">
            Sign Out
        </p>
    </a>
</li>
