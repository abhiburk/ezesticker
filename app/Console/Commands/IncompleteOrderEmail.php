<?php

namespace App\Console\Commands;

use App\Mail\IncompleteOrder;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class IncompleteOrderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incomplete_order:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to users after one hour who has incomplete order.';

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

        // send emails to incomplete order users. (1hr older order from created_at)
        $datetime = \Carbon\Carbon::now()->subHours(1)->format("Y-m-d H:i");
        $orders = Order::where('status', 'Pending')->orWhere('status', 'Failed')
        ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m-%d %H:%i'))"), '=', $datetime)->get();
        foreach ($orders as $order) {
            Log::info('Sending emails to.'. $order->user->email);
            Mail::to($order->user->email)->queue(new IncompleteOrder($order));
        }
        
    }
}
