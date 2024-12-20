<?php

namespace Tests\Unit;

use App\Domain\Order\Services\OrderProduct;
use App\Domain\Order\Services\CreateOrder;
use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Models\Order;
use App\Domain\Order\Events\GetProductDetail;
use App\Domain\Order\Events\OrderProcessed;
use App\Domain\Product\Exceptions\ProductNotFoundException;
use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Mockery;

class OrderProductUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @var CreateOrder&\Mockery\MockInterface */
    protected $createOrderMock;

    /** @var OrderProduct */
    protected $orderProduct;

    protected function setUp(): void
    {
        parent::setUp();

        // Use Mockery to mock the CreateOrder dependency
        $this->createOrderMock = $this->createMock(CreateOrder::class);

        // Instantiate the OrderProduct service with the mocked CreateOrder service
        $this->orderProduct = new OrderProduct($this->createOrderMock);
    }

    public function testExecuteCreatesOrder()
    {
        // Sample OrderData
        $data = new OrderData();
        $data->product_id = 1;
        $data->quantity = 2;

        // Mock Product object
        $product = new Product();
        $product->id = 1;
        $product->price = 100;

        // Mock the event dispatcher to return the mocked product
        Event::fake();

        // Set expectations for GetProductDetail event
        Event::shouldReceive('dispatch')
            ->once()
            ->withArgs(function ($event) use ($data, $product) {
                return $event instanceof GetProductDetail && $event->productId === $data->product_id;
            })
            ->andReturn([$product]);

        // Set expectations for the OrderProcessed event (which is being dispatched)
        Event::shouldReceive('dispatch')
            ->once()
            ->withArgs(function ($event) {
                return $event instanceof OrderProcessed;
            })
            ->andReturn(null);

        // Mock the CreateOrder service to return an Order
        $order = new Order();
        $order->product_id = $data->product_id;
        $order->quantity = $data->quantity;
        $order->total_price = $product->price * $data->quantity;

        $this->createOrderMock
            ->expects($this->once())
            ->method('execute')
            ->with($data, $product)
            ->willReturn($order);

        // Execute the method
        $result = $this->orderProduct->execute($data);

        // Assertions
        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals($order->total_price, $result->total_price);
        $this->assertEquals($order->product_id, $result->product_id);
        $this->assertEquals($order->quantity, $result->quantity);
    }

    public function testProductNotFoundThrowsException()
    {
        $this->expectException(ProductNotFoundException::class);

        // Simulate the case when the product does not exist
        $data = new OrderData();
        $data->product_id = 999; // Non-existent product ID

        // Use real Eloquent functionality to simulate a not found product
        // This will trigger the ProductNotFoundException as part of the event listener
        $orderProduct = new OrderProduct(new CreateOrder());

        // Call the execute method, which will trigger the event and the exception
        $orderProduct->execute($data);
    }
}
