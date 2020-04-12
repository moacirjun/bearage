<?php

namespace App\Tests\Api\Product;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends KernelTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        $this->client = new Client(['base_uri' => 'http://bearage.local']);
    }

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
