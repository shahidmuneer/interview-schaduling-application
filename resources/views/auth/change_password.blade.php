@extends('layouts.app')

@section('content')
    <h3 class="page-title">Change password</h3>

    @if(session('success'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @else
        {!! Form::open()->method("PATCH")->route("auth.change_password") !!}
        <!-- If no success message in flash session show change password form  -->
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('quickadmin.qa_edit')
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 form-group">
                       {!! Form::text('current_password',"Current Password")->type("password") !!}
                     
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                    {!! Form::text('new_password',"New Password")->type("password") !!}
                     
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                    {!! Form::text('new_password_confirmation',"New Password Confirmation")->type("password") !!}
                     
                    </div>
                </div>
            </div>
        </div>
<input type="submit" class="btn btn-primary">
        {!! Form::close() !!}
    @endif
@stop

