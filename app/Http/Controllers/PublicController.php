<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\otpVerificationRequest;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AnswerStoreRequest;
use App\Http\Requests\SchaduleStoreRequest;
use App\Http\Requests\ReferenceStoreRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }
    
    public  function createAccount(Request $request)
    {
        
        if(\Auth::check()){
            redirect("/redirect-user-to-pending-page");
        }
//        $user=new \App\User();
//        $user->run();
//        exit;
        return view("public.createAccount"); 
    }
    public function storeUserAccount(UserStoreRequest $request){
        $role=\App\Role::where("id",2)
                            ->first();
        $request->merge(["role_id"=>$role->id]);
        $user = \App\User::create($request->all());
        
        \Auth::login($user);

        return redirect("/redirect-user-to-pending-page");
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToPendingPage(){
        if(!\Auth::check()){
            return redirect("/")->withErrors(["message"=>"Login To continue"]);
        }
        if(!\Auth::user()->is_mobile_otp_verified){
            return redirect("/user/add-mobile-number");   
        }    
        if(!\Auth::user()->is_schedule_added){
            return redirect(route("user.schadule-interview"));
        }
        if(\Auth::user()->is_mobile_otp_verified){
            return redirect("/user/address/add-address");   
        }  
        

    }
    
    public function addMobileNumber(){

     return view("user.add-mobile-number")->with(['route'=>"user.add-mobile-number-post"]);   
    }
    public function addMobileNumberPost(Request $request){
        if(!\Auth::check()){
            redirect("/redirect-user-to-pending-page");
        }
        $validator=Validator::make($request->all(),[
            "mobile_number"=> 'required|unique:users,mobile_number'
        ]);
        
        $sent_otp_number=\App\Otp::where("mobile_number",$request->mobile_number)->orderBy("id","DESC")->first();
            if(!empty($sent_otp_number)){
                $time=strtotime($sent_otp_number->created_at);
                $time_remaining=$time-time();
                if($time_remaining<0){
                    \App\Otp::where("mobile_number",$request->mobile_number)
                                    ->where("id","<=",$sent_otp_number->id)
                                    ->delete();
                }
            }
        if($validator->fails()){
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $userClass=new \App\User();
        $valid=$userClass->validateNumber($request->mobile_number);
            if(!$valid){
                return redirect()->back()
                            ->withErrors(["mobile_number"=>"Mobile Number Verification Failed"])
                            ->withInput();
            }
            // $user=$userClass->find(\Auth::user()->id);
            // $user->mobile_number=$request->mobile_number;
            // $user->save();
            // \Auth::user($user);
        $userClass->sendOtp($request->mobile_number);

            return redirect("/user/mobile/otp-verification")
                ->withErrors(["message"=>"A code have been sent to provided mobile number please verify","mobile_number"=>$request->mobile_number]);
    }
    
    public function otpVerification(Request $request){
        
        $time_remaining=\Session::get("number_creation_time")-time();
            $errors=\Session::get("errors");
            // dd($errors);
            if(empty($errors)){
                    return redirect("/user/add-mobile-number");
            }
     return view("user.otp-verification")->with(['route'=>"user.otp-verification-post",
     "time_remaining"=>$time_remaining,
     "mobile_number"=>$errors->getMessages()["mobile_number"][0]
    ]);
    }
    public function otpVerificationPost(otpVerificationRequest $request){
        $mobile_number=$request->mobile;
        $code=$request->otp;
        $otp=\App\Otp::where("code",$code)
                    ->where("mobile_number",$mobile_number)
                    ->first();
        if(empty($otp)){
            return redirect()
                    ->back()    
                    ->withErrors(["message"=>"Code invalid ","mobile_number"=>$mobile_number]);
        }
                $time=strtotime($otp->created_at);
                $time_remaining=time()-$time;
                if($time_remaining<0){
                    \App\Otp::where("mobile_number",$request->mobile)
                                    ->where("id","<=",$otp->id)
                                    ->delete();
            return redirect()
                ->back()    
                ->withErrors(["message"=>"Code Expired","mobile_number"=>$mobile_number]);
                }

            \App\User::update(["is_mobile_otp_verfied"=>1])
                        ->where("id",\Auth::user()->id);

            return redirect("/user/address/add-address")
                ->withErrors(["message"=>"Your Mobile Number is verified !"]);
            
    }


    public function addAddress(){
        
        if(!\Auth::user()->is_mobile_otp_verified){
            return redirect("/user/add-mobile-number")->withErrors(["message"=>"Please Verify your mobile number"]);   
        }   
        $states=(array)json_decode(file_get_contents("states.txt"));

        return view("user.add-address")->with(['route'=>"user.add-address-post","states"=>$states]);     
    }
    public function addAddressPost(AddressStoreRequest $request){
      
        $request->merge([
            "user_id"=>\Auth::user()->id
        ]);
        \App\Address::create($request->all());
        \App\User::where("id",\Auth::user()->id)
                    ->update(["is_address_added"=>1]);
        
        return redirect("/user/questions/add-answers")
                    ->withErrors(["message"=>"Your Address added successfully !"]);
    }

    public function addAnswers(){
        if(!\Auth::user()->is_address_added){
            return redirect("/user/address/add-address")->withErrors(["message"=>"You haven't added your address yet"]);   
        }   
        return view("user.add-answers")->with(['route'=>"user.add-answers-post"]);     
    }

    public function addAnswersPost(AnswerStoreRequest $request){
        $request->merge([
            "user_id"=>\Auth::user()->id
        ]);
        \App\Answer::create($request->all());
        \App\User::where("id",\Auth::user()->id)
                    ->update(["is_answers_added"=>1]);
        
        return redirect("/user/references/add-references")
                    ->withErrors(["message"=>"Answers Added Successfully !"]);
    }

    public function addReferences(){
        if(!\Auth::user()->is_answers_added){
            return redirect("/user/questions/add-answers")->withErrors(["message"=>"You haven't added your answers yet"]);   
        }   
        return view("user.add-references")->with(['route'=>"user.add-references"]);     
    }

    public function addReferencesPost(ReferenceStoreRequest $request){
    
        $request->merge([
            "user_id"=>\Auth::user()->id
        ]);
        \App\Reference::create($request->all());
        \App\User::where("id",\Auth::user()->id)
                    ->update(["is_references_added"=>1]);
        return redirect("/user/references/add-references")
                    ->withErrors(["message"=>"Answers Added Successfully !"]);
    }
    
    public function schaduleInterview(Request $request){ 
        // dd(\Auth::user()->is_schedule_added);
        if(\Auth::user()->is_schedule_added){
            return redirect(route("user.schadule-succuessful"))
                ->withErrors(["message"=>"Schedule Already Added"]);   
        }

        $date=$request->input("date");
        $settings=\App\AppointmentsSetting::select("date",\DB::raw("CASE WHEN status='free' THEN 1 ELSE 0 END AS status"))
                                            ->groupBy(\DB::raw("CAST(date AS DATE)" ))
                                            ->paginate(31);
        $times=\App\AppointmentsSetting::where("date","=",$date)->get();
   
        // $this->convertToAlias($data->to_time);
        return view("user.schadule-interview")
                ->with(["route"=>"user.schadule-interview-post","settings"=>$settings,"times"=>$times]);
    }
    public function schaduleInterviewPost(SchaduleStoreRequest $request){
        
        $timeAndId=$request->input("time");
        list($time,$id)=explode("|",$timeAndId,2);
        $settings=\App\Settings::find($id);
        $appointment=\App\AppointmentsSetting::where("date",$request->input("date"))
                                ->where("time",$time)->first();
        if($appointment->status=="occupied"){
            return redirect()->back()->withErrors([
                "message"=>"This slot is already taken by someone else ! Kindly choose other slot"
            ]);
        }
        $appointment->status="occupied";
        $appointment->user_id=\Auth::user()->id;
        $appointment->save();
       
            \App\Appointment::create(
                [
                    "employee_id"=>\Auth::user()->id,
                    "start_time"=>$request->input("date")." ".date("H:i:s",strtotime($time)),
                    "finish_time"=>$request->input("date")." ".date("H:i:s",strtotime($time)+($settings->hours*60)),
                    "comments"=>"An Interview is Schaduled"
                ]
            );
        
            \App\User::where("id",\Auth::user()->id)
                    ->update(["is_schedule_added"=>1]);
        
        return redirect(route("user.schadule-succuessful"));
    }
    public function schaduleSuccessful(){
        if(!\Auth::user()->is_schedule_added){
            return redirect(route("user.schadule-interview"))
                ->withErrors(["message"=>"Choose Your Schedule to continue"]);   
        }
        $user=\App\User::with(["appointment"])->where("id",\Auth::user()->id)->first();
        return view("user.schadule-success")->with(["user"=>$user]);
    }

    public function index()
    {
        return view('home');
    }
    
}
