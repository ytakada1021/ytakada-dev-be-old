<?php

declare(strict_types=1);

namespace App\Query\Services;

use App\Http\Models\DefaultPost;
use Carbon\CarbonImmutable;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Support\Collection;
use stdClass;

final class GetPostListQueryService
{
    public function __construct(private ConnectionResolverInterface $connectionResolver) {}

    public function getPostListOfPage(int $pageNumber = 1, int $perPage = 10): Collection
    {
        /** @var int $offset */
        $offset = ($pageNumber - 1) * $perPage;

        /** @var Collection $queryResult */
        $queryResult = $this
            ->connectionResolver
            ->connection()
            ->table('posts')
            ->select(['*'])
            ->orderBy('posted_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        return $this->convertQueryResultToApiModel($queryResult);
    }

    private function convertQueryResultToApiModel(Collection $queryResult): Collection
    {
        return $queryResult->map(
            function (stdClass $row): DefaultPost {
                return new DefaultPost(
                    $row->id,
                    $row->title,
                    $row->content,
                    CarbonImmutable::parse($row->posted_at)->toIso8601String(),
                    CarbonImmutable::parse($row->updated_at)->toIso8601String()
                );
            }
        );
    }
}
