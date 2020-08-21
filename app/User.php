<?php
namespace App;

require_once(dirname(dirname(__FILE__)) . '/external_lilbrary/smartystreets-php-sdk/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/external_lilbrary/smartystreets-php-sdk/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/external_lilbrary/smartystreets-php-sdk/src/International_Street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/external_lilbrary/smartystreets-php-sdk/src/International_Street/Client.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\International_Street\Lookup;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name',"first_name","middle_name","last_name",
                'mobile_number','email', 'password', 'remember_token', 'role_id',
                "is_mobile_otp_verified","is_address_added","is_answers_added","is_schedule_added"];
    
    
    /**
     * Hash password
     * @param $input
     */
    public function address(){
        return $this->hasOne("\App\Address","user_id");
    }
    public function appointment(){
        return $this->hasOne("\App\Appointment","employee_id");
    }
    public function refs(){
        return $this->hasOne("\App\Reference","user_id");
    }

    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    

    /**
     * Set to null if empty
     * @param $input
     */
    public function setRoleIdAttribute($input)
    {
        $this->attributes['role_id'] = $input ? $input : null;
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function sendOtp($mobile){

// Your Account SID and Auth Token from twilio.com/console
                $account_sid = 'ACb713670cd14d5f80ae8bcc8ef14fa6fc';
                $auth_token = '0ca48796d9f7e868d9b9106204bb5e9d';
                
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

                // A Twilio number you own with SMS capabilities
                $twilio_number = $mobile;
                $code= mt_rand(100000, 999999);
                $client = new \Twilio\Rest\Client($account_sid, $auth_token);
                $token=bin2hex($code);
                $data=["user_id"=>\Auth::user()->id,"mobile_number"=>$twilio_number,"token"=>$token,"code"=>$code];
               
                \Session::put("number_creation_time",time()+60);
                \App\Otp::create($data);
                $client->messages->create(
                    // Where to send a text message (your cell phone?)
                   $twilio_number ,
                    array(
                        'from' => "+12058903846",
                        'body' => "Your OTP is $code "
                    )
                );

    }
    public function validateNumber($number){
        $ch = curl_init();
        $number=trim($number);
       $url_number=curl_escape ($ch,$number);
        
        curl_setopt($ch, CURLOPT_URL, "http://apilayer.net/api/validate?access_key=adf3f7eb886cd67f544fb75d0c3c4ca0&number=$url_number");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)');

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit;
        }
        curl_close($ch);
        return json_decode($result)->valid;
    }
    public function run() {
        $authId = '211633c6-f2e6-c727-d5e3-78ac97ec2396';
        $authToken = 'FEVqW06pngozMYRI5l6p';

        // We recommend storing your secret keys in environment variables instead---it's safer!
//        $authId = getenv('SMARTY_AUTH_ID');
//        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);
        $client = (new ClientBuilder($staticCredentials))->buildInternationalStreetApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/international-street-api

        $lookup = new Lookup();
        $lookup->setInputId("ID-8675309");
        $lookup->setGeocode(true); // Must be expressly set to get latitude and longitude.
        $lookup->setOrganization("John Doe");
        $lookup->setAddress1("Rua Padre Antonio D'Angelo 121");
        $lookup->setAddress2("Casa Verde");
        $lookup->setLocality("Sao Paulo");
        $lookup->setAdministrativeArea("SP");
        $lookup->setCountry("Brazil");
        $lookup->setPostalCode("02516-050");

        $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.

        $firstCandidate = $lookup->getResult()[0];

        echo("Address is " . $firstCandidate->getAnalysis()->getVerificationStatus());
        echo("\nAddress precision: " . $firstCandidate->getAnalysis()->getAddressPrecision() . "\n");

        echo("\nFirst Line: " . $firstCandidate->getAddress1());
        echo("\nSecond Line: " . $firstCandidate->getAddress2());
        echo("\nThird Line: " . $firstCandidate->getAddress3());
        echo("\nFourth Line: " . $firstCandidate->getAddress4());

        $metadata = $firstCandidate->getMetadata();
        echo("\nAddress Format: " . $metadata->getAddressFormat());
        echo("\nLatitude: " . $metadata->getLatitude());
        echo("\nLongitude: " . $metadata->getLongitude());
    }
    
    
}
