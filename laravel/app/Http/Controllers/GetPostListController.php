<?php

namespace App\Http\Controllers;

use App\Query\Services\GetPostListQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class GetPostListController extends Controller
{
    private GetPostListQueryService $queryService;

    public function __construct(GetPostListQueryService $queryService)
    {
        $this->queryService = $queryService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var int $pageNumber */
        $pageNumber = $request->query('page', 1);

        /** @var Collection $posts */
        $posts = $this->queryService->getPostListOfPage($pageNumber);

        return new JsonResponse($posts);
    }
}
