<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractControllerTest extends WebTestCase
{
    /** @var EntityManager $manager */
    private $manager;

    /** @var ORMExecutor $executor */
    private $executor;

    /** @var Client $client */
    protected $client;

    public function setUp()
    {
        $this->client = new Client(['base_uri' => 'http://bearage.local']);

        // Configure variables
        $this->manager = self::bootKernel()->getContainer()->get('doctrine.orm.entity_manager');
        $this->executor = new ORMExecutor($this->manager, new ORMPurger());

        // Run the schema update tool using our entity metadata
        $schemaTool = new SchemaTool($this->manager);
        $schemaTool->updateSchema($this->manager->getMetadataFactory()->getAllMetadata());
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

        $this->executor->execute($loader->getFixtures());
    }

    public function tearDown()
    {
        (new SchemaTool($this->manager))->dropDatabase();
    }

    protected function assertResponseEquals(?array $expectedPayload, Response $response)
    {
        $this->assertEquals($expectedPayload ?? '', json_decode($response->getBody()->getContents(), true));
    }
}
