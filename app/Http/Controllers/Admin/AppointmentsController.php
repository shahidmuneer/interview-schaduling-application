<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentsRequest;
use App\Http\Requests\Admin\StoreAppointmentsSettingsRequest;
use App\Http\Requests\Admin\UpdateAppointmentsRequest;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of Appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('appointment_access')) {
            return abort(401);
        }
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        $appointments = Appointment::with(["employee"])->get();

        return view('admin.appointments.index', compact('appointments'));
    }
    public function settings(){
        if (! Gate::allows('appointment_access')) {
            return abort(401);
        }
        // $data=file_get_contents(storage_path("/app/private/settings"));
        // $data=json_decode($data);

        // $data=file_get_contents(storage_path("/app/private/settings"));
        // $data=json_decode($data);
       
        
        
        return view("admin.appointments.settings");

    }
    
    
    private function addMinutesToTime($time,$minutes){
        
        return date("g:i a", strtotime($time)+($minutes*60) );
    }

    private function convertToAlias($time){
        return date("g:i a", strtotime($time));
    }
    private function getNextDay($date){
        return date("d-m-Y",strtotime($date."+1 days"));
    }
    private function checkIfWeekend($curdate){
        $mydate=getdate(strtotime($curdate));
        $weekend=false;
    switch($mydate['wday']){
        case 0: // sun
            $weekend=true;
            break;
        case 1: 
        case 2:    
        case 3:
        case 4:
        case 5:
        case 6: // sat
            $weekend=true;
            break;
    }
    return $weekend;
    }

    public function storeSettings(StoreAppointmentsSettingsRequest $request){

        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        // file_put_contents(storage_path("/app/private/settings"),json_encode($request->all()));
        $from_date=date("d-m-Y",strtotime($request->input("from_date")) );
        $to_date=date("d-m-Y",strtotime($request->input("to_date")) );
        $from_time=$request->input("from_time");
        $to_time=$request->input("to_time");
        $hours=$request->input("hours");
        \App\Settings::truncate();
        \App\AppointmentsSetting::truncate();

       $settings= \App\Settings::create([
            "from_date"=>$request->input("from_date"),
            "to_date"=>$request->input("to_date"),
            "from_time"=>$request->input("from_time"),
            "to_time"=>$request->input("to_time"),
            "hours"=>$request->input("hours")
        ]);
        $dates=[];
        for($date=$from_date;strtotime($date)<=strtotime($to_date);$date=$this->getNextDay($date) ){
            // $dates[]=["date"=>$date,"status"=>""];
          
            for($time=$from_time;
            date("H:i",strtotime($time))<=date("H:i",strtotime($to_time));
                $time=$this->addMinutesToTime($time,(int)$request->input("hours")) ){
                    \App\AppointmentsSetting::create([
                        "date"=>date("Y-m-d",strtotime($date)),
                        "time"=>$time,
                        "setting_id"=>$settings->id
                    ]);
                    // $dates[]=["date"=>$date,"time"=>$time];
            }
        }
        // dd($dates);

        return redirect()->route('admin.appointments.index')->withErrors(["message"=>"Settings Saved Successfully!"]);
    }

    /**
     * Show the form for creating new Appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        $relations = [
            'clients' => \App\Client::get(),
            'employees' => \App\Employee::get(),
			'services' => \App\Service::get(),
        ];

        return view('admin.appointments.create', $relations);
    }

    /**
     * Store a newly created Appointment in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentsRequest $request)
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }
		$employee = \App\Employee::find($request->employee_id);
		$working_hours = \App\WorkingHour::where('employee_id', $request->employee_id)->whereDay('date', '=', date("d", strtotime($request->date)))->whereTime('start_time', '<=', date("H:i", strtotime("".$request->starting_hour.":".$request->starting_minute.":00")))->whereTime('finish_time', '>=', date("H:i", strtotime("".$request->finish_hour.":".$request->finish_minute.":00")))->get();
		if(!$employee->provides_service($request->service_id)) return redirect()->back()->withErrors("This employee doesn't provide your selected service")->withInput();
        if($working_hours->isEmpty()) return redirect()->back()->withErrors("This employee isn't working at your selected time")->withInput();
		$appointment = new Appointment;
		$appointment->client_id = $request->client_id;
		$appointment->employee_id = $request->employee_id;
		$appointment->start_time = "".$request->date." ".$request->starting_hour .":".$request->starting_minute.":00";
		$appointment->finish_time = "".$request->date." ".$request->finish_hour .":".$request->finish_minute.":00";
		$appointment->comments = $request->comments;
		$appointment->save();



        return redirect()->route('admin.appointments.index');
    }


    /**
     * Show the form for editing Appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }
        $relations = [
            'clients' => \App\Client::get()->pluck('first_name', 'id')->prepend('Please select', ''),
            'employees' => \App\Employee::get()->pluck('first_name', 'id')->prepend('Please select', ''),
        ];

        $appointment = Appointment::findOrFail($id);

        return view('admin.appointments.edit', compact('appointment') + $relations);
    }

    /**
     * Update Appointment in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentsRequest $request, $id)
    {
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());



        return redirect()->route('admin.appointments.index');
    }


    /**
     * Display Appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        if (! Gate::allows('appointment_view')) {
            return abort(401);
        }
        

        $appointment = Appointment::with(["employee","employee.refs","employee.address"])->findOrFail($id);
// dd($appointment->employee->Address);
        return view('admin.appointments.show', compact('appointment'));
    }


    /**
     * Remove Appointment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Delete all selected Appointment at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Appointment::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
