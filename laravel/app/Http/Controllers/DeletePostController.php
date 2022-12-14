<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Services\Post\DeletePostAppService;
use App\Command\Services\Post\DeletePostAppService\Input;
use Illuminate\Http\JsonResponse;

final class DeletePostController extends Controller
{
    public function __construct(private DeletePostAppService $appService) {}

    public function __invoke(string $postId): JsonResponse
    {
        $this->appService->execute(new Input($postId));

        return new JsonResponse(status: 204);
    }
}
