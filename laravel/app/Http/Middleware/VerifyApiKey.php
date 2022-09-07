<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Util\Assert;

final class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        Assert::notNull(config('app.api_key'), "API_KEY must be set as env.");

        /** @var ?string $apiKey */
        $apiKeyByClient = $request->header('x-api-key');

        if (is_null($apiKeyByClient)
                or ($apiKeyByClient !== config('app.api_key'))
        ) {
            throw new AuthenticationException('Wrong api key');
        }

        return $next($request);
    }
}
