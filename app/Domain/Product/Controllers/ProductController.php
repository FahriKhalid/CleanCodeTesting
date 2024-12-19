<?php

namespace App\Domain\Product\Controllers;

use App\Domain\Product\Models\Product;
use App\Domain\Product\DTO\ProductData;
use App\Domain\Product\Requests\StoreRequest;
use App\Domain\Product\Services\CreateProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
