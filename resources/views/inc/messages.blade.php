<!--Show messages-->
<div class="container">
    <div class="row justify-content-center">
        <!--Green Messages-->
        @if(session('success_sent'))
            <div class="alert alert-success">{{session('success_sent')}}</div>
        @endif
        @if(session('success_login'))
            <div class="alert alert-success">{{session('success_login')}}</div>
        @endif

        @if(session('otp_resend'))
            <div class="alert alert-success">{{session('otp_resend')}}</div>
        @endif
        <!--Red Messages-->
        @if(session('error_otp'))
            <div class="alert alert-danger">{{session('otp_error')}}</div>
        @endif
    </div>
</div>



