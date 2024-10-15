<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Http\Resources\Bank as BankResource;
use Validator;

class BankController extends BaseController
{
    public function index (Request $request) {
        $banks = Bank::all();
        $output=[];
        foreach ($banks as $bank) {
            $output[] = new BankResource($bank);
        }
        return $this->handleResponse($output);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);
         if($validator->fails()) {
            // dd($validator->errors());
            return $this->HandleError($validator->errors());
         }

         $user = Auth::user();
         $input = $request->all();
         $input['user_id'] = $user->id;
        $bank = Bank::create($input);
        return $this->handleResponse(new BankResource($bank));
    }

    public function show (Bank $bank) 
    {
        return $this->handleResponse(new BankResource($bank));
    }

    public function destroy (Bank $bank) 
    {
        $bank -> delete();
        return $this->handleResponse('Bank is deleted succesfully');
    }
}