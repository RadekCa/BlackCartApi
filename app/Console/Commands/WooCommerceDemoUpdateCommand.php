<?php

namespace App\Console\Commands;

use App\Helpers\AppConst;
use App\Helpers\Connectors\WooCommerceHelper;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class WooCommerceDemoUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'woocommerce:demo-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products from demo shopify endpoint';

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
        $woo = new WooCommerceHelper();
        $products = $woo->products();
        $importDate = Carbon::now();
        $shopCurrency = 'CAD';

        try {
            DB::beginTransaction();
            $statusBar = $this->output->createProgressBar(count($products ?? []));
            $statusBar->start();

            foreach ($products ?? [] as $product) {
                Product::create([
                    'name' => $product->name,
                    'price' => (float) $product->price ?? 0.00,
                    'currency' => $shopCurrency,
                    'inventory' => $product->stock_status === 'instock' ? 1 : 0,
                    'store_id' => AppConst::WOOCOMMERCE_DEMO_ID,
                    'import_at' => $importDate,
                    'weight' => $product->weight,

                ]);

                $statusBar->advance();
            }

            //remove products from last import
            Product::where('store_id', AppConst::WOOCOMMERCE_DEMO_ID)->where('active', 1)->delete();
            //activate current import
            Product::where('store_id', AppConst::WOOCOMMERCE_DEMO_ID)->update(['active' => 1]);

            DB::commit();
            $statusBar->finish();
        } catch (Throwable $exception) {
            dump($exception); //or log somewhere...
            DB::rollback();
        }

        print "\n";

        return 0;
    }
}
