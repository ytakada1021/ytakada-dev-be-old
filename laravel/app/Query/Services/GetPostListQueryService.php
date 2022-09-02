<?php

namespace App\Query\Services;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use stdClass;

final class GetPostListQueryService
{
    private DatabaseManager $dbManager;

    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    public function getPostListOfPage(int $pageNumber = 1, int $perPage = 10): Collection
    {
        /** @var int $offset */
        $offset = ($pageNumber - 1) * $perPage;

        /** @var Collection $postsQueryResult */
        $postsQueryResult = $this
            ->dbConnection()
            ->table('posts')
            ->select([
                'posts.id',
                'posts.title',
                'posts.posted_at',
                'posts.updated_at'
            ])
            ->whereNull('posts.deleted_at')
            ->orderBy('posted_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        /** @var Collection $tagsQueryResult */
        $tagsQueryResult = $this
            ->dbConnection()
            ->table('tags')
            ->select('tags.*')
            ->whereIn('tags.post_id', $postsQueryResult->pluck('id'))
            ->get();

        return $this->convertQueryResultToApiResponseModel($postsQueryResult, $tagsQueryResult);
    }

    private function convertQueryResultToApiResponseModel(
        Collection $postsQueryResult,
        Collection $tagsQueryResult
    ): Collection
    {
        return $postsQueryResult->map(function (stdClass $post) use ($tagsQueryResult): stdClass {
            $post->tags = $tagsQueryResult
                ->whereStrict('post_id', $post->id)
                ->pluck('name');

            return $post;
        });
    }

    private function dbConnection(): ConnectionInterface
    {
        return $this->dbManager->connection();
    }
}
