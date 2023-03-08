<?php

namespace App\Console\Commands;

use App\Models\Discount;
use App\Models\Items;
use DateTime;
use Illuminate\Console\Command;

class DeleteDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discount:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will disable discount';

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
     * @return mixed
     */
    public function handle()
    {

        $items = Items::whereHas('discount')->with('discount')->get();
        
        foreach($items as $item){
            $now = new DateTime();
            $endTime = new DateTime($item->discount->time_end);
            $date = $now->diff($endTime);
            if($this->checkDateIterval($date)){
                $item->discount()->delete();
            }
        }
        
    }
    private function checkDateIterval($date){
        $dateFormat = $date->format("%R%y %R%m %R%m");
        if( str_contains($dateFormat,'+'))
            return false;
        return true;
    }
}
