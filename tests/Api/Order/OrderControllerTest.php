<?php

namespace App\Tests\Api\Order;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Order\OrderInterface;
use App\Entity\Order\Order;
use App\DataFixtures\OrderFixtures;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;

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

        $response = $this->client->post('/api/orders', ['json' => $orderPayload]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $manager->clear();
        $orderRepository = $manager->getRepository(Order::class);

        /** @var OrderInterface $newOrder */
        $newOrder = $orderRepository->find(4);

        $this->assertEquals($orderPayload['number'], $newOrder->getExternalId());
        $this->assertEquals($orderPayload['notes'], $newOrder->getNotes());
        $this->assertEquals($orderPayload['grand_total'], $newOrder->getTotal());
        $this->assertEquals((int) $orderPayload['order_discount'] * -1, $newOrder->getAdjustmentsTotalRecursively('discount'));
        $this->assertEquals($orderPayload['order_tax'], $newOrder->getAdjustmentsTotalRecursively('tax'));

        return $newOrder;
    }

    public function testStockExchange()
    {
        $this->loadFixture([new ProductFixtures, new OrderFixtures()]);

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $product = $manager->getRepository(Product::class)->find(1);
        $productVariant = $product->getVariants()->first();

        $stock = $productVariant->getOnHand();
        $productVariantQuantity = 2;

        $orderPayload = [
            'number' => 'BES101010',
            'notes' => 'nota test',
            'items' => [
                [
                    'id' => $productVariant->getCode(),
                    'quantity' => $productVariantQuantity,
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

        $this->client->post('/api/orders', ['json' => $orderPayload]);

        $manager->clear();
        $product = $manager->getRepository(Product::class)->find(1);
        $productVariant = $product->getVariants()->first();

        $this->assertEquals($stock - $productVariantQuantity, $productVariant->getOnHand());
    }

    public function testList()
    {
        $this->loadFixture([new ProductFixtures, new OrderFixtures()]);

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $order1 = $manager->getRepository(Order::class)->find(1);
        $order2 = $manager->getRepository(Order::class)->find(2);
        $order3 = $manager->getRepository(Order::class)->find(3);
        $productVariant1 = $manager->getRepository(ProductVariant::class)->find(1);
        $productVariant2 = $manager->getRepository(ProductVariant::class)->find(2);
        $productVariant3 = $manager->getRepository(ProductVariant::class)->find(3);

        $responseExpected = [
            [
                'id' => 1,
                'number' => $order1->getNumber(),
                'notes' => 'no notes 1',
                'items' => [
                    [
                        'id' => $productVariant1->getCode(),
                        'quantity' => 1,
                        'discount' => 0,
                        'unit' => $productVariant1->getPrice(),
                        'tax' => 0,
                        'total' => $productVariant1->getPrice(),
                    ]
                ],
                'state' => Order::STATE_CART,
                'order_discount' => 4,'state' => Order::STATE_CART,
                'id' => 2,
                'number' => $order2->getNumber(),
                'notes' => 'no notes 2',
                'items' => [
                    [
                        'id' => $productVariant2->getCode(),
                        'quantity' => 1,
                        'discount' => 0,
                        'unit' => $productVariant2->getPrice(),
                        'tax' => 0,
                        'total' => $productVariant2->getPrice(),
                    ]
                ],
                'state' => Order::STATE_CART,
                'order_discount' => 12,
                'order_tax' => 0,
                'grand_total' => $productVariant2->getPrice() - 12,
            ], [
                'id' => 3,
                'number' => $order3->getNumber(),
                'notes' => 'no notes 3',
                'items' => [
                    [
                        'id' => $productVariant3->getCode(),
                        'quantity' => 1,
                        'discount' => 0,
                        'unit' => $productVariant3->getPrice(),
                        'tax' => 0,
                        'total' => $productVariant3->getPrice(),
                    ]
                ],
                'state' => Order::STATE_CART,
                'order_discount' => 0,
                'order_tax' => 0,
                'grand_total' => $productVariant3->getPrice(),
            ]
        ];

        $response = $this->client->get('/api/orders');

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertResponseEquals($responseExpected, $response);
    }
}
