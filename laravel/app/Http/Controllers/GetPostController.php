<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Query\Services\GetPostQueryService;
use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetPostController extends Controller
{
    private GetPostQueryService $queryService;

    public function __construct(GetPostQueryService $queryService)
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
