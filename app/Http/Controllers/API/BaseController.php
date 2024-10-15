<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function HandleResponse($result=[],$msg='') 
    {
        $res=['status'=> true,
        'data' => $result,
        'message' => $msg
    ];
    return response()->json($res,200);
    }

    public function HandleError($error,$errorMsg = [],$code=400) 
    {
        $res=['status'=> false,
        'message' => $error
    ];
        if(!empty($errorMsg)){
            $res['data'] = $errorMsg;
        }
        return response()->json($res,$code);
    }
}
