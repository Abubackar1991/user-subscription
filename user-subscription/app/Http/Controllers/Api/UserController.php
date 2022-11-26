<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $userId = $request->userid;

            $userData = User::findOrFail($userId);
            if(empty($userData))
            {
            return response()->json([
                'status' => false,
                'message' => 'User not register',
            ], 200);
            }    

            $userData->name = $request->name;
            $userData->email = $request->email;
            if($request->password != '')
            $userData->password = Hash::make($request->password);

            if ($userData->save()) {
            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully',
            ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function listUser(Request $request)
    {
        $userdetail = User::where("isdeleted", 0)->orderBy('created_at', 'desc')->paginate(2);
        if(!empty($userdetail)) {    
        $list = $userdetail;
        } else {
            $list = [];
        }

            return response()->json([
                'status' => true,
                'data' => $list,
            ], 200);
    }    

    public function deleteUser(Request $request)
    {
            $userId = $request->userid;

            $userData = User::findOrFail($userId);
            if(empty($userData))
            {
            return response()->json([
                'status' => false,
                'message' => 'User not register',
            ], 200);
            }    

            $userData->isdeleted = 1;
            if ($userData->save()) {
            return response()->json([
                'status' => true,
                'message' => 'User Deleted Successfully',
            ], 200);
            }

    }
   } 
