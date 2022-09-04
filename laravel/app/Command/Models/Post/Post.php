<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use Carbon\CarbonImmutable;
use Util\Assert;

final class Post
{
    private Id $id;
    private Title $title;
    private Content $content;
    private array $tags;
    private CarbonImmutable $postedAt;
    private CarbonImmutable $updatedAt;

    /**
     * 以下フォーマットのマークダウンテキストからPostインスタンスを生成する.
     *
     * ```
     * ---
     * id: 'ID'
     * title: 'タイトル'
     * tags:
     *   - 'タグ1'
     *   - 'タグ2'
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
        } elseif (!is_array('tags', $frontMatter)) {
            throw new InvalidMarkdownException(sprintf("tags must be set as array of strings in yaml front matter. Entered markdown:\n%s", $markdown));
        } else {
            foreach ($frontMatter['tags'] as $tag) {
                if (!is_string($tag)) {
                    throw new InvalidMarkdownException(sprintf("tags must be set as array of strings in yaml front matter. Entered markdown:\n%s", $markdown));
                }
            }
        }

        // 本文をhtmlに変換する
        /** @var string $htmlString */
        $htmlString = $converter->convertToHtml($markdown);

        return new self(
            new Id($frontMatter['id']),
            new Title($frontMatter['title']),
            new Content(new Html($htmlString)),
            array_map(function (string $tagString): Tag {
                return new Tag($tagString);
            }, $frontMatter['tags'])
        );
    }

    public function __construct(Id $id, Title $title, Content $content, array $tags)
    {
        Assert::arrayOfClass($tags, Tag::class, sprintf('$tags must be array of %s.', Tag::class));

        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->tags = $tags;
        $this->postedAt = CarbonImmutable::now();
        $this->updatedAt = CarbonImmutable::now();
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function tags(): array
    {
        return $this->tags;
    }

    public function postedAt(): CarbonImmutable
    {
        return $this->postedAt;
    }

    public function updatedAt(): CarbonImmutable
    {
        return $this->updatedAt;
    }
}