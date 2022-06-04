@extends('layouts.app')

@section('content')
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
                            <a href="{{ route('admin.index') }}">Dashboard</a>
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
                                    <td>{{ $task->status }}</td>
                                </tr>
                                <tr>
                                    <td>Assigned to</td>
                                    <td>{{ $task->employee->first_name . ' ' . $task->employee->last_name }}</td>
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
@endsection
