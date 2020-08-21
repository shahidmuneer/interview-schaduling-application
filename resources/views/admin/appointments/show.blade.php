@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.appointments.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>CANDIDATE PERSONAL DETAILS</th>
                        </tr>
                        
                        <tr>
                            <th>@lang('quickadmin.appointments.fields.employee')</th>
                            <td>{{ $appointment->employee->first_name or '' }}</td>
                        </tr>

                        <tr>
                            <th>Middle Name</th>
                            <td>{{ $appointment->employee->middle_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employees.fields.last-name')</th>
                            <td>{{ isset($appointment->employee) ? $appointment->employee->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>{{ isset($appointment->employee) ? $appointment->employee->mobile_number : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.appointments.fields.start-time')</th>
                            <td>{{ $appointment->start_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.appointments.fields.finish-time')</th>
                            <td>{{ $appointment->finish_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.appointments.fields.comments')</th>
                            <td>{!! $appointment->comments !!}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Address</th>
                        </tr>
                        <tr>
                            <th>Address 1</th>
                            <td>{{$appointment->employee->Address->address_1??""}}</td>
                        </tr>
                        <tr>
                            <th>Address 2</th>
                            <td>{{$appointment->employee->Address->address_2??""}}</td>
                        </tr>
                        <tr>
                            <th>City/Town</th>
                            <td>{{$appointment->employee->Address->city_town??""}}</td>
                        </tr>
                        
                        <tr>
                            <th>State</th>
                            <td>{{$appointment->employee->Address->state??""}}</td>
                        </tr>
                        <tr>
                            <th>Zip Code</th>
                            <td>{{$appointment->employee->Address->zip_code??""}}</td>
                        </tr>
                    </table>

                    
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Reference</th>
                        </tr>
                        <tr>
                            <th>Reference 1 Full Name </th>
                            <td>{{$appointment->employee->refs->full_name_ref_1??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 1 Phone Number</th>
                            <td>{{$appointment->employee->refs->phone_number_ref_1??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 1 Relationship</th>
                            <td>{{$appointment->employee->refs->relationship_ref_1??""}}</td>
                        </tr>

                        <tr>
                            <th>Reference 2 Full Name </th>
                            <td>{{$appointment->employee->refs->full_name_ref_2??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 2 Phone Number</th>
                            <td>{{$appointment->employee->refs->phone_number_ref_2??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 2 Relationship</th>
                            <td>{{$appointment->employee->refs->relationship_ref_2??""}}</td>
                        </tr>
                        
                        <tr>
                            <th>Reference 3 Full Name </th>
                            <td>{{$appointment->employee->refs->full_name_ref_3??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 3 Phone Number</th>
                            <td>{{$appointment->employee->refs->phone_number_ref_3??""}}</td>
                        </tr>
                        <tr>
                            <th>Reference 3 Relationship</th>
                            <td>{{$appointment->employee->refs->relationship_ref_3??""}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.appointments.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop