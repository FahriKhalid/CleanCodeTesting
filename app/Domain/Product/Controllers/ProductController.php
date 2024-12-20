<?php

namespace App\Domain\Product\Controllers;

use App\Domain\Product\DTO\ProductData;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Requests\StoreRequest;
use App\Domain\Product\Services\CreateProduct;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $createProduct;

    public function __construct(CreateProduct $createProduct)
    {
        $this->createProduct = $createProduct;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $dto = ProductData::fromRequest($request);
        $createProduct = $this->createProduct->execute($dto);

        return response()->json($createProduct);
    }
}
