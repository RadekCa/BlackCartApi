<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use DB;


class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::truncate();
        Store::create([ 'id' =>   1, 'platform' => 'woocommerce demo' ]);
        Store::create([ 'id' =>   2, 'platform' => 'shopify demo' ]);
        Store::create([ 'id' => 101, 'platform' => 'seed demo 1' ]);
        Store::create([ 'id' => 102, 'platform' => 'seed demo 2' ]);

    }

}
