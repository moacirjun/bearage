<?php

namespace App\Tests\Api\Product;

use App\Tests\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends AbstractControllerTest
{
    public function testList()
    {
        $response = $this->client->get('/api/products');
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
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
