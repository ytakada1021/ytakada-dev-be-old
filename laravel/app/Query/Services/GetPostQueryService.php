<?php

declare(strict_types=1);

namespace App\Query\Services;

use App\Http\Models\DefaultPost;
use Carbon\CarbonImmutable;
use Illuminate\Database\ConnectionResolverInterface;
use stdClass;

final class GetPostQueryService
{
    public function __construct(private ConnectionResolverInterface $connectionResolver) {}

    public function getPostOfId(string $postId): ?DefaultPost
    {
        /** @var ?stdClass */
        $queryResult = $this
            ->connectionResolver
            ->connection()
            ->table('posts')
            ->select('*')
            ->where('posts.id', $postId)
            ->first();

        if (is_null($queryResult)) {
            return null;
        } else {
            return $this->convertQueryResultToApiModel($queryResult);
        }
    }

    private function convertQueryResultToApiModel(stdClass $queryResult): DefaultPost
    {
        return new DefaultPost(
            $queryResult->id,
            $queryResult->title,
            $queryResult->content,
            CarbonImmutable::parse($queryResult->posted_at)->toIso8601String(),
            is_null($queryResult->updated_at)
                ? null
                : CarbonImmutable::parse($queryResult->updated_at)->toIso8601String()
        );
    }
}
