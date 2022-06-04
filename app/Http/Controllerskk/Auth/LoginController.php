<?php

namespace App\Http\Controllers\Auth;

use App\Attendance;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';
    public function redirectTo() {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return '/admin';
        }
        $attendance = new Attendance([
            'employee_id' =>  $employee = Auth::user()->employee->id,
            'entry_ip' => '284.3474.344',
            'entry_location' => 'Islamabad'
        ]);
        $attendance->save();
        return '/employee';
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(Request $request) {
        return redirect('/login');
    }
}
