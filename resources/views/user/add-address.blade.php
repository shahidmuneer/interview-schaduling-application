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
                        <h1 class="form-heading">Enter Your Address</h1>
                        <p style="padding:30px;">Please enter your primary address. This is required verify you identity</p>
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
                    {!!Form::text('address_1', 'Address 1')->placeholder("e.g., 111 William S Canning Bivd")->id("autocompleteAddress1")!!}
                        </div>
                    </div>

                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('address_2', 'Address 2')->placeholder("Apt., suite, or floor (optional)")->id("autocompleteAddress2")!!}
                        </div>
                    </div>

                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('city_town', 'City/Town/Subdivision')->placeholder("City/Town/Subdivision")->id("city_town")!!}
                        </div>
                    </div>

                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                        {!!Form::select('state', 'Select')->options($states)->id("states")!!}
                            </div>
                    </div>
                    
                    <div class="col col-lg-12 col-sm-12">
                        <div class="col col-lg-12 col-sm-12">
                    {!!Form::text('zip_code', 'Zip Code')->type("number")->placeholder("Zip Code")->id("zipcode")!!}
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