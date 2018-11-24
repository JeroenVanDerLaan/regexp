<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value\Regexp;

use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class RegexpTest extends TestCase
{
    public function testGetExpression(): void
    {
        $expected = "/regexp/";
        $regexp = new Regexp($expected);
        $this->assertEquals($expected, $regexp->getExpression());
    }

    public function testToString(): void
    {
        $expected = "/regexp/";
        $regexp = new Regexp($expected);
        $this->assertEquals($expected, (string) $regexp);
    }

    public function testThatDelimitersAreAdded(): void
    {
        $expected = "/regexp/";
        $regexp = new Regexp(trim($expected, "/"));
        $this->assertEquals($expected, $regexp->getExpression());
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Value\Regexp\Exception\RegexpSyntaxException
     */
    public function testThatExceptionIsThrownIfRegexpIsInvalid(): void
    {
        $invalidRegexp = "((regexp)";
        new Regexp($invalidRegexp);
    }
}