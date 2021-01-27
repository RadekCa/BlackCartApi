<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * Class ProductsRepository
 *
 * @package App\Repositories
 *
 * Logical interface between Product && ApiController
 */
class ProductsRepository
{
    /**
     * @param int $storeId
     *
     * @return mixed
     *
     *
     * Return list of products with simple logic +limit
     */
    public function getProducts(int $storeId)
    {
        return Product::where('store_id', $storeId)->with('store')->get();
    }
}
