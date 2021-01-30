<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Stylist;
use App\User;

class StylistController extends Controller
{
    public function index(){
        $stylists = Stylist::all();

        return view('stylist/index',compact('stylists'));
    }

    public function edit($id){
        $stylist = Stylist::findOrFail($id);

        return view('stylist/edit',compact('stylist'));
    }

    public function remove(Request $request){
        $stylist = Stylist::findOrFail($request->input('stylist_id'));
        $user = User::findOrFail($stylist->user_id);
        $stylist->delete();
        $user->delete();

        session()->flash('success_message', 'Stylist successfully deleted');
        return redirect(action('StylistController@index'));
    }

    public function create(){
        return view('stylist/create');
    }

    public function store(Request $request){
        $this->validate($request, [             //comment validation
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone'=> 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'photo' => 'required|image|max:500',
            'job' => 'required|max:255',
            'service' => 'required|max:255',
            'introduction' => 'required|max:255',
            ]);

        $photo = $request->file('photo');
        $photoname = $request->input('first_name') . time() . '.' . $photo->getClientOriginalExtension();
        $photo->move(public_path("/images/stylists"), $photoname);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'role' => '2',
            'password' => bcrypt($request->input('password'))
            ]);

        $stylist = Stylist::create([
            'user_id' => $user->id,
            'profile_photo_url' => $photoname,
            'job_title' => $request->input('job'),
            'service' => $request->input('service'),
            'introduction' => $request->input('introduction'),
        ]);


        session()->flash('success_message', 'Stylist successfully added.');
        return redirect(action('StylistController@index'));
    }

    public function update(Request $request){
        $this->validate($request, [             //comment validation
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone'=> 'required|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'photo' => 'nullable|image|max:500',
            'job' => 'required|max:255',
            'service' => 'required|max:255',
            'introduction' => 'required|max:255',
            ]);

        $stylist = Stylist::findOrFail($request->input('stylist_id'));
        $user = User::findOrFail($stylist->user_id);

        if($request->file('photo') !== null){
            $photo = $request->file('photo');
            $photoname = $request->input('first_name') . time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path("/images/stylists"), $photoname);
            $stylist->profile_photo_url = $photoname;
        }

        $stylist->job_title = $request->input('job');
        $stylist->service = $request->input('service');
        $stylist->introduction = $request->input('introduction');
        $stylist->save();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        if($request->input('password') !== null){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        session()->flash('success_message', 'Stylist successfully updated.');

        return redirect(action('StylistController@index'));
    }
}
