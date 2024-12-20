<?php

namespace App\Domain\Order\Controllers;

use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Requests\StoreRequest;
use App\Domain\Order\Services\OrderProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderProduct;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::get();
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
        $dto = OrderData::fromRequest($request);
        $createOrder = $this->orderProduct->execute($dto);

        return response()->json($createOrder);
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
