<?php

namespace App\Tests\Api\Product;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ProductFixtures;

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

    public function testPost()
    {
        $response = $this->client->post('/api/products', ['json' => [
            'name' => 'name',
            'code' => 'code',
            'slug' => 'slug',
            'description' => 'description',
        ]]);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
