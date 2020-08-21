@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.users.title')</h3>
    {!! Form::open()->method("post")->route("admin.users.store") !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    
                {!!Form::text("name","Name")!!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    
                {!!Form::text("email","Email")->type("email")!!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                     
                {!!Form::text("password","Password")->type("password")!!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                   
                    {!!Form::select('role_id', 'Role*')->options($roles)!!}
                </div>
            </div>
            
        </div>
    </div>

    <input type="submit" class="btn btn-primary">
    {!! Form::close() !!}
@stop

