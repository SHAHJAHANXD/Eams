@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">List Key Storking</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.index') }}">Admin Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            List Key Storking
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <!-- general form elements -->
                    @include('messages.alerts')
                    @error('status')
                        <div class="alert alert-danger">
                            Choose a valid status option
                        </div>
                    @enderror
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">List Key Storking</h3>
                        </div>
                        <div class="card-body">

                            <table class="table table-hover" id="dataTable"
                                style="display: block; width: 100%; overflow-x: auto;">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">User Type</th>
                                        <th class="text-center">Route</th>
                                        <th class="text-center">Ip Address</th>
                                        <th class="text-center">User Agent</th>
                                        <th class="text-center">Locale</th>
                                        <th class="text-center">Referer</th>
                                        <th class="text-center">Method Type</th>
                                        <th class="text-center">Last Key Storking</th>
                                        <th class="text-center">Time Key Storking</th>
                                    </tr>
                                </thead>
                                @php
                                    $i = 1;
                                @endphp
                                <tbody>
                                    @foreach ($list as $key)
                                        <tr>
                                            <td class="text-center"> {{ $i++ }}</td>
                                            <td class="text-center">{{ $key->description }}</td>
                                            <td class="text-center">{{ $key->userType }}</td>
                                            <td class="text-center">{{ $key->route }}</td>
                                            <td class="text-center">{{ $key->ipAddress }}</td>
                                            <td class="text-center">{{ $key->userAgent }}</td>
                                            <td class="text-center">{{ $key->locale }}</td>
                                            <td class="text-center">{{ $key->referer }}</td>
                                            <td class="text-center">{{ $key->methodType }}</td>
                                            <td class="text-center">{{ $key->Key_storking }}</td>
                                            <td class="text-center">{{ $key->listed }}</td>
                                            <td class="text-center">{{ $key->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extra-js')
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
            $('.popover-dismiss').popover({
                trigger: 'focus'
            });
            $('#dataTable').DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 1
                    },
                    {
                        responsivePriority: 200000000000,
                        targets: -1
                    }
                ]
            });
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            });
        });
    </script>
@endsection
