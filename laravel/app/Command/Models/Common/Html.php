<?php

declare(strict_types=1);

namespace App\Command\Models\Common;

use App\Command\Models\Common\Exceptions\InvalidHtmlFormatException;
use DOMDocument;

final class Html
{
    public readonly string $value;

    /**
     * @param string $value
     * @throws InvalidHtmlFormatException
     */
    public function __construct(string $value)
    {
        $this->checkHtmlFormat($value);
        $this->value = $value;
    }

    private function checkHtmlFormat(string $text): void
    {
        $dom = new DOMDocument();

        /** @var bool $isValidFormat */
        $isValidFormat = $dom->loadHTML($text);

        if ($isValidFormat) {
            return;
        } else {
            throw new InvalidHtmlFormatException(sprintf("Invalid html format:\n%s", $text));
        }
    }
}
