<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\Truck;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }
    public function about()
    {
        return view('landing.about');
    }
    public function contact()
    {
        return view('landing.contact');
    }
    public function service()
    {
        return view('landing.service');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Check if the request originated from the modal login form
        // if ($request->query('modal_login')) {
        //     return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);
        // }
        return redirect()->route('admin.home');
    }

    

}
