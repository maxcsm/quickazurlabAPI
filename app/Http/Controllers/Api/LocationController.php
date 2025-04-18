<?php

namespace App\Http\Controllers\Api;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

           //  $status = explode(',', $status );

        $page = $request->page;
        $per_page= $request->per_page;
        $filter= $request->filter;
        $order_by = $request->order_by;
        $order_id = $request->order_id;
        $category = $request->category;
        $status=$request->status;
        
      if (empty($filter)) {
      return Location::select('locations.id','locations.title','locations.city','locations.image','locations.edited_by','locations.updated_at','locations.view', 'locations.price', 'locations.category','locations.subcategory')
      -> orderBy($order_id, $order_by)
      -> paginate($per_page);
      }

      if (!empty($filter)) {
      return Location::select('locations.id','locations.title','locations.city','locations.image','locations.edited_by','locations.updated_at','locations.view', 'locations.price', 'locations.category','locations.subcategory')
      -> where('title', 'LIKE', "%{$filter}%")
      -> orWhere('id', 'LIKE', "%{$filter}%")
      -> orderBy($order_id, $order_by)
      -> paginate($per_page);
      }
      /*
       if (empty($filter)) {
        return Location::whereIn('view',[0,1])
        -> where('category',$category) 
        -> orderBy($order_id, $order_by)
      -> paginate($per_page);
      }
          */
      //return response()->json($view, 200);

        
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
      $location =  Location::create($request->all());
    //  DB::table('locations')->insert($request);


        return response()->json($location, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $post = Location::findOrFail($id);
      return response()->json($post, 200);

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
        $post = Location::findOrFail($id);
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
        $post = Location::findOrFail($id);
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
            return Location::where('edited_by', $id)
            ->where('content', 'LIKE', "%{$filter}%")
            ->orWhere('title', 'LIKE', "%{$filter}%")
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }else{
            return Location::where('edited_by', $id)
            ->orderBy($order_id, $order_by)
            ->paginate($per_page);
        }
    }

    public function postsByUserShort($id, Request $request)
    {
        $page = $request->page;
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';

        return Location::where('edited_by', $id)
        ->orderBy($order_id, $order_by)
        ->paginate($per_page);
    }





    public function public_location_detail($id)
    {

      
      $location = DB::table('locations')
      ->where('locations.id', $id)
      ->select('*')
      ->get();

      $tags= DB::table('tags_location')
      ->join('tags', 'tags_location.tag_id', '=', 'tags.id')
      ->where('tags_location.location_id', $id)
      ->select('tags.tag_fr','tags.tag_en','tags.tag_de')
      ->get();
      
      return response()->json(['location'=>$location,'tags'=>$tags],200);

      
    }



    public function public_locations_short()
    {
      
        $per_page = 10;
        $order_by = 'desc';
        $order_id = 'id';
        $location = DB::table('users')
    //    ->join('tags_location', 'tags_location.location_id', '=', 'locations.id')
       // ->where('view', 1)
        ->orderBy($order_id, $order_by)
       // ->distinct('locations.location_id')
        ->paginate($per_page);

        return response()->json(  $location, 200);

    }












}
