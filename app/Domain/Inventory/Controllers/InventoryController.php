<?php

namespace App\Domain\Inventory\Controllers;

use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Requests\StoreRequest;
use App\Domain\Inventory\Services\CreateOrUpdateInventory;
use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        $createOrUpdateInventory = $this->createOrUpdateInventory->execute($validatedData);

        return response()->json($createOrUpdateInventory);
    }
}
