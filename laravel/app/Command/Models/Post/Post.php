<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Common\Html;
use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use Carbon\CarbonImmutable;

final class Post
{
    private PostId $id;
    private PostTitle $title;
    private PostContent $content;
    private CarbonImmutable $postedAt;
    private CarbonImmutable $updatedAt;

    /**
     * 以下フォーマットのマークダウンテキストからPostインスタンスを生成する.
     * ```
     * ---
     * id: 'ID'
     * title: 'タイトル'
     * ---
     *
     * （本文）
     * ```
     * フォーマットに合わない文字列が渡された場合に`InvalidMarkdownException`を送出する.
     * @param MarkdownConverter $converter
     * @param string $markdown
     * @throws InvalidMarkdownException
     * @return self
     */
    public static function createFromMarkdown(MarkdownConverter $converter, string $markdown): self
    {
        /** @var array $frontMatter */
        $frontMatter = $converter->extractYamlFrontMatter($markdown);

        // Yaml Front Matterの書式チェックする
        if (!is_string($frontMatter['id'])) {
            throw new InvalidMarkdownException(sprintf("id must be set as string in yaml front matter. Entered markdown:\n%s", $markdown));
        } elseif (!is_string($frontMatter['title'])) {
            throw new InvalidMarkdownException(sprintf("title must be set as string in yaml front matter. Entered markdown:\n%s", $markdown));
        }

        // 本文をhtmlに変換する
        /** @var Html $htmlString */
        $html = $converter->convertToHtml($markdown);

        return new self(
            new PostId($frontMatter['id']),
            new PostTitle($frontMatter['title']),
            new PostContent($html)
        );
    }

    public function id(): PostId
    {
        return $this->id;
    }

    public function title(): PostTitle
    {
        return $this->title;
    }

    public function content(): PostContent
    {
        return $this->content;
    }

    public function postedAt(): CarbonImmutable
    {
        return $this->postedAt;
    }

    public function updatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }

    private function __construct(PostId $id, PostTitle $title, PostContent $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->postedAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }
}
