@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Task</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Add Task
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
                <div class="col-lg-6 col-md-8 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="text-center mt-2">Add new Task</h5>
                        </div>
                        @include('messages.alerts')
                        <form action="{{ route('admin.task.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">

                                <fieldset>
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                        @error('title')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Deadline</label>
                                        <input type="text" name="deadline" id="dob" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Assignee</label>
                                            <select name="assignee" class="form-control">
                                                <option hidden disabled selected value> -- select an option -- </option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        @if (old('assignee') == $employee->id) selected @endif>
                                                        {{ $employee->first_name . ' ' . $employee->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assignee')
                                                <div class="text-danger">
                                                    Please select a valid option
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </fieldset>


                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-flat btn-primary"
                                    style="width: 40%; font-size:1.3rem">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
@endsection

@section('extra-js')
    <script>
        $().ready(function() {
            if ('{{ old('deadline') }}') {
                const dob = moment('{{ old('deadline') }}', 'DD-MM-YYYY');
                console.log('{{ old('deadline') }}')
                $('#dob').daterangepicker({
                    "startDate": dob,
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "DD-MM-YYYY"
                    }
                });
                $('#join_date').daterangepicker({
                    "startDate": join_date,
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "DD-MM-YYYY"
                    }
                });
            } else {
                console.log('{{ date('d-m-Y') }}');
                $('#dob').daterangepicker({
                    "startDate": moment('{{ date('d-m-Y') }}', 'DD-MM-YYYY'),
                    "minDate": moment('{{ date('d-m-Y') }}', 'DD-MM-YYYY'),
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "DD-MM-YYYY"
                    }
                });
                $('#join_date').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "locale": {
                        "format": "DD-MM-YYYY"
                    }
                });
            }

        });
    </script>
@endsection
