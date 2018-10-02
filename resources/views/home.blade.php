@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!--Details section-->
                    <h1>Welcome! Check out your details:</h1>
                    
                    <p>Name: <b>{{$user->name}}</b></p>
                    <p>Company: <b>{{$user->company}}</b></p>
                    <p>You were born a little <em>{{$user->gender}}</em> on the day of <b>{{$user->date_of_birth}}</b>.
                        Whether you live your existence in happiness or melancholy is entirely up to you. 
                    </p>
                    <p>Wouldn't it be nice to smile so easily? Live a life you can be proud of. </p>

                    <!--End Details-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
