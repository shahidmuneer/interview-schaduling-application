@extends('layouts.public')

@section('content')
<style>
    
    body{
        background:white!important;
    }
</style>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel form-container">
                <!--<div class="panel-heading">{{ ucfirst(config('app.name')) }} Login</div>-->
                <div class="panel-body">
                    <center>
                        <img src="/images/logo.png" width="100">
                        <h1 class="form-heading">Schedule Your Interview</h1>
                        </center>
<!--                   @if(count($errors) > 0 )
                    <div class="alert alert-danger " role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="p-0 m-0" style="list-style: none;">
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif-->
                <center>

                    <img src="/images/success.png">
                    
                    <p><br>Thank You!</p>
                    <p>Our HR Manager will call you on {{$user->appointment->start_time??""}}<br>
                        according your timezone.</p>
                </center>

                             @if($errors->has('message'))
                                 <div class="alert alert-danger">{{$errors->first('message')}}</div>
                             @endif
                  
                </div>
            </div>
        </div>
    </div>
@endsection