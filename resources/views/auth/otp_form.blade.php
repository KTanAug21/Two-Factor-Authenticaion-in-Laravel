@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Validate OTP') }}</div>
                <div class="card-body">
                    <!--Start OTP Form-->
                    <form method="POST" action="{{ route('otp_submit') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('Enter Pin') }}</label>
                            
                            <div class="col-md-6">
                            
                                <input id="otp" type="text" class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" name="otp" required>
                                @if ($errors->has('otp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link" href="{{ route('otp_resend') }}">
                                    {{ __('Lost Your Pin?') }}
                                </a>
                                
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
