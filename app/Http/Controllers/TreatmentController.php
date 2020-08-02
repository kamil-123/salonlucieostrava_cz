<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stylist;
use App\Treatment;

class TreatmentController extends Controller
{
    public function index(){

        // get currently logged user
        $user_id=auth()->id();

        //check if it is a Stylist
        $stylist_id=Stylist::where('user_id',$user_id)->first()->id;

        //select treatment of the Stylist
        $treatments = Treatment::where('stylist_id', $stylist_id)->get();

        return view('treatment.index',compact(['treatments','stylist_id']));
    }

    public function store(Request $request){
        $this->validate($request, [             //comment validation
            'name' => 'required|max:255',
            'price'=> 'required|max:255',
            'duration' => 'required|date_format:H:i:s',
        ]);
        $treatment = new Treatment;
        $treatment->stylist_id = $request->input('stylist_id');
        $treatment->name=$request->input('name');
        $treatment->price=$request->input('price');
        $treatment->duration=$request->input('duration');
        $treatment->save();

        session()->flash('success_message', 'New treatment saved.');

        return redirect(action('TreatmentController@index'));

    }

    public function remove(Request $request){
        $treatment = Treatment::findOrFail($request->input('treatment_id'));
        $treatment->delete();
        session()->flash('success_message', 'Treatment successfully deleted');
        return redirect(action('TreatmentController@index'));
    }

    public function edit($id){
        $treatment = Treatment::findOrFail($id);
        return view('treatment/edit',compact('treatment'));
    }

    public function update(Request $request){
        $this->validate($request, [             //comment validation
            'name' => 'required|max:255',
            'price'=> 'required|max:255',
            'duration' => 'required|date_format:H:i:s',
        ]);
        $treatment = Treatment::findOrFail($request->input('treatment_id'));
        $treatment->name = $request->input('name');
        $treatment->price = $request->input('price');
        $treatment->duration = $request->input('duration');
        $treatment->save();

        session()->flash('success_message', 'Treatment successfully updated');

        return redirect(action('TreatmentController@index'));

    }
}
