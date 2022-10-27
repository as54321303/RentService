<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class RentPeriodCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentcompleted:cron';

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

        $todayDate=Carbon::now();

        $check=DB::table('on_rent')->whereDate('to', '=', $todayDate)->get();

        if($check)
        {
            foreach ($check as $item) {
                
                DB::table('on_rent')->where('to','=',$item->to)->update([
                    'rentCompleted'=>1,
                ]);

                DB::table('machines')->where('id',$item->machineId)->update([

                    'onRent'=>0,

                ]);

            }
       
        }

    }
}
