<?php

namespace App\Domain\Order\Controllers;

use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Requests\StoreRequest;
use App\Domain\Order\Services\OrderProduct;
use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $dto = OrderData::fromRequest($request);
        $createOrder = $this->orderProduct->execute($dto);

        return response()->json($createOrder);
    }
}
