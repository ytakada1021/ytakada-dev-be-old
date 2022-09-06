<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use App\Command\Models\Post\Post;
use App\Command\Services\Post\CreateOrUpdatePostAppService;
use App\Command\Services\Post\CreatePostApplicationService\Input;
use App\Http\Requests\CreateOrUpdatePostRequest;
use Illuminate\Http\JsonResponse;
use stdClass;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateOrUpdatePostController extends Controller
{
    private readonly CreateOrUpdatePostAppService $appService;

    public function __construct(CreateOrUpdatePostAppService $appService)
    {
        $this->appService = $appService;
    }

    public function __invoke(CreateOrUpdatePostRequest $request): JsonResponse
    {
        /** @var Post $domainModel  */
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
            $this->convertDomainModelToApiResponseModel($domainModel),
            200
        );
    }

    private function convertDomainModelToApiResponseModel(Post $domainModel): stdClass
    {
        $apiModel = new stdClass();
        $apiModel->id = $domainModel->id()->value();
        $apiModel->title = $domainModel->title()->value();
        $apiModel->content = $domainModel->content()->value()->value();
        $apiModel->posted_at = $domainModel->postedAt()->toIso8601String();
        $apiModel->updated_at = $domainModel->updatedAt()->toIso8601String();

        return $apiModel;
    }
}
