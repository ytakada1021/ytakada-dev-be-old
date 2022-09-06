<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Exceptions\PostAlreadyExistsException;
use App\Command\Models\Post\Post;
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
            /** @var Post $domainModel */
            $domainModel = $this
                ->appService
                ->execute(new Input($request->file('post')->get()));
        } catch (InvalidMarkdownException $e) {
            // TODO: エラーメッセージへの変換処理
            throw new BadRequestHttpException($e->getMessage());
        } catch (PostAlreadyExistsException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        // TODO: APIモデルへの変換
        return new JsonResponse(status: 201);
    }
}
