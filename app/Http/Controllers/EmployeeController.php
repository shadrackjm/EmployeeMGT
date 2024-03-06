<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //import this class

class EmployeeController extends Controller
{
    public function loadHomePage(){
        $user_data = Auth::user();
        $email = $user_data->email;
        $logged_employee = Employee::where('user_id',$user_data->id)->first();
        return view('employee.home-page',compact('email','logged_employee'));
    }
}
