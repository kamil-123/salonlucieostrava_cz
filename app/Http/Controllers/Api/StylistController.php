<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stylist;



class StylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stylists = Stylist::orderBy('id', 'asc')
                        ->with('user')
                        ->get(); 
        return response()->json($stylists, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // we do not need the create() method in api.
        // page viewing will be handled by React route
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated  = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_photo_url' => 'nullable|url',
            'job_title' => 'required|string',
            'introduction' => 'nullable|',
            'service' => 'required',
        ]);

        $stylist = Stylist::create($validated);
        
        // return new stylist information
        return response()->json($stylist, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stylist = Stylist::findOrFail($id);
        return response()->json($stylist, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // we do not need the edit() method in api.
        // page viewing will be handled by React route.
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
        $validated  = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'profile_photo_url' => 'nullable|url',
            'job_title' => 'required|string',
            'introduction' => 'nullable',
            'service' => 'required',
        ]);

        $stylist = Stylist::with('user')->findOrFail($id);
        $stylist->user->first_name = $validated['first_name'];
        $stylist->user->first_name = $validated['last_name'];
        $stylist->profile_photo_url = $validated['profile_photo_url'] ? $validated['profile_photo_url'] : $stylist->profile_photo_url;
        $stylist->job_title = $validated['job_title'];
        $stylist->introduction = $validated['introduction'] ? $validated['introduction'] : $stylist->introduction;
        $stylist->service = $validated['service'];
        $stylist->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stylist = Stylist::findOrFail($id);
        $stylist->delete();
    }
}
