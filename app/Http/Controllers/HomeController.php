<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('two_factor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->gender == 'f')
        {
            $user->gender = 'girl';
        }else
        {
            $user->gender = 'boy';
        }

        $user->date_of_birth = date('F d, Y', strtotime($user->date_of_birth));


        return view('home')->with('user',$user);
    }
}
