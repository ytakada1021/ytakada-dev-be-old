<?php

declare(strict_types=1);

namespace Test\Unit;

use App\Command\Models\Common\Html;
use PHPUnit\Framework\TestCase;

class HtmlTest extends TestCase
{
    public function testValidHtmlFormatIsAccepted(): void
    {
        $htmlString = <<<EOT
            <h1>見出し1</h1>
            <h2>見出し2</h2>
            <h3>見出し3</h3>
            <h4>見出し4</h4>
            <h5>見出し5</h5>
            <h6>見出し6</h6>

            <p>パラグラフ</p>
            <a href="https://www.google.com">リンク</a>
            <strong>Bold</strong>
            <em>Italic</em>
            ~~打ち消し~~
            <blockquote>引用<blockquote>
        EOT;

        new Html($htmlString);
        $this->assertTrue(true);
    }

    public function testInvalidHtmlFormatIsDenied(): void
    {
        $this->expectError();

        $htmlString = <<<EOT
            h1>見出し1</h1>
            <h2>見出し2</h2>
            <h3>見出し3</h3>
            <h4>見出し4</h4>
            <h5>見出し5</h5>
            <h6>見出し6</h6>

            <p>パラグラフ</p>
            <a href="https://www.google.com">リンク</a>
            <strong>Bold</strong>
            <em>Italic</em>
            ~~打ち消し~~
            <blockquote>引用<blockquote>
        EOT;

        new Html($htmlString);
    }
}
