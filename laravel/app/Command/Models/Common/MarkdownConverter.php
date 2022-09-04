<?php

declare(strict_types=1);

namespace App\Command\Models\Common;

use App\Command\Models\Post\Exceptions\InvalidMarkdownException;

interface MarkdownConverter
{
    /**
     * @throws InvalidMarkdownException
     */
    function extractYamlFrontMatter(string $markdown): array;

    /**
     * @throws InvalidMarkdownException
     */
    function convertToHtml(string $markdown): string;
}
