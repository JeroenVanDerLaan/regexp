<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value\String;

use Jeroenvanderlaan\Regexp\Value\Replacement;
use Jeroenvanderlaan\Regexp\Value\String\ReplacedString;
use PHPUnit\Framework\TestCase;

class ReplacedStringTest extends TestCase
{
    public function testGetOriginalString(): void
    {
        $expected = "original string";
        $replaced = new ReplacedString($expected, "");
        $this->assertEquals($expected, $replaced->getOriginalString());
    }

    public function testGetReplacedString(): void
    {
        $expected = "replaced string";
        $replaced = new ReplacedString("", $expected);
        $this->assertEquals($expected, $replaced->getReplacedString());
    }

    public function testToString(): void
    {
        $expected = "replaced string";
        $replaced = new ReplacedString("", $expected);
        $this->assertEquals($expected, (string) $replaced);
    }

    public function testGetReplacements(): void
    {
        $replacement = $this->createMock(Replacement::class);
        $replaced = new ReplacedString("", "", $replacement);
        $this->assertEquals([$replacement], $replaced->getReplacements());
    }
}