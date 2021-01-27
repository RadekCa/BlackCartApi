<?php

namespace App\Console\Commands;

use App\Helpers\AppConst;
use App\Helpers\Connectors\ShopifyHelper;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

/**
 * Class ShopifyDemoUpdateCommand
 *
 * @package App\Console\Commands
 */
class ShopifyDemoUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopify:demo-update';

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
     *
     * @throws GuzzleException
     */
    public function handle()
    {
        $shopify = new ShopifyHelper();
        $result = $shopify->products();

        $importDate = Carbon::now();
        $shopCurrency = 'USD';

        try {
            DB::beginTransaction();
            $statusBar = $this->output->createProgressBar(count($result ?? []));
            $statusBar->start();

            foreach ($result['products'] ?? [] as $product) {
                Product::create([
                    'name' => $product['title'],
                    'price' => $product['variants'][0]['price'],
                    'currency' => $shopCurrency,
                    'inventory' => $product['variants'][0]['inventory_quantity'],
                    'store_id' => AppConst::SHOPIFY_DEMO_ID,
                    'import_at' => $importDate,
                    'weight' => $product['variants'][0]['weight'],
                    //no color and size in this demo endpoint
                ]);

                $statusBar->advance();
            }

            //remove products from last import
            Product::where('store_id', AppConst::SHOPIFY_DEMO_ID)->where('active', 1)->delete();
            //activate current import
            Product::where('store_id', AppConst::SHOPIFY_DEMO_ID)->update(['active' => 1]);

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
