<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Models\DefaultPost;
use App\Query\Services\GetPostQueryService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetPostController extends Controller
{
    public function __construct(private GetPostQueryService $queryService) {}

    public function __invoke(string $postId): JsonResponse
    {
        /** @var ?DefaultPost $post */
        $postOrNull = $this->queryService->getPostOfId($postId);

        if (is_null($postOrNull)) {
            throw new NotFoundHttpException("Post of ID '{$postId}' does not exist.");
        } else {
            /** @var DefaultPost $post */
            $post = $postOrNull;

            return new JsonResponse($post);
        }
    }
}
