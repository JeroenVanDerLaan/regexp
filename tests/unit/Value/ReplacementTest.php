<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value;

use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use Jeroenvanderlaan\Regexp\Value\Replacement;
use PHPUnit\Framework\TestCase;

class ReplacementTest extends TestCase
{
    public function testGetReplacement(): void
    {
        $expected = "replacement";
        $regexp = $this->createMock(Regexp::class);
        $match = new Replacement("", "", $regexp, $expected);
        $this->assertEquals($expected, $match->getReplacement());
    }
}