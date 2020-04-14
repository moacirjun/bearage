<?php

namespace App\Tests\Api\Product;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariantInterface;

class ProductTest extends AbstractControllerTest
{
    public function testList()
    {
        $this->loadFixture(new ProductFixtures());

        $response = $this->client->get('/api/products');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertResponseEquals([
            [
                'code' => 'code1',
                'name' => 'name1',
                'description' => 'description1',
                'stock' => 10,
                'price' => 13,
                'salePrice' => 12,
                'cost' => 10,
            ], [
                'code' => 'code2',
                'name' => 'name2',
                'description' => 'description2',
                'stock' => 20,
                'price' => 23,
                'salePrice' => 22,
                'cost' => 20,
            ], [
                'code' => 'code3',
                'name' => 'name3',
                'description' => 'description3',
                'stock' => 30,
                'price' => 33,
                'salePrice' => 32,
                'cost' => 30,
            ]
        ], $response);
    }

    public function testFetchSingleProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 1;
        $response = $this->client->get('/api/products/' . $productId);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertResponseEquals([
            'name' => 'name1',
            'code' => 'code1',
            'description' => 'description1',
            'stock' => 10,
            'price' => 13,
            'salePrice' => 12,
            'cost' => 10,
        ], $response);
    }

    public function testFailFetchSingleProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 5;

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with id[%s] not found', $productId));

        $this->client->get('/api/products/' . $productId);
    }

    public function testPost()
    {
        $this->loadFixture(new ProductFixtures());

        $newProductPayload = [
            'name' => 'New Product',
            'stock' => 1,
            'cost' => 18,
            'price' => 20,
            'sale_price' => 19,
            'enabled' => true,
            'description' => 'new product description',
        ];

        $response = $this->client->post('/api/products', ['json' => $newProductPayload]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        // $this->assertResponseEquals($newProductPayload, $response);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        /** @var Product $newProduct */
        $newProduct = $em->getRepository(Product::class)->find(4);
        /** @var ProductVariantInterface $variant */
        $variant = $newProduct->getVariants()->first();

        $this->assertEquals($newProductPayload['name'], $newProduct->getName());
        $this->assertEquals($newProductPayload['description'], $newProduct->getDescription());
        $this->assertEquals($newProductPayload['stock'], $variant->getOnHand());
        $this->assertEquals($newProductPayload['cost'], $variant->getCost());
        $this->assertEquals($newProductPayload['price'], $variant->getPrice());
        $this->assertEquals($newProductPayload['sale_price'], $variant->getSalePrice());
        $this->assertEquals($newProductPayload['enabled'], $newProduct->isEnabled());
    }

    public function testDeleteProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 1;
        $response = $this->client->delete('/api/products/' . $productId);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository(Product::class);

        $deletedProduct = $repository->find($productId);

        $this->assertEquals(null, $deletedProduct);
    }

    public function testFilDeleteProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 4;

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with id[%s] not found', $productId));

        $this->client->delete('/api/products/' . $productId);
    }

    public function testFailEditProduct()
    {
        $this->loadFixture(new ProductFixtures);

        $productId = 4;

        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        $this->expectExceptionMessage(sprintf('Product with id[%s] not found', $productId));

        $this->client->put('/api/products/' . $productId);
    }

    public function testEditProdut()
    {
        $this->loadFixture(new ProductFixtures);

        $newPRoductProperties = [
            'name' => 'name edited',
            'code' => 'code edited',
            'slug' => 'slug edited',
            'description' => 'description edited',
        ];

        $response = $this->client->put('/api/products/' . 1, ['json' => $newPRoductProperties]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertResponseEquals(null, $response);

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $manager->getRepository(Product::class);

        $editedProduct = $repository->find(1);

        $this->assertEquals($newPRoductProperties['name'], $editedProduct->getName());
        $this->assertEquals($newPRoductProperties['slug'], $editedProduct->getSlug());
        $this->assertEquals($newPRoductProperties['code'], $editedProduct->getCode());
        $this->assertEquals($newPRoductProperties['description'], $editedProduct->getDescription());
    }
}
