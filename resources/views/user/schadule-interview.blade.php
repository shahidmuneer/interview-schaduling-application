@extends('layouts.public')

@section('content')
<style>
    
    body{
        background:white!important;
    }
</style>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel ">
                <!--<div class="panel-heading">{{ ucfirst(config('app.name')) }} Login</div>-->
                <div class="panel-body">
                    <center>
                        <img src="/images/logo.png" width="100">
                        <h1 class="form-heading">Schedule Your Interview</h1>
                        <p style="padding:30px;">Please choose the date and time convenient for you.</p>
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
                        <label>Date</label>
                            <p>
                        <div class="col col-lg-12 col-sm-12" >
                        <div class="">
    				<div id="radioBtn" class="row">
                    
                    @foreach($settings as $setting)
                    <div class="col col-lg-4 col-sm-4 col-xs-4">
                    <br>
    					<a class="btn btn-primary form-control date-input {{request()->input('date')==$setting->date?'active':''}}"
                         {{$setting->status==0?"disabled":""}}
                            href="{{route('user.schadule-interview',['date'=>$setting->date,'page'=>request()->input('page')])}}" 
                         {{request()->input('date')==$setting->date?'disabled':''}}

                         data-toggle="date" 
                        data-title="{{$setting->date}}">{{date('m-d-Y',strtotime($setting->date))}}</a>
                    </div>
                    @endforeach
                        <div class="col col-lg-12 col-sm-12 col-xs-12">
                        <br>
                        <center>
                        {{$settings->appends(request()->input())->links()}}
                        </center>
                        </div>
    				</div>
    			
                	<input type="hidden" name="date" id="date" value="{{request()->input('date')}}">
    			</div>
                        </div>
                            </p>
                        </div>
                    </div>





                    <div class="col col-lg-12 col-sm-12 row" >
                        <div class="col col-lg-12 col-sm-12" >
                        <br/>
                        <label>Time &ensp; &ensp; &ensp; *Choose time according your timezone</label>
                            <p>
                            
                        <div class="col col-lg-12 col-sm-12" >
                        <div class="">
    				<div id="radioBtn" class="row">
                   
                   @if(count($times)<1)
                    <div class="col col-lg-12 col-sm-12 col-xs-12">
    				    <p class="text-center">Kindly Select Any Time Slot on above</p>
                    </div>
                        @else
                    
                    @foreach($times as $time)
                    <div class="col col-lg-4 col-sm-4 col-xs-4">
                    <br>
    					<a class="btn btn-primary form-control {{$time->status=='occupied'?'occupied':''}}"
                        {{$time->status=='occupied'?'disabled':''}}
                         data-toggle="time" 
                                data-title="{{$time->time."|".$time->setting_id}}">{{$time->time}}</a>
                    </div>
                    @endforeach

                    @endif
                    

                

    				</div>
    				<input type="hidden" name="time" id="time" value="">
    			</div>
                        </div>
                            </p>
                        </div>
                    </div>




                      <div class="col col-lg-12 col-sm-12" >
                        <div class="col col-lg-12 col-sm-12" >
                        <br>
                            <input type="submit" value="create" class="btn btn-primary " style="width:100%;" value="NEXT">
                        </div>
                      </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection