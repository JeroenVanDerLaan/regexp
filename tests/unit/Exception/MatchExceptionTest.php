<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Exception;

use Jeroenvanderlaan\Regexp\Exception\MatchException;
use PHPUnit\Framework\TestCase;

class MatchExceptionTest extends TestCase
{
    public function testGetRegexp(): void
    {
        $expected = "regexp";
        $exception = new MatchException($expected, "", "", null);
        $this->assertEquals($expected, $exception->getRegexp());
    }

    public function testGetSubject(): void
    {
        $expected = "subject";
        $exception = new MatchException("", $expected, "", null);
        $this->assertEquals($expected, $exception->getSubject());
    }

    public function testGetMatch(): void
    {
        $expected = "match";
        $exception = new MatchException("", "", $expected, null);
        $this->assertEquals($expected, $exception->getMatch());
    }

    public function testGetOffset(): void
    {
        $expected = 10;
        $exception = new MatchException("", "", "", $expected);
        $this->assertEquals($expected, $exception->getOffset());
    }
}