<?php

declare(strict_types=1);

namespace App\Command\Models\Post;

use App\Command\Models\Post\Exceptions\InvalidHtmlFormatException;
use DOMDocument;

final class Html
{
    private readonly string $value;

    /**
     * @param string $value
     * @throws InvalidHtmlFormatException
     */
    public function __construct(string $value)
    {
        $this->checkHtmlFormat($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function checkHtmlFormat(string $text): void
    {
        $dom = new DOMDocument();
        $isValidFormat = $dom->loadHTML($text);

        if ($isValidFormat) {
            return;
        } else {
            throw new InvalidHtmlFormatException(sprintf("Invalid html format:\n%s", $text));
        }
    }
}
