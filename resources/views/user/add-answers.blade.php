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
                        <h1 class="form-heading">Answer Few Questions</h1>
                        <p style="padding:30px;">Please answer a few questions. It helps us to know you better.</p>
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


                    <div class="col col-lg-12 col-sm-12 row" >
                        <div class="col col-lg-12 col-sm-12" >
                        <label>Are you currently employed?</label>
                            <p>
                            
                        <div class="col col-lg-12 col-sm-12" >
                        <div class="">
    				<div id="radioBtn" class="row">
                    <div class="col col-lg-6 col-sm-12">
    					<a class="btn btn-primary form-control active" data-toggle="happy" data-title="yes">YES</a>
                    </div>
                    <div class="col col-lg-6 col-sm-12">
    					<a class="btn btn-primary form-control notActive" data-toggle="happy" data-title="no">NO</a>
                    </div>
    				</div>
    				<input type="hidden" name="employment" id="happy" value="yes">
    			</div>
                        </div>
                            </p>
                        </div>
                    </div>


<br>

                    <div class="col col-lg-12 col-sm-12 row" >
                        <div class="col col-lg-12 col-sm-12" >
                        <br>
                        <label>Are you Resident of USA?</label>
                            <p>
                            
                        <div class="col col-lg-12 col-sm-12" >
                        <div class="">
    				<div id="radioBtn" class="row">
                    <div class="col col-lg-6 col-sm-12">
    					<a class="btn btn-primary form-control active" data-toggle="residence" data-title="yes">YES</a>
                    </div>
                    <div class="col col-lg-6 col-sm-12">
    					<a class="btn btn-primary form-control notActive" data-toggle="residence" data-title="no">NO</a>
                    </div>
    				</div>
    				<input type="hidden" name="residence" id="residence" value="yes">
    			</div>
                        </div>
                            </p>
                        </div>
                    </div>



                    
                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                        <br>
                    {!!Form::text('available_hours', 'What hours you are available?')->placeholder("9AM - 5PM, Monday to Friday")!!}
                        </div>
                    </div>

                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('good_fit', 'Why do you think you will be a good fit to our team?')->placeholder("Why do you think you will be a good fit to our team?")!!}
                        </div>
                    </div>

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
@endsection