<?php

namespace App\Console\Commands;


use App\Models\Order;
use DateTime;
use Illuminate\Console\Command;

class DeleteOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete order after 1 week from sending';

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
        $orders = Order::where('state',1)->select('send_time','id')->get();
        foreach($orders as $order){
            $sendDate = new DateTime($order->send_time);
            $sendDate->modify('+1 week');
            $deletionDate = new DateTime();
            $date = $sendDate->diff($deletionDate);
            if($this->checkDateIterval($date)){
                $order->delete();
            }
        }
    }

    private function checkDateIterval($date){
        $dateFormat = $date->format("%R%y %R%m %R%m");
        if( str_contains($dateFormat,'-'))
            return false;
        return true;
    }

}
