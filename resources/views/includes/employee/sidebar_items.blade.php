<li class="nav-item has-treeview">
    <a href="#" class="nav-link" @if (Auth::user()->status == 1) target="_block" @endif>
        <i class="fas fa-clipboard color-white m-r-10"></i>
        <p class="color-white">
            Attendance
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">2</span>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- <li class="nav-item"> --}}
        {{-- <a --}}
        {{-- href="{{ route('employee.attendance.create') }}" --}}
        {{-- class="nav-link" --}}
        {{-- > --}}
        {{-- <i class="far fa-circle nav-icon"></i> --}}
        {{-- <p class="color-white">Attendance for Today</p> --}}
        {{-- </a> --}}
        {{-- </li> --}}
        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif
                href="{{ route('employee.attendance.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">List of Attendances</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link" @if (Auth::user()->status == 1) target="_block" @endif>
        <i class="fas fa-tasks color-white m-r-10"></i>
        <p class="color-white">
            Tasks
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif href="{{ route('employee.task.index') }}"
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">List Tasks</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link" @if (Auth::user()->status == 1) target="_block" @endif>
        <i class="fas fa-tasks color-white m-r-10"></i>
        <p class="color-white">
            Leaves
            <i class="fas fa-angle-left right"></i>
            <span class="badge badge-info right">2</span>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('employee.leaves.create') }}" @if (Auth::user()->status == 1) target="_block" @endif
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Apply for a Leave</p>
            </a>
        </li>
        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif href="{{ route('employee.leaves.index') }}"
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">List of Leaves</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link" @if (Auth::user()->status == 1) target="_block" @endif>
        <i class="fas fa-user-cog color-white m-r-10"></i>
        <p class=" color-white">
            View Productivity
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    @php
        $id = Auth::guard('web')->user()->id;
    @endphp
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif
                href="/employee/productivity/{{ $id }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">{{ Auth::guard('web')->user()->name }}'s Productivity </p>
            </a>
        </li>

    </ul>
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
            <a href="/employee/chat-with/1" @if (Auth::user()->status == 1) target="_block" @endif
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white">Chat</p>
            </a>
        </li>
        <li class="nav-item">
            <a @if (Auth::user()->status == 1) target="_block" @endif href="/employee/zoom-meeting"
                class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p class="color-white"> Zoom Meeting</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="/logout" class="nav-link">
        <i class="fas fa-power-off color-white m-r-10"></i>
        <p class="color-white">
            Sign Out
        </p>
    </a>
</li>
{{-- <li class="nav-item has-treeview"> --}}
{{-- <a href="#" class="nav-link"> --}}
{{-- <i class="nav-icon fa fa-calendar-minus-o"></i> --}}
{{-- <p class="color-white"> --}}
{{-- Expenses --}}
{{-- <i class="fas fa-angle-left right"></i> --}}
{{-- <span class="badge badge-info right">2</span> --}}
{{-- </p> --}}
{{-- </a> --}}
{{-- <ul class="nav nav-treeview"> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('employee.expenses.create') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">Claim Expense</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('employee.expenses.index') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">List of Expenses</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- </ul> --}}
{{-- </li> --}}
{{-- <li class="nav-item has-treeview"> --}}
{{-- <a href="#" class="nav-link"> --}}
{{-- <i class="nav-icon fa fa-address-card"></i> --}}
{{-- <p class="color-white"> --}}
{{-- Self --}}
{{-- <i class="fas fa-angle-left right"></i> --}}
{{-- <span class="badge badge-info right">3</span> --}}
{{-- </p> --}}
{{-- </a> --}}
{{-- <ul class="nav nav-treeview"> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('employee.self.salary_slip') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">Generate Salary slip</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- <li class="nav-item"> --}}
{{-- <a --}}
{{-- href="{{ route('employee.self.holidays') }}" --}}
{{-- class="nav-link" --}}
{{-- > --}}
{{-- <i class="far fa-circle nav-icon"></i> --}}
{{-- <p class="color-white">Holiday List</p> --}}
{{-- </a> --}}
{{-- </li> --}}
{{-- </ul> --}}
{{-- </li> --}}
