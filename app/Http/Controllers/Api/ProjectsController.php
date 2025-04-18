<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Project;
use App\Models\Question;
use App\Models\User;
use Storage;
use PDF;
use Carbon\Carbon;
use App\Mail\Form2Mail;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $per_page= $request->per_page;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $category = $request->category;
        $status=$request->status;
  
       return Project::where('name_contact', 'LIKE', "%{$filter}%")
        ->orWhere('name_regie', 'LIKE', "%{$filter}%")
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $post = Project::create($request->all());
        return response()->json($post, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Project::find($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $post = Project::findOrFail($id);
        $post->update($request->all());
        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Project::findOrFail($id);
        if($post)
           $post->delete();
        else
            return response()->json(error);
        return response()->json('post delete', 200);
    }

    public function postsByUser($id, Request $request)
    {
        $page = $request->page;
        $per_page = $request->per_page;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $filter = $request->filter;

        if($filter){
            return Project::where('userid', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Project::where('edited_by', $id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }
    }


    

//  Register
public function saveformpdf1(Request $request) {

   
    $userid = $request->userid;
    $clientid = $request->clientid;
    $bloc1= $request->bloc1;
    $img1= $request->img1;
    $img2= $request->img2;
 
 
    $label1= $request->label1;
    $label2= $request->label2;
    $label3= $request->label3;
    $label4= $request->label4;
    $label5= $request->label5;
    $label6= $request->label6;
    $label7= $request->label7;
    $label8= $request->label8;
    $label9= $request->label9;
    $label10= $request->label10;


     $users1 = DB::table('users')
     ->where('users.id', $userid)
     ->select('*' )
     ->get();


     $email=$users1[0]->email;
 
     $users2 = DB::table('locations')
     ->where('id', $clientid)
     ->select('*' )
     ->get();


     $records = DB::table('records')
     ->where('location_id', $clientid)
     ->select('*' )
     ->orderBy('id','DESC')
     ->limit(20)
     ->get();
 
    $date = Carbon::now()->timezone('Europe/Paris')->toDateTimeString();
    $randomtitle=random_int(100000,999999);
    $path = public_path('pdf/');
    $fileName = date("Y-m-d", strtotime($date)). '-'."rapport-analyse".'-'.$randomtitle.'.'.'pdf' ;
 
    $docdate = date('d-m-Y', strtotime($date));
 
     $pdf = PDF::loadView('pdf.survey1', ['bloc1'=> $bloc1,'users1'=> $users1,'users2'=> $users2,'records'=> $records,'docdate'=> $date,
      'img1'=> $img1, 'img2'=> $img2, 'label1'=> $label1, 'label2'=> $label2, 'label2'=> $label2, 'label3'=> $label3, 'label4'=> $label4, 'label4'=> $label4,
      'label5'=> $label5, 'label6'=> $label6, 'label7'=> $label7,
     'label8'=> $label8, 'label9'=> $label9, 'label10'=> $label10
     ])->setPaper('a4', 'portrait');
     $pdf->save($path . '/' . $fileName);
 
 

     $emails = [$email];
     //SEND EMAIL 
      Mail::to($emails)->send(new Form2Mail($pdf));



     $user = new Project;
     $user->title = "Contrat";
     $user->url = $fileName;
     $user->userid = $clientid;
     $user->useredit = $userid;
     $user->save();
 
     //return $pdf->download($fileName);
     return response()->json( $fileName, 200);
     }
 


    


}
