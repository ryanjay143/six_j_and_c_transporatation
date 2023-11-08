<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Models\Truck;


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

       

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']] )) {
            $user = Auth::user();

            if ($user->is_disabled == 1) {
                // User is banned
                Auth::logout();
                Alert::error('Your account is Inactive. Please contact the administrator for assistance.', 'Account Disabled');
                return redirect()->route('index');
            }

            if ($user->type == 'admin') {
                return redirect()->route('admin.home');
            } elseif ($user->type == 'employee') {
                return redirect()->route('user.employee');
            } else {
                return redirect()->route('user.home');
            }
        } else {
            Alert::error("Email Address or Password are Incorrect", "If you don't have an account, please ask the Admin to create one for you.")
            ->showConfirmButton('OK', 'red');
            return redirect()->route('index');
        }
    }


}
