<?php

namespace App\Providers;

use Carbon\Doctrine\CarbonImmutableType;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;
use Mapping\HtmlType;
use Mapping\PostIdType;

class DbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Doctrine EntityManagerをDIコンテナへ登録する
        // See also:
        // - https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/reference/configuration.html#obtaining-an-entitymanager
        // - https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/xml-mapping.html
        $this->app->singleton(EntityManagerInterface::class, function (): EntityManager {
            /** @var Configuration $config */
            $config = ORMSetup::createXMLMetadataConfiguration(
                paths: [__DIR__ . '/../../config/mapping'],
                isDevMode: false
            );

            return EntityManager::create(
                connection: [
                    'driver' => 'pdo_mysql',
                    'user' => config('database.connections.mysql.username'),
                    'password' => config('database.connections.mysql.password'),
                    'host' => config('database.connections.mysql.host'),
                    'dbname' => config('database.connections.mysql.database')
                ],
                config: $config
            );
        });
    }

    public function boot(): void
    {
        // Doctrineのカスタムタイプを登録する
        // See also: https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/cookbook/custom-mapping-types.html
        Type::addType('carbon_immutable', CarbonImmutableType::class);
        Type::addType('html', HtmlType::class);
        Type::addType('post_id', PostIdType::class);
    }
}
