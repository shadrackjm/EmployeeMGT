<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\User;
use App\Models\States;
use App\Models\Manager;
use App\Models\Employee;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function loadManagerHome(){
        $user = Auth::user(); //this gives us the details of session of a logged in user
        $logged_manager = Manager::where('user_id',$user->id)->first();
        $email = $user->email;
        return view('manager.home-page',compact('logged_manager','email'));
    }

    public function getAllEmployees(){
        $user = Auth::user();
        $logged_manager = Manager::where('user_id',$user->id)->first();
        $all_employees = Employee::join('users','users.id','=','employees.user_id')
        ->join('countries','countries.id','=','employees.country_id')
        ->join('states','states.id','=','employees.state_id')
        ->join('cities','cities.id','=','employees.city_id')
        ->get(['users.email','employees.*','countries.name as country_name','states.name as state_name','cities.name as city_name']);  //here specify columns to select from both two tables
        // get all countries
        $all_countries = Countries::all(); 
        return view('manager.manage-employees',compact('all_employees','logged_manager','all_countries'));
    }

    public function GetStates($country_id){
        try {
            $states = States::where('country_id',$country_id)->get();

            return response()->json(['success' => true, 'data' => $states]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'No Data Found!']);
        }
    }

    public function GetCities($state_id){
        try {
            $cities_data = Cities::where('state_id',$state_id)->get();

            return response()->json(['success' => true, 'data' => $cities_data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => 'No Data Found!']);
        }
    }

    public function RegisterEmployee(Request $request){
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'job_title' => 'required|string',
            'country' => 'required|numeric',
            'state' => 'required|numeric',
            'city' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{
            // register manager
            try {
                // so here we will do the following changes
                // here in last video user registration code block was below the managers registration code block
                $addAsUser = new User;
                $addAsUser->name = $request->fname;
                $addAsUser->email = $request->email;
                $addAsUser->password = Hash::make('123456'); //this will be the default password for all managers
                $addAsUser->role = 0;
                $addAsUser->save();
                // now i added this single line below
                $user_id = $addAsUser->id; //this will give us the id of the user insterted at an instance..

                // // then use the user_id to a employee table
                $employee = new Employee;
                $employee->user_id = $user_id; //add this line.. everything else remain the same
                $employee->first_name = $request->fname;
                $employee->middle_name = $request->mname;
                $employee->last_name = $request->lname;
                $employee->phone_number = $request->phone;
                $employee->job_title = $request->job_title;
                $employee->country_id = $request->country;
                $employee->state_id = $request->state;
                $employee->city_id = $request->city;
                $employee->save();
                // now add the user_id field in the employee table migration & database
    
                return response()->json(['success' => true, 'msg' => 'employee addedd successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);
            }
           
        }
    }

   
    public function deleteEmployee($user_id){ 
        try {
            User::where('id',$user_id)->delete();
            return response()->json(['success' => true, 'msg' => $user_id]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    // edit employee functionality
    public function editEmployee(Request $request){
        // validate form
        $validator = Validator::make($request->all(),[
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'job_title' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()->toArray()]);
        }else{
            // perform edit functionality here
            try {

                $country_data = Countries::where('name',$request->country)->first();
                $state_data = States::where('name',$request->state)->first();
                $city_data = Cities::where('name',$request->city)->first();
                Employee::where('user_id',$request->manager_id)->update([
                    'first_name' => $request->fname,
                    'middle_name' => $request->mname,
                    'last_name' => $request->lname,
                    'phone_number' => $request->phone,
                    'job_title' => $request->job_title,
                    'country_id' => $country_data->id,
                    'state_id' => $state_data->id,
                    'city_id' => $city_data->id,
                ]);

                User::where('id',$request->manager_id)->update([
                    'email' => $request->email
                ]);

                return response()->json(['success' => true, 'msg' => 'manager updated successfully']);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'msg' => $e->getMessage()]);

            }
            
        }

    }
}
