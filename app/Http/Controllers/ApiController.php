<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProductRequest;
use App\Repositories\ProductsRepository;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * Main controller class for API requests
 */
class ApiController extends Controller
{
    private ProductsRepository $productsRepository;

    /**
     * ApiController constructor.
     *
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    /**
     * @param GetProductRequest $request
     *
     * @return array
     *
     * Returns a list of products for a given store && success status
     */
    public function products(GetProductRequest $request)
    {
        return ['success' => true, 'data' => $this->productsRepository->getProducts($request->storeID)];
    }
}
