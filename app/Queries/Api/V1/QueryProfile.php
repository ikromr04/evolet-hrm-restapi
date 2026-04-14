<?php

namespace App\Queries\Api\V1;

use Spatie\QueryBuilder\QueryBuilder;

abstract class QueryProfile
{
    abstract protected function model(): string;

    abstract protected function filters(): array;

    abstract protected function includes(): array;

    abstract protected function sorts(): array;

    abstract protected function fields(): array;

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters(...$this->filters())
            ->allowedIncludes(...$this->includes())
            ->allowedSorts(...$this->sorts())
            ->allowedFields(...$this->fields());
    }

    public function get()
    {
        return $this->query()->get();
    }
}
