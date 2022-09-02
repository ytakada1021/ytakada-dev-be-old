<?php

namespace App\Http\Controllers;

use App\Query\Services\PostQueryService;
use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetPost extends Controller
{
    private PostQueryService $queryService;

    public function __construct(PostQueryService $queryService)
    {
        $this->queryService = $queryService;
    }

    public function __invoke(string $postId): JsonResponse
    {
        /** @var stdClass|null $post */
        $post = $this->queryService->getPostOfId($postId);

        if (is_null($post)) {
            throw new NotFoundHttpException("Post of ID ${postId} does not exist.");
        } else {
            return new JsonResponse($post);
        }
    }
}
