<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
      public function createSubscribe(Request $request)
        {
        try {
            //Validated
            $validate = Validator::make($request->all(), 
            [
                'user_id' => 'required',
                'plan_id' => 'required'
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }
            $subcheck = Subscription::where("user_id", $request->user_id)->first();
            if(!empty($subcheck))
            {

            return response()->json([
                'status' => false,
                'message' => 'You have already Subscribed',
            ], 200);

            } else {    

            $planData = Plan::findOrFail($request->plan_id);

            $date = strtotime(date('Y-m-d H:i:s')); // your date
            $newDate = date('d-m-Y', strtotime("+".$planData->days." day", $date));

            $user = Subscription::create([
                'user_id' => $request->user_id,
                'plan_id' => $request->plan_id,
                'status' => 'active',
                'created' => strtotime($newDate)
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Subscription Created Successfully',
            ], 200);
            }


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

          public function updateSubscribe(Request $request)
        {
            try {
            $validate = Validator::make($request->all(), 
            [
                'subscribe_id' => 'required',
            ]);

            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validate->errors()
                ], 401);
            }
            $subscribeData = Subscription::findOrFail($request->subscribe_id);
            if(empty($subscribeData))
            {
            return response()->json([
                'status' => false,
                'message' => 'Subscribe not register',
            ], 200);
            }    

            $subscribeData->status = 'deactive';
            
            if ($subscribeData->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Subscribe Updated Successfully',
            ], 200);
            }

             } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }    

        public function cronSubscribe()
        {

        $subscriptionlist = Subscription::where('status', 'active')->orderBy('created_at', 'asc')->get()->toArray();

        $todaydate = strtotime(date('Y-m-d H:i:s'));
        foreach ($subscriptionlist as $key => $subscription) {
            if($todaydate > $subscription['created'])
            {
             $planData = Plan::findOrFail($subscription['plan_id']);
             $subscribeData = Subscription::findOrFail($subscription['id']);
             $newDate = date('d-m-Y', strtotime("+".$planData['days']." day", $todaydate));
             $subscribeData->created = strtotime($newDate);
             $subscribeData->save();
            }
        }
     }

 }       
