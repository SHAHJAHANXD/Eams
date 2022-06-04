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
                <div class="col-md-6 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="text-center mt-2">My Profile</h5>
                        </div>
                        @foreach ($data as $admin)
                            <div class="card-body">
                                @include('messages.alerts')
                                <div class="row mb-3">
                                    <div class="col text-center mx-auto">
                                        <img src="/storage/admin_photos/{{ $admin->photo ?? '' }}"
                                            class="rounded-circle img-fluid" alt=""
                                            style="box-shadow: 2px 4px rgba(0,0,0,0.1)">
                                    </div>
                                </div>
                                <table class="table profile-table table-hover">
                                    <tr>
                                        <td>Name</td>
                                        <td>{{ $admin->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{ $admin->email }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/admin/profile-edit/{{ $admin->id }}" class="btn btn-flat btn-primary">Edit
                                    Profile</a>
                            </div>
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
