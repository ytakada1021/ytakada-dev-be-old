<?php

declare(strict_types=1);

namespace App\Command\Models\Common\Implementations;

use App\Command\Models\Common\Html;
use App\Command\Models\Common\MarkdownConverter;
use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use League\CommonMark\Extension\FrontMatter\Input\MarkdownInputWithFrontMatter;

final class LeagueMarkdownConverter implements MarkdownConverter
{
    public function extractYamlFrontMatter(string $markdown): array
    {
        /** @var MarkdownInputWithFrontMatter $result */
        $result = $this->buildFrontMatterParser()->parse($markdown);

        return $result->getFrontMatter();
    }

    public function convertToHtml(string $markdown): Html
    {
        /** @var MarkdownInputWithFrontMatter $result */
        $result = $this->buildFrontMatterParser()->parse($markdown);

        return new Html($result->getContent());
    }

    private function buildFrontMatterParser(): FrontMatterParser
    {
        return new FrontMatterParser(new SymfonyYamlFrontMatterParser());
    }
}
