@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Profile
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
                            <h5 class="text-center mt-2">My Profile</h5>
                        </div>
                        @foreach ($data as $admin)
                            <form action="/admin/profile/{{ $admin->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <fieldset>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" value="{{ $admin->name }}"
                                                class="form-control">
                                            @error('first_name')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" name="email" readonly value="{{ $admin->email }}"
                                                class="form-control">
                                            @error('last_name')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Photo</label>
                                            <input type="file" name="photo" class="form-control-file">
                                            @error('photo')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </fieldset>


                                </div>
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-flat btn-primary"
                                        style="width: 40%; font-size:1.3rem">Save</button>
                                </div>
                            </form>
                        @endforeach

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
            dob = new Date('{{ $admin->dob }}');
            joinDate = new Date('{{ $admin->join_date }}');
            $('#dob').daterangepicker({
                "singleDatePicker": true,
                "startDate": dob,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
            $('#join_date').daterangepicker({
                "singleDatePicker": true,
                "startDate": joinDate,
                "locale": {
                    "format": "DD-MM-YYYY"
                }
            });
        });
    </script>
@endsection
