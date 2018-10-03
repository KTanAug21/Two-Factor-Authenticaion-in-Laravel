<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use Auth;
use Session;
use App\User;
class OTPController extends Controller
{
    public function validateOTP(Request $request)
    {
        //$this->checkExpired(Auth::user()->otp_expiration);
        // Check if otp field is set
        $request->validate([
            'otp' => 'required',
        ]);
       
        // Session is otp-verified when entry matches with stored data
        if($request->input('otp') == Auth::user()->otp){  
            // Change otp_expiration to the present with added minutes from session life, signalling verified otp           
            $user = Auth::user();
            $user->otp_expiration = \Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
            $user->save();  
                 
            //Set session as otp ok
            Session::put('otp_verified', true);
            return redirect('/home')->with('success_login',"Welcome back.");
        } else {
            return redirect('/otp_form')->with('error_otp', 'Incorrect code.');
        }
    }


    public function showForm()
    {   
        return view('auth.otp_form');
    }  
   


    
    // Helper functions
    public function send_message($user)
    {
        $data = array(
            'otp' => $user->otp,
            'user' => $user
        );
        Mail::send('auth.otp_message', $data, function($message) use($user){
            $message->from('noreplies@just.no', 'What did I tell you.');
            $message->to($user->email, $user->name)->subject('Get your code.');
        });
    }
    public function reSend()
    {
        // Change user otp and otp_exp
        $user = Auth::user();
        $user->otp_expiration = \Carbon\Carbon::now();
        $user->save();

        // 4 to 6 digits long pin
        $user->otp = mt_rand(1000,999999);
        $user->save();  
        // Resend email
        $this->send_message($user);

        // Redirect to form with error message
        return redirect('otp_form')->with('otp_resend','OTP has been resent to your mail!');
    }

}
