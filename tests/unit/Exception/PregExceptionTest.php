<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Exception;

use Jeroenvanderlaan\Regexp\Exception\PregException;
use PHPUnit\Framework\TestCase;

class PregExceptionTest extends TestCase
{
    public function testGetRegexp(): void
    {
        $expected = "regexp";
        $exception = new PregException($expected, "", null);
        $this->assertEquals($expected, $exception->getRegexp());
    }

    public function testGetSubject(): void
    {
        $expected = "subject";
        $exception = new PregException("", $expected, null);
        $this->assertEquals($expected, $exception->getSubject());
    }

    public function testGetOffset(): void
    {
        $expected = 10;
        $exception = new PregException("", "", $expected);
        $this->assertEquals($expected, $exception->getOffset());
    }

    public function testThatErroCodeIsLastPregErrorCode(): void
    {
        @preg_match("/((error)/", "test");
        $expected = preg_last_error();
        $exception = new PregException("", "", null);
        $this->assertEquals($expected, $exception->getCode());
    }
}