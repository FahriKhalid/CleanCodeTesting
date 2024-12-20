<?php

namespace App\Domain\Warehouse\Controllers;

use App\Domain\Product\Models\Product;
use App\Domain\Warehouse\Requests\StoreRequest;
use App\Domain\Warehouse\Services\CreateWarehouse;
use App\Http\Controllers\Controller;

class WarehouseController extends Controller
{
    protected $createWarehouse;

    public function __construct(CreateWarehouse $createWarehouse)
    {
        $this->createWarehouse = $createWarehouse;
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
        $validatedData = $request->validated();
        $createWarehouse = $this->createWarehouse->execute($validatedData);

        return response()->json($createWarehouse);
    }
}
