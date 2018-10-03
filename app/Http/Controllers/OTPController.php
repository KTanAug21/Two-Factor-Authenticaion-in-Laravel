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
    
    public function showForm()
    {   
        // Cant access if already otp verified
        if(Session::get('otp_verified') )
        {
            return redirect('/home');
        }
        
        return view('auth.otp_form');
    }  
   
    public function validateOTP(Request $request)
    {
        $user = Auth::user();
        // Only allow otp validation with valid otp session
        if($this->checkExpired(Auth::user()->otp_expiration))
        {
        // Expired OTP
            // Delete OTP 
            $user->otp_expiration = null;
            $user->otp = null;
            $user->save();
            // Delet User Credentials
            Auth::logout();
            // Redirect to login
            return redirect('/login')->with('session_entry_exp', "Entry Session Expired!");
        }else{
        // OTP not expired
            // Check if otp field is set
            $request->validate([
                'otp' => 'required',
            ]);
        
            // Session is otp-verified when entry matches with stored data
            if($request->input('otp') == Auth::user()->otp){  
                // Change otp_expiration to the present with added minutes from session life, signalling verified otp           
                $user->otp_expiration = \Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
                $user->save();  
                    
                //Set session as otp ok
                Session::put('otp_verified', true);
                return redirect('/home')->with('success_login',"Welcome back.");
            } else {
                return redirect('/otp_form')->with('error_otp', 'Incorrect code.');
            }
        }
    }
    public function reSend()
    {
        // Cant access if already otp verified
        if(Session::get('otp_verified') )
        {
            return redirect('/home');
        }
        // Verify credentials first!
        if(Auth::user()==null)
        {
            return redirect('/login');
        }

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
    public function checkExpired($otp_expiration)
    {
        // Get time difference between present and time otp was added
        $time = \Carbon\Carbon::now();
        $diff = $time->diffInMinutes($otp_expiration);

        // OTP Expires after 25 minutes
        if($diff>=10)   
        {
            return true;    // Expired
        }else
        {
            return false;   // Still valid
        }
    }
}
