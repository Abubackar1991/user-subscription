<?php

namespace App\Console\Commands;
use App\Models\Subscription;
use App\Models\Plan;

use Illuminate\Console\Command;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
