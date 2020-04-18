<?php

namespace Tests\Resources;

use Doctrine\ORM\EntityManagerInterface;
use App\Resources\PaginatorHelper;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;

class PaginatorHelperTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    private $manager;

    protected function setUp(): void
    {
        $this->manager = self::bootKernel()->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testCreateFromRequest()
    {
        $request = new Request(['page' => 2, 'perPage' => 89]);

        $helper = PaginatorHelper::createFromRequest($request);

        $this->assertEquals(89, $helper->getOffset());
        $this->assertEquals(89, $helper->getLimit());
    }

    public function testInvalidArgumentsFromRequest()
    {
        $request = new Request(['page' => 'INVALID-ARGUMENT', 'perPage' => 89]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('page field must be a integer');

       PaginatorHelper::createFromRequest($request);
    }

    public function testDefaultValues()
    {
        $request = new Request();

        $helper = PaginatorHelper::createFromRequest($request);

        $this->assertEquals(PaginatorHelper::DEFAULT_PER_PAGE, $helper->getLimit());
        $this->assertEquals(0, $helper->getOffset());
    }

    public function testCreateDoctrinePaginator()
    {
        $request = new Request(['page' => 3, 'perPage' => 89]);
        $query = $this->manager->createQueryBuilder();

        $helper = PaginatorHelper::createFromRequest($request);

        /** @var Paginator $doctrinePaginator */
        $doctrinePaginator = $helper->createDoctrinePaginator($query);
        $queryOfDoctrinePaginator = $doctrinePaginator->getQuery();

        $this->assertInstanceOf(Paginator::class, $doctrinePaginator);
        $this->assertEquals(89, $query->getMaxResults());
        $this->assertEquals(178, $query->getFirstResult());
        $this->assertEquals(89, $queryOfDoctrinePaginator->getMaxResults());
        $this->assertEquals(178, $queryOfDoctrinePaginator->getFirstResult());
    }
}
