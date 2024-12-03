<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DeleteUnpaidOrders extends Command
{
    protected $signature = 'delete:unpaid-orders {hours=24}';

    protected $description = 'Delete unpaid orders after x amount of hours';

    public function handle()
    {
        $hours = $this->argument('hours');
        $count = Order::deleteUnpaidOrders($hours);
        $this->info("$count unpaid orders were deleted");
        return Command::SUCCESS;
    }
}
