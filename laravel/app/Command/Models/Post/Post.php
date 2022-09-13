<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Common\MarkdownConverter;
use App\Command\Models\Post\Exceptions\InvalidMarkdownException;
use Carbon\CarbonImmutable;

final class Post
{
    public const MARKDOWN_FORMAT = <<<EOT
        ---
        title: Title of post
        ---

        Content... (in Markdown)
    EOT;

    private PostId $id;
    private PostTitle $title;
    private PostContent $content;
    private CarbonImmutable $postedAt;
    private ?CarbonImmutable $updatedAt;

    /**
     * 以下フォーマットのマークダウンテキストからPostインスタンスを生成する.
     * ```
     * ---
     * title: 'タイトル'
     * ---
     *
     * （本文）
     * ```
     * フォーマットに合わない文字列が渡された場合に`InvalidMarkdownException`を送出する.
     * @param MarkdownConverter $converter
     * @param PostId $postId
     * @param string $markdown
     * @throws InvalidMarkdownException
     * @return self
     */
    public static function createFromMarkdown(
        MarkdownConverter $converter,
        PostId $postId,
        string $markdown
    ): self {
        /** @var array $frontMatter */
        $frontMatter = $converter->extractYamlFrontMatter($markdown);

        if (!is_string($frontMatter['title'])) {
            throw new InvalidMarkdownException(
                sprintf(
                    "title must be set as string in yaml front matter. Expected markdown text format:\n%s",
                    self::MARKDOWN_FORMAT
                )
            );
        }

        return new self(
            $postId,
            new PostTitle($frontMatter['title']),
            new PostContent($converter->convertToHtml($markdown))
        );
    }

    public function updateFromMarkdown(
        MarkdownConverter $converter,
        string $markdown
    ): void {
        /** @var array $frontMatter */
        $frontMatter = $converter->extractYamlFrontMatter($markdown);

        if (!is_string($frontMatter['title'])) {
            throw new InvalidMarkdownException(
                sprintf(
                    "title must be set as string in yaml front matter. Expected markdown text format:\n%s",
                    self::MARKDOWN_FORMAT
                )
            );
        }

        $this->updateTitle(new PostTitle($frontMatter['title']));
        $this->updateContent(new PostContent($converter->convertToHtml($markdown)));
    }

    public function updateTitle(PostTitle $title): void
    {
        if ($this->title() == $title) {
            return;
        }

        $this->title = $title;
        $this->reflectToUpdatedAt();
    }

    public function updateContent(PostContent $content): void
    {
        if ($this->content() == $content) {
            return;
        }

        $this->content = $content;
        $this->reflectToUpdatedAt();
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

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->updatedAt;
    }

    private function __construct(PostId $id, PostTitle $title, PostContent $content)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->postedAt = CarbonImmutable::now();
        $this->updatedAt = null;
    }

    private function reflectToUpdatedAt(): void
    {
        $this->updatedAt = CarbonImmutable::now();
    }
}
