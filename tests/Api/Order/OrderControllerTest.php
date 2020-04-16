<?php

namespace App\Tests\Api\Order;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Order\OrderInterface;
use App\Entity\Order\Order;
use App\DataFixtures\OrderFixtures;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product\Product;

class OrderControllerTest extends AbstractControllerTest
{
    public function testCreateOrder()
    {
        $this->loadFixture([new ProductFixtures, new OrderFixtures()]);

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $product = $manager->getRepository(Product::class)->find(1);
        $productVariant = $product->getVariants()->first();

        $orderPayload = [
            'number' => 'BES101010',
            'notes' => 'nota test',
            'items' => [
                [
                    'id' => $productVariant->getCode(),
                    'quantity' => 2,
                    'discount' => 0,
                    'unit' => 12,
                    'tax' => 0,
                    'total' => 24,
                ]
            ],
            'order_discount' => 4,
            'order_tax' => 0,
            'grand_total' => 20,
        ];

        $response = $this->client->post('/api/orders', $orderPayload);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $manager->clear();
        $orderRepository = $manager->getRepository(Order::class);

        /** @var OrderInterface $newOrder */
        $newOrder = $orderRepository->find(4);

        $this->assertEquals($orderPayload['number'], $newOrder->getNumber());
        $this->assertEquals($orderPayload['notes'], $newOrder->getNotes());
        $this->assertEquals($orderPayload['grand_total'], $newOrder->getTotal());
        $this->assertEquals($orderPayload['order_discount'], $newOrder->getAdjustmentsTotalRecursively('discount'));
        $this->assertEquals($orderPayload['order_tax'], $$newOrder->getAdjustmentsTotalRecursively('tax'));
    }
}
