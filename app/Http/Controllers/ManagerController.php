<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function loadManagerHome(){
        $user = Auth::user(); //this gives us the details of session of a logged in user
        $logged_manager = Manager::where('user_id',$user->id)->first();
        return view('manager.home-page',compact('logged_manager'));
    }
}
