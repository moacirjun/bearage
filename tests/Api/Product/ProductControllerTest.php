<?php

namespace App\Tests\Api\Product;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ProductFixtures;
use App\Entity\Product\Product;

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
                'slug' => 'slug1',
                'description' => 'description1',
            ], [
                'code' => 'code2',
                'name' => 'name2',
                'slug' => 'slug2',
                'description' => 'description2',
            ], [
                'code' => 'code3',
                'name' => 'name3',
                'slug' => 'slug3',
                'description' => 'description3',
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
            'slug' => 'slug1',
            'description' => 'description1',
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
            'code' => '##123123',
            'slug' => 'new-product',
            'description' => 'new product description',
        ];

        $response = $this->client->post('/api/products', ['json' => $newProductPayload]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertResponseEquals($newProductPayload, $response);

        $em = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $newProduct = $em->getRepository(Product::class)->find(4);

        $this->assertEquals($newProductPayload['name'], $newProduct->getName());
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
}
