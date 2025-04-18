<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use App\Mail\NewPassword;
use App\Mail\WelcomeMail;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Storage;
use PDF;

use Carbon\Carbon;

class EmailsController extends Controller
{



 //  Register
 public function sendform1(Request $request) {


   $fileName=time().'.pdf';

   $user = new user;
   $user->firstname =$request->firstname;
   $user->lastname = $request->lastname;
   $user->phone_number= $request->phone_number;
   $user->email = $request->email;
   $user->subject = "Questionnaire 1";
   $user->message=$request->message;
   $user->fileName=$fileName;

   $pdf = PDF::loadView('pdf.form1',['user' => $user],  )->save('pdf/'.$fileName);

   Mail::to(env('ADMIN_EMAILS'))->send(new Form1Mail($user,$fileName));



   $notif = Notif::create([
        'title' => "PDF",
        'content' => "Pdf à télécharger",
        'edited_by' => $request->id,
        'link' => 'pdf/'.$fileName,
        'category' => "PDF",
        'view'=>0
    ]);

   return response()->json([
    'message' => 'Successfully created',$user
]);



}





}
