<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Exceptions\PostAlreadyExistsException;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use App\Command\Services\Post\CreatePostAppService;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreatePostController extends Controller
{
    private readonly CreatePostAppService $appService;

    public function __construct(CreatePostAppService $appService)
    {
        $this->appService = $appService;
    }

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        try {
            $this->appService
                 ->execute(new Input($request->file('post')->get()));
        } catch (InvalidMarkdownException|PostAlreadyExistsException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new JsonResponse(status: 201);
    }
}
