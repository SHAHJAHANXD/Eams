@extends('layouts.app')

@section('content')
    <style>

    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Task</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('employee.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Task
                        </li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="text-center mt-2">Task</h5>
                        </div>
                        <div class="card-body">
                            @include('messages.alerts')
                            <div align="center">
                                <p id="message"></p>
                            </div>
                            <table class="table profile-table table-hover">
                                <tr>
                                    <td>Title</td>
                                    <td>{{ $task->title }}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>{{ $task->description }}</td>
                                </tr>
                                <tr>
                                    <td>Deadline</td>
                                    <td>{{ $task->deadline }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>
                                        {{-- <select  id="status" name="status">
                                        <option  @if ($task->status == 'To do') selected @endif value="To do">To do</option>
                                        <option  @if ($task->status == 'In progress') selected @endif value="In progress">Work In progress</option>
                                        <option  @if ($task->status == 'Ready to QA') selected @endif value="Ready to QA">Ready to QA</option>
                                        <option  @if ($task->status == 'QA in progress') selected @endif value="QA in progress">QA in progress</option>
                                        <option  @if ($task->status == 'Completed') selected @endif value="Completed">Completed</option>
                                    </select> --}}
                                        <select id="select-statee" placeholder="Pick a state..." name="assignee">
                                            <option @if ($task->status == 'To do') selected @endif value="To do">To do
                                            </option>
                                            <option @if ($task->status == 'In progress') selected @endif value="In progress">
                                                Work In progress</option>
                                            <option @if ($task->status == 'Ready to QA') selected @endif value="Ready to QA">
                                                Ready to QA</option>
                                            <option @if ($task->status == 'QA in progress') selected @endif
                                                value="QA in progress">QA in progress</option>
                                            <option @if ($task->status == 'Completed') selected @endif value="Completed">
                                                Completed</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Assigned to</td>
                                    <td>
                                        {{-- <select id="assignee" name="assignee">
                                        @foreach ($task->employeeList as $row)
                                        <option  @if ($task->employee->id == $row->id) selected @endif value="{{$row->id}}">{{ $row->first_name.' '.$row->last_name }}</option>
                                        @endforeach
                                    </select> --}}
                                        <select id="select-state" placeholder="Pick a state..." name="assignee">
                                            <option value="">Select a Employee...</option>
                                            @foreach ($task->employeeList as $row)
                                                <option @if ($task->employee->id == $row->id)  @endif
                                                    value="{{ $row->id }}">{{ $row->first_name . ' ' . $row->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-center" style="height: 2rem">

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->

    <script>
        $("#assignee").on('change', function() {
            var val = $('#assignee').val();
            var task = {{ $task->id }}
            $.ajax({
                type: "POST",
                url: "{{ route('employees.change.assignee') }}",
                data: {
                    task: task,
                    assignee: val,
                    user: {{ $task->logged_in_user }}
                }
            }).done(function(o) {
                console.log(o.response);
                if (o.response == true) {
                    document.getElementById("message").innerHTML = "Assignee Changed Successfully.";
                    document.getElementById("message").style.color = 'green';
                    setTimeout(function() {
                        $('#message').html('');
                    }, 3000);
                } else {
                    document.getElementById("message").innerHTML = "Failed to change assignee.";
                    document.getElementById("message").style.color = 'red';
                    setTimeout(function() {
                        $('#message').html('');
                    }, 3000);
                }

            });
        });

        $("#status").on('change', function() {
            var val = $('#status').val();
            var task = {{ $task->id }}
            $.ajax({
                type: "POST",
                url: "{{ route('employees.change.status') }}",
                data: {
                    task: task,
                    status: val,
                    user: {{ $task->logged_in_user }}
                }
            }).done(function(o) {
                console.log(o.response);
                if (o.response == true) {
                    document.getElementById("message").innerHTML = "Status Changed Successfully.";
                    document.getElementById("message").style.color = 'green';
                    setTimeout(function() {
                        $('#message').html('');
                    }, 3000);
                } else {
                    document.getElementById("message").innerHTML = "Failed to change status.";
                    document.getElementById("message").style.color = 'red';
                    setTimeout(function() {
                        $('#message').html('');
                    }, 3000);
                }

            });
        });
    </script>
    <script>
        new TomSelect("#select-state", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
    <script>
        new TomSelect("#select-statee", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endsection
