<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adventure;
use App\Destination;
use Auth;
use App\Http\Controllers\Metaphone;
use App\Partisipant;
use App\Discussion;

class AdventureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('user.createAdventure');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return Metaphone::metaphoneIndo($request->adventure_name);
        $adventure = new Adventure;
        $adventure->user_id = Auth::user()->id;
        $adventure->name = $request->adventure_name;
        $adventure->start_date = $request->starting_date;
        $adventure->start_time = $request->starting_time;
        $adventure->end_date = $request->ending_date;
        $adventure->end_time = $request->ending_time;
        $adventure->description = $request->description;
        $adventure->name_key = Metaphone::metaphoneIndo($request->adventure_name);

        $image = $request->file('image');

        if ($image) {
            $image_name = 'cover_' . Auth::user()->id . '_' . time() .'.' .$image->getClientOriginalExtension();
            $adventure->image = $image_name;
            $image->move(public_path('img/adventure'), $image_name);
        }else{
            $adventure->image = 'default.jpg';
        }

        $adventure->save();

        foreach ($request->location as $key => $loc) {
            $destination = new Destination;
            $destination->adventure_id = $adventure->id;
            $destination->destinations = $loc;
            $destination->full_location = $request->full_location[$key];
            $destination->lat = $request->lat[$key];
            $destination->long = $request->lng[$key];
            $destination->save();
        }


        $partisipant = new Partisipant;
        $partisipant->user_id = Auth::user()->id;
        $partisipant->adventure_id = $adventure->id;
        $partisipant->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adventure = Adventure::where('id', $id)
            ->with('destination')
            ->first();

        $partisipants = Partisipant::with('user')
            ->where('adventure_id', $id)
            ->where('status', 1)
            ->get();

        $partisipants_count = Partisipant::with('user')
            ->where('adventure_id', $id)
            ->where('status', 1)
            ->count();

        $user_status_to_adventure = Partisipant::where('user_id', Auth::user()->id)
            ->where('adventure_id', $id)
            ->first();

        $discussions = Discussion::with('user')
            ->where('adventure_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        
        return view('adventure.detail', compact('adventure', 'partisipants', 'partisipants_count', 'user_status_to_adventure', 'discussions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $id;
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

    public function join_this($id){
        $is_join = Partisipant::where('user_id', Auth::user()->id)
            ->where('adventure_id', $id)
            ->first();


        if (empty($is_join)) {
            $partisipant = new Partisipant;
            $partisipant->user_id = Auth::user()->id;
            $partisipant->adventure_id = $id;
            $partisipant->save();
        }else{
            if ( $is_join->status == 1) {
                $partisipant = Partisipant::find($is_join->id);
                $partisipant->status = 0;
                $partisipant->save();
                
            }else if($is_join->status == 0){
                $partisipant = Partisipant::find($is_join->id);
                $partisipant->status = 1;
                $partisipant->save();
                
            }
        }

        return redirect('/adventure/'.$id);
    }

    public function get_partisipants($id){
        $partisipants = Partisipant::with('user')
            ->where('adventure_id', $id)
            ->where('status', 1)
            ->get();

        return $partisipants;

    }
}
