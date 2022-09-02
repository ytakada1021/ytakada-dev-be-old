<?php

namespace App\Query\Services;

use Carbon\CarbonImmutable;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;
use stdClass;

final class PostQueryService
{
    private DatabaseManager $dbManager;

    public function __construct(DatabaseManager $dbManager)
    {
        $this->dbManager = $dbManager;
    }

    public function getPostOfId(string $postId): stdClass|null
    {
        /** @var Collection $queryResult */
        $queryResult = $this
            ->dbConnection()
            ->table('posts')

            ->select('*')

            ->where('posts.id', $postId)
            ->whereNull('posts.deleted_at')

            ->leftJoin('tags', 'posts.id', '=', 'tags.post_id')

            ->get();

        if ($queryResult->isEmpty()) {
            return null;
        } else {
            return $this->convertQueryResultToApiResponseModel($queryResult);
        }
    }

    private function convertQueryResultToApiResponseModel(Collection $queryResult): stdClass
    {
        /** @var stdClass $firstResult */
        $firstResult = $queryResult->first();

        $post = new stdClass();
        $post->id = $firstResult->id;
        $post->title = $firstResult->title;
        $post->content = $firstResult->content;
        $post->posted_at = new CarbonImmutable($firstResult->posted_at);
        $post->update_at = new CarbonImmutable($firstResult->updated_at);

        $post->tags = $queryResult->pluck(['name'])->whereNotNull();

        return $post;
    }

    private function dbConnection(): ConnectionInterface
    {
        return $this->dbManager->connection();
    }
}
