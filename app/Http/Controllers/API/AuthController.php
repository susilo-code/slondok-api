<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends BaseController
{
    public function login(Request $request) {
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $output['token'] = $user->createToken('LaravelAPI') ->plainTextToken;
            $output['name'] = $user->name;
            return $this->HandleResponse($output,'User has Login');
        } else {
            return $this->HandleError([],'Unauthorized');
        };
        
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);
         if($validator->fails()) {
            // dd($validator->errors());
            return $this->HandleError($validator->errors());
         }
         $user = User::where('email',$request->email)->first();
         if($user) {
            return $this->HandleError('Email is already exists');
         }

         $input = $request->all();
         $input['password']= bcrypt($input['password']) ;
         $user = User::create($input);
        $output['token'] = $user->createToken('LaravelAPI') ->plainTextToken;
        $output['name'] = $user->name;
        return $this->HandleResponse($output,'User has been succesfully registered');
    }
}
