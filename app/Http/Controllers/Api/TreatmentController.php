<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Treatment;

use  App\Http\Controllers\Controller;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('stylist_id')!==null){
            $stylist_id = $request->input('stylist_id');
            $treatments = Treatment::where('stylist_id',$stylist_id)->get();
            return $treatments; 
        } else {
            $treatments = Treatment::all();
            return $treatments;
            // return response()->json($treatments, 200);
        }
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
            'name' => 'required|string',
            'price' => 'required|integer',
            'duration' => 'required',
        ]);

        $treatment = Treatment::create($validated);
        
        // return new treatment information
        return response()->json($treatment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $treatment = Treatment::findOrFail($id);
        return response()->json($treatment, 200);
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
            'name' => 'required|string',
            'price' => 'required|integer',
            'duration' => 'required',
        ]);

        $treatment = Treatment::findOrFail($id);
        $treatment->name = $validated['name'];
        $treatment->price = $validated['price'];
        $treatment->duration = $validated['duration'];
        $treatment->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $treatment = Treatment::findOrFail($id);
        $treatment->delete();
    }
}
