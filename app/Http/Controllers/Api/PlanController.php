<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{

        public function createPlan(Request $request)
        {
        try {
            //Validated
            $validatePlan = Validator::make($request->all(), 
            [
                'plan_name' => 'required',
                'days' => 'required'
            ]);

            if($validatePlan->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatePlan->errors()
                ], 401);
            }

            $user = Plan::create([
                'plan_name' => $request->plan_name,
                'days' => $request->days,
                'created' => date('Y-m-d H:i:s')
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Plan Created Successfully',
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


        public function updatePlan(Request $request)
    {
        try {
            //Validated
            $validatePlan = Validator::make($request->all(), 
            [
                'plan_name' => 'required',
                'days' => 'required'
            ]);

            if($validatePlan->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validatePlan->errors()
                ], 401);
            }

            $planId = $request->planid;

            $planData = Plan::findOrFail($planId);
            if(empty($planData))
            {
            return response()->json([
                'status' => false,
                'message' => 'Plan not register',
            ], 200);
            }    

            $planData->plan_name = $request->plan_name;
            $planData->days = $request->days;
            
            if ($planData->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Plan Updated Successfully',
            ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function listPlan(Request $request)
    {
        $plandetail = Plan::orderBy('created_at', 'desc')->paginate(2);
        if(!empty($plandetail)) {    
        $list = $plandetail;
        } else {
            $list = [];
        }

            return response()->json([
                'status' => true,
                'data' => $list,
            ], 200);
    }    

    public function deletePlan(Request $request)
    {
            $planId = $request->planid;

            $planData = Plan::findOrFail($planId);
            if(empty($planData))
            {
            return response()->json([
                'status' => false,
                'message' => 'Plan not register',
            ], 200);
            }    

        if ($planData->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Plan Deleted Successfully',
            ], 200);
    }
}
}
