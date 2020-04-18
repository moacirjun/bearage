<?php

namespace App\Resources;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class PaginatorHelper
{
    const MAX_PER_PAGE = 100;
    const DEFAULT_PER_PAGE = 50;
    const DEFAULT_PAGE = 1;

    private $page;
    private $perPage;
    private $firstResult;
    private $maxResults;
    private $query;

    public function __construct(int $page = self::DEFAULT_PAGE, int $perPage = self::DEFAULT_PER_PAGE)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->setOffsetAndLimit();
    }

    public static function createFromRequest(Request $request): self
    {
        $perPage = $request->query->get('perPage') ?? self::DEFAULT_PER_PAGE;
        $page = $request->query->get('page') ?? self::DEFAULT_PAGE;

        if (!is_integer($perPage)) {
            throw new InvalidArgumentException('perPage field must be a integer');
        }

        if (!is_integer($page)) {
            throw new InvalidArgumentException('page field must be a integer');
        }

        return new self($page, $perPage);
    }

    public function createDoctrinePaginator($query, bool $fetchJoinCollection = true)
    {
        $this->setQuery($query);
        return new Paginator($this->query, $fetchJoinCollection);
    }

    protected function setOffsetAndLimit()
    {
        $this->perPage = min($this->perPage, self::MAX_PER_PAGE);
        $this->page = max($this->page, 1);

        $this->firstResult = ($this->page - 1) * $this->perPage;
        $this->maxResults = $this->perPage;
    }

    /**
     * @var Query|QueryBuilder
     */
    protected function setQuery($query)
    {
        if (!$query instanceof QueryBuilder && !$query instanceof Query) {
            throw new InvalidArgumentException(
                sprintf('Query param must be a instance of %s or %s', QueryBuilder::class, Query::class)
            );
        }

        $query->setMaxResults($this->maxResults);
        $query->setFirstResult($this->firstResult);

        $this->query = $query;
    }

    public function getMaxResults(): int
    {
        return $this->maxResults;
    }

    public function getFirstResult(): int
    {
        return $this->firstResult;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }
}
