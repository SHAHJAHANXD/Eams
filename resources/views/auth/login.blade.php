@extends('layouts.app')
@section('content')
    <style>
        body {
            flex: auto !important;
            align-items: revert !important;
        }

        .card {
            min-height: 400px;
            min-width: 500px;
            border-radius: 22px;
        }

        .card-body {
            border-radius: 40px;
        }

        .btn-primary {
            color: #fff;
            background-color: #000238;
            border-color: #000238;
        }

        .text-primary {
            color: #000238 !important;
        }

    </style>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-8 container">
                    <div class="card">
                        <div class="card-body login-card-body container">
                            <h4 class="text-center text-primary " style="margin-bottom: 40px">Welcome Admin</h4>

                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="row">

                                    <label>Email</label>
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required placeholder="Email"
                                                autocomplete="email" autofocus />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <label>Password</label>
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" name="password" required
                                                autocomplete="current-password" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 40px">
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Log In
                                        </button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            @if (Route::has('password.request'))
                                <p class="mb-1">
                                    <a href="{{ route('password.request') }}">I forgot my password</a>
                                </p>
                            @endif
                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.login-box -->
@endsection
