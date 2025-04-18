<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Auth;
use Validator;
use Password;
//use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewUser;
use App\Mail\NewPassword;
use App\Mail\AdminnewuserEmail;
use App\Mail\RegisterUser;
use App\Mail\ParrainUser;


class AuthController extends Controller
{
   //  use VerifiesEmails;
   public $successStatus = 200;
   /**
   * login api
   *
   * @return \Illuminate\Http\Response
   */



   public function login(Request $request){
 

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user = Auth::user();
        $success['token']=$user->createToken('MyApp')->accessToken;
        $success['user']=$user;
        $success['message'] = "Login Successfully!";
        return response()->json(['data'=>$success], 200);
        }else{
        return response()->json(['message'=> 'User does not exist'], 422);
        }
        }

        /**
        * Register api
        *
        * @return \Illuminate\Http\Response
        */
        public function register(Request $request)
        {
      
        $randomcode=random_int(10000,99999);
         Validator::make($request->all(), [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string','min:5','max:20'],
        ])->validate();
     
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $input['code']=$randomcode;


        $user = User::create($input);

        Mail::to($user['email'])->send(new NewUser($user));

       // EMAIL VERIF ADMIN
       // Mail::to($request->email)->send(new RegisterUser($user));

       // Mail::to(env('ADMIN_EMAILS'))->send(new AdminnewuserEmail($user));
       // EMAIL VERIF

       //  $user->sendApiEmailVerificationNotification();
       //  $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';

       return response()->json( $user, 200);
       /// return response()->json(['success'=>$success]);
        }

        /**
        * details api
        *
        * @return \Illuminate\Http\Response
        */
        public function profil()
        {
        $user = Auth::user();
        return response()->json(['user' => $user], $this-> successStatus);
        }


        /**
        * Register api
        *
        * @return \Illuminate\Http\Response
        */
        public function adduser(Request $request)
        {
        $validator = Validator::make($request->all(), [
        'lastname' => 'required',
        'firstname' => 'required',
        'email' => 'required|email',
        ]);



        $input = $request->all();
        $user = User::create($input);

        $newpassword =Str::random(6);

        $date = date("Y-m-d g:i:s");
        $user->email_verified_at = $date;
        $user->password = Hash::make($newpassword);  // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
        $user->save();
    


        ///EMAIL VERIF
        // $user->sendApiEmailVerificationNotification();


        $user = [
            'email' => $request->email,
            'password' => $newpassword,
        ];

        Mail::to($user['email'])->send(new NewUser($user));


        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        return response()->json(['success'=>$success], $this-> successStatus);
        }




        //Reset password
        public function resetpassword(Request $request){
        $input = $request->all();
        $email= $input['email'];
        $newpassword =Str::random(6);
        $user = User::where('email',$email)->first();

        $user->password = Hash::make($newpassword);
        $user->save();

        $user = ['email' => $request->email,
                'password' => $newpassword];
           
        Mail::to($user['email'])->send(new NewPassword($user));
               
        return response()->json([
        'message' => 'Successfully password changed',$user
        ]);

                }

   
                /**
                 * Logout user (Revoke the token)
                 *
                 * @return [string] message
                 */
        public function logout(Request $request)
        {
        $request->user()->token()->revoke();
        return response()->json([
        'message' => 'Successfully logged out'
        ]);
        }

        public function testemail()
        {
        $user = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
        ];
               
        \Mail::to('maximbuisson@gmail.com')->send(new \App\Mail\WelcomeMail($user));

                  
    }

    public function searchAdress(Request $request)
    {


    $word=$request->word;   
    
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.geoapify.com/v1/geocode/autocomplete?text=$word&apiKey=815009fa6d7e4b04bab7925c7762d85b");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
   // curl_setopt($ch, CURLOPT_ENCODING, '');



    curl_setopt($ch, CURLOPT_MAXREDIRS,10);
    curl_setopt($ch, CURLOPT_TIMEOUT,0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 

    $response = curl_exec($ch);
    curl_close($ch);

    return  response()->json(json_decode( $response ));
    


}





public function adduserparrain(Request $request)
{
$validator = Validator::make($request->all(), [
'email' => 'required|email',
]);



//$input = $request->all();
//$user = User::create($input);

$newpassword =Str::random(6);

$date = date("Y-m-d g:i:s");
//$user->email_verified_at = $date;
//$user->password = Hash::make($newpassword);  // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
//$user->save();



///EMAIL VERIF
// $user->sendApiEmailVerificationNotification();


$user = [
    'email' => $request->email,
    'password' => $newpassword,
];

Mail::to($user['email'])->send(new ParrainUser($user));


$success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
return response()->json(['success'=>$success], $this-> successStatus);
}




}
