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
                        <h1 class="form-heading">Create an account</h1>
                        <p style="padding:30px;">Please enter your name as it appears on official documents.</p>
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
                    {!!Form::open()->route("user.register")!!}
                  
                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-6 col-sm-12">
                    {!!Form::text('first_name', 'First Name')->placeholder("First Name")!!}
                        </div>
                        <div class="col col-lg-6 col-sm-12">
                    {!!Form::text('middle_name', 'Middle Name')->placeholder("Middle Name")!!}
                        </div>
                    </div>
                    
                     <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('last_name', 'Last Name')->placeholder("Last Name")!!}
                        </div>
                    </div>
                    
                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('email', 'Email Address')->placeholder("e.g..john@example.com")!!}
                        </div>
                    </div>
                    
<!--                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('mobile_number', 'Mobile Number')->placeholder("e.g..john@example.com")!!}
                        </div>
                    </div>-->
                    
                                        
                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                              <label class="show-password" >
                                <input type="checkbox" id="password-check" style="display:none;">
                                <span class="password-span">Show Password</span>
                            </label>
                    {!!Form::text('password', 'Password')->placeholder("Password")->type("password")->id("password")!!}
                          
                        </div>
                    </div>
                    
                    <div class="col col-lg-12 col-sm-12" style="padding:30px;">
                        <div class="col col-lg-12 col-sm-12 location-container" >
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1"><path d="M512 809.984q123.989333 0 210.986667-86.997333t86.997333-210.986667-86.997333-210.986667-210.986667-86.997333-210.986667 86.997333-86.997333 210.986667 86.997333 210.986667 210.986667 86.997333zM893.994667 470.016l88.021333 0 0 84.010667-88.021333 0q-13.994667 134.016-109.994667 230.016t-230.016 109.994667l0 88.021333-84.010667 0 0-88.021333q-134.016-13.994667-230.016-109.994667t-109.994667-230.016l-88.021333 0 0-84.010667 88.021333 0q13.994667-134.016 109.994667-230.016t230.016-109.994667l0-88.021333 84.010667 0 0 88.021333q134.016 13.994667 230.016 109.994667t109.994667 230.016zM512 342.016q70.016 0 120.021333 50.005333t50.005333 120.021333-50.005333 120.021333-120.021333 50.005333-120.021333-50.005333-50.005333-120.021333 50.005333-120.021333 120.021333-50.005333z"/></svg>
                                Your location is set to <strong class="location-city"></strong> <a href="#" id="edit-location" >Edit</span></a>
                        </div>
                    </div>
                    <div class="col col-lg-12 col-sm-12" >
                        <div class="col col-lg-12 col-sm-12" >
                        
                            <p>
                                <label>
                                <input type="checkbox" name="agreement">  By creating this account you agree to our User Agreement
                                    and Privacy Policy.
                                </label>
                            </p>
                            <p>
                             @if($errors->has('agreement'))
                                 <div class="invalid-feedback">{{$errors->first('agreement')}}</div>
                             @endif
                            </p>
                        </div>
                    </div>
                    
                      <div class="col col-lg-12 col-sm-12" >
                        <div class="col col-lg-12 col-sm-12" >
                            <input type="submit" class="btn btn-primary " style="width:100%;" value="create">
                        </div>
                      </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection