<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value\Regexp;

use Jeroenvanderlaan\Regexp\Value\Regexp\EscapedRegexp;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class EscapedRegexpTest extends TestCase
{
    public function testThatRegexpIsEscaped(): void
    {
        $regexp = "((regexp)";
        $expected = Regexp::DELIMITER . preg_quote($regexp) . Regexp::DELIMITER;
        $regexp = new EscapedRegexp($regexp);
        $this->assertEquals($expected, $regexp->getExpression());
    }
}