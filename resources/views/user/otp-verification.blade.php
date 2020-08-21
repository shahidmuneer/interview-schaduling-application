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
                        <h1 class="form-heading">Add your mobile phone</h1>
                        <p style="padding:30px;">Linking your phone makes your account more secure. We will confirm your phone by sending it a code. More Info</p>
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

                             @if($errors->has('message'))
                                 <div class="alert alert-danger">{{$errors->first('message')}}</div>
                             @endif
                  
                    {!!Form::open()->route($route)!!}
                     <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                        <label class="show-password" >
                                <span class="time-span" id="time">
                                
                                </span>
                            </label>
                    {!!Form::text('otp', 'Code From SMS')->placeholder("Code From SMS")!!}
                        </div>
                    </div>
                    <input type="hidden" name="mobile" value="{{$mobile_number}}">
                    
                    
                      <div class="col col-lg-12 col-sm-12" >
                        <div class="col col-lg-12 col-sm-12" >
                            <input type="submit" class="btn btn-primary " style="width:100%;" value="NEXT">
                        </div>
                      </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    {!!Form::open()->route("user.add-mobile-number-post")->method("post")->id("mobileForm")!!}
        <input type="hidden" name="mobile_number" value="{{$mobile_number}}">
    {!!Form::close()!!}
    <script>
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    var interval=setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            display.innerHTML="<span id='resendCode'>Resend Code</span>";
            clearInterval(interval);
            timer = duration;
        }
    }, 1000);
}
window.onload = function () {
    var timeRemaining = {{$time_remaining}},
        display = document.querySelector('#time');
    startTimer(timeRemaining, display);
};
document.addEventListener('click',function(e){
    if(e.target && e.target.id== 'resendCode'){
        document.getElementById("mobileForm").submit();
     }
 });
    </script>
@endsection