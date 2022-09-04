<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Exceptions\PostAlreadyExistsException;
use App\Command\Models\Post\Post;
use App\Command\Services\Post\CreatePostApplicationService;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreatePostController extends Controller
{
    private readonly CreatePostApplicationService $applicationService;

    public function __construct(CreatePostApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            /** @var Post $domainModel */
            $domainModel = $this
                ->applicationService
                ->execute(new Input('sample'));
        } catch (InvalidMarkdownException $e) {
            // TODO: エラーメッセージへの変換処理
            throw new BadRequestHttpException();
        } catch (PostAlreadyExistsException $e) {
            throw new BadRequestHttpException();
        }

        // TODO: APIモデルへの変換
        return new JsonResponse(status: 201);
    }
}
