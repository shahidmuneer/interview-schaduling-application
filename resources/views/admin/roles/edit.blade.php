@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.roles.title')</h3>
    
    {!! Form::open()->method("PUT")->route('admin.roles.update', ["role"=>$role->id])!!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group"> 
                {!!Form::text("title","Title")->value($role->title)!!}
                </div>
            </div>
            
        </div>
    </div>

    <input type="submit" class="btn btn-primary">
     {!! Form::close() !!}
@stop

