<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Post;
use App\Command\Services\Post\CreateOrUpdatePostAppService;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use App\Http\Models\DefaultPost;
use App\Http\Requests\CreateOrUpdatePostRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateOrUpdatePostController extends Controller
{
    public function __construct(private CreateOrUpdatePostAppService $appService) {}

    public function __invoke(CreateOrUpdatePostRequest $request): JsonResponse
    {
        /** @var Post $domainModel */
        $domainModel;

        try {
            $domainModel = $this
                ->appService
                ->execute(new Input(
                    pathinfo($request->file('post')->getClientOriginalName(), PATHINFO_FILENAME),
                    $request->file('post')->get()
                ));
        } catch (InvalidMarkdownException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        return new JsonResponse(
            data: DefaultPost::createFromDomainModel($domainModel),
            status: 200
        );
    }
}
