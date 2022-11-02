<?php

namespace App\Packages\Infra\Repository;

use Illuminate\Support\Facades\DB;

abstract class AbstractPaginatedRepository
{
    protected string $countQuery;

    public function calculateLimitOffset(int $limit, int $page): int
    {
        return ($page * $limit) - $limit;
    }

    public function calculateTotalPages(string $artifactId, int $limit): int
    {
        $entities = DB::selectOne($this->countQuery, [$artifactId]);

        return ceil($entities->total / $limit);
    }

    public function calculateTotalRows(string $artifactId): int
    {
        $entities = DB::selectOne($this->countQuery, [$artifactId]);

        return $entities->total;
    }
}
