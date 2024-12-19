<?php

namespace App\Domain\Inventory\Controllers;

use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Requests\StoreRequest;
use App\Domain\Inventory\Services\CreateOrUpdateInventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $createOrUpdateInventory;

    public function __construct(CreateOrUpdateInventory $createOrUpdateInventory)
    {
        $this->createOrUpdateInventory = $createOrUpdateInventory;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inventory::get();
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
        $createOrUpdateInventory = $this->createOrUpdateInventory->execute($validatedData);

        return response()->json($createOrUpdateInventory);
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
