<?php

namespace App\Console\Commands;

use App\Libs\ConfigUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductSort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product-sort {sort}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '<sort> argument value accepts: popular, best-seller, high-price, low-price';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $sort = $this->argument('sort');
            $procedures = ConfigUtil::get('product_sort_procedure');

            DB::statement("call $procedures[$sort]");
        }
        catch(\Throwable $e) {
            Log::error($e);
        }
    }
}
