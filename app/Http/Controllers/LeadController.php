<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLead;
use Illuminate\Http\Request;
use App\Lead;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
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
    public function store(StoreLead $request)
    {
        $lead=lead::create([
         'name'=>$request->name,
         'email'=>$request->email,
         'owner'=>$request->owner
      ]);
       if(request()->wantsJson()){
        return['message'=>$lead->path()];
       }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lead=Lead::findorFail($id);
        return view('lead.show',compact('lead',$lead));

    }

    public function count(){

        return Lead::all()->count();

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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function imgstore(Request $request){
        if ($request->hasFile('file')) {

            $image = $request->file;
            $name = $request->name.'.jpg';
            $path = 'public/images/' . $name;

            $img = Image::make($image);

            Storage::disk('local')->put($path, $img->encode());

            $url = asset('storage/images/' . $name);

            return response()->json(['url' => $url]);
        }

        return response()->json(['error' => 'No file']);

    }
}
