<?php namespace App\Http\Middleware;
use Mail;
use Closure;
use Illuminate\Support\Facades\Auth;


class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {    
        
        $user = Auth::user();
        // otp_expiration is initially older than any present time
        // Therefore it is inherently smaller in value than any Carbon::now()
        // When the otp_expiration is greater than the present time is the 
        // System ensured that the user session is already otp-verified
        // ( Becauses the otp_expiration is later on altered after a successful)
        // OTP entry verification
        if($user->otp_expiration > \Carbon\Carbon::now()){
            return $next($request);
        } 
        // Get code between 4 to 6 digits long
        $user->otp = mt_rand(1000,999999);
        $user->save();        
        
        // Send otp as a message
        $this->send_message($user->otp,$user->email,$user->name);
        return redirect('/otp_form')->with('success_sent','We have sent a one-time-pin for your login. Please check your email for the pin.');  
    }

    public function send_message($otp,$email,$name)
    {
        // Data to be used in mail
        $data = array(
            'otp'=>$otp,
            'email'=>$email,
            'name'=>'sofat'
        );
        Mail::send('auth.otp_message',$data, function($message) use ($email,$name){
            $message->from('noreplies@just.no', 'ServicesKport');
            $message->to($email, $name)->subject('Welcome back!');
        });
    }
}