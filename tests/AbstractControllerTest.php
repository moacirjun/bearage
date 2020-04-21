<?php

namespace App\Tests;

use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;

class AbstractControllerTest extends WebTestCase
{
    /** @var EntityManager $manager */
    private $manager;

    /** @var ORMExecutor $executor */
    private $executor;

    /** @var Client $client */
    protected $client;

    /** @var TestContainer $testContainer */
    protected $testContainer;

    public function setUp()
    {
        /** @var TestContainer $testContainer */
        $this->testContainer = self::bootKernel()->getContainer()->get('test.service_container');

        $this->manager = $this->testContainer->get('doctrine.orm.entity_manager');
        $this->executor = new ORMExecutor($this->manager, new ORMPurger());

        // Run the schema update tool using our entity metadata
        $schemaTool = new SchemaTool($this->manager);
        $schemaTool->updateSchema($this->manager->getMetadataFactory()->getAllMetadata());

        $this->client = $this->createClientWithAuthorizationHeader();
    }

    protected function loadFixture($fixture)
    {
        $loader = new Loader();
        $fixtures = is_array($fixture) ? $fixture : [$fixture];

        foreach ($fixtures as $item) {
            if ($item instanceof FixtureInterface) {
                $loader->addFixture($item);
                continue;
            }

            if (!class_exists($item)) {
                continue;
            }

            $fixture = new $item;

            if (!$fixture instanceof FixtureInterface) {
                continue;
            }

            $loader->addFixture($fixture);
        }

        $this->executor->execute($loader->getFixtures(), true);
    }

    public function tearDown()
    {
        (new SchemaTool($this->manager))->dropDatabase();
    }

    public function createClientWithAuthorizationHeader()
    {
        $userFixture = $this->testContainer->get('App\DataFixtures\UserFixtures');
        $this->loadFixture($userFixture);

        $payload = [
            'username' => 'email.admin@bearage.com.br',
            'password' => 'bearageadmin',
        ];

        $client = new Client(['base_uri' => 'http://bearage.local']);
        $response = $client->post('/api/login_check', ['json' => $payload]);

        $body = json_decode($response->getBody()->getContents(), true);
        $token = $body['token'];

        $clientConfig = [
            'base_uri' => 'http://bearage.local',
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ]
        ];

        return new Client($clientConfig);
    }

    protected function assertResponseEquals(?array $expectedPayload, Response $response)
    {
        $this->assertEquals($expectedPayload ?? '', json_decode($response->getBody()->getContents(), true));
    }
}
