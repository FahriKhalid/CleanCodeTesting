<?php

namespace App\Domain\Warehouse\Controllers;

use App\Domain\Product\Models\Product;
use App\Domain\Warehouse\Requests\StoreRequest;
use App\Domain\Warehouse\Services\CreateWarehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $validatedData = $request->validated();
        $createWarehouse = $this->createWarehouse->execute($validatedData);

        return response()->json($createWarehouse);
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
