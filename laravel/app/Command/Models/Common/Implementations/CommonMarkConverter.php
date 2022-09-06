<?php

declare(strict_types=1);

namespace App\Command\Models\Common\Implementations;

use App\Command\Models\Common\Html;
use App\Command\Models\Common\MarkdownConverter;
use League\CommonMark\CommonMarkConverter as LeagueConverter;
use League\CommonMark\Extension\FrontMatter\Data\SymfonyYamlFrontMatterParser;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;
use League\CommonMark\Extension\FrontMatter\Input\MarkdownInputWithFrontMatter;

final class CommonMarkConverter implements MarkdownConverter
{
    public function extractYamlFrontMatter(string $markdown): array
    {
        return $this
            ->buildFrontMatterParser()
            ->parse($markdown)
            ->getFrontMatter();
    }

    public function convertToHtml(string $markdown): Html
    {
        /** @var string $contentWithoutFrontMatter */
        $contentWithoutFrontMatter = $this
            ->buildFrontMatterParser()
            ->parse($markdown)
            ->getContent();

        $converter = new LeagueConverter();

        return new Html($converter->convert($contentWithoutFrontMatter)->getContent());
    }

    private function buildFrontMatterParser(): FrontMatterParser
    {
        return new FrontMatterParser(new SymfonyYamlFrontMatterParser());
    }
}
