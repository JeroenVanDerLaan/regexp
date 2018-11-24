<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Exception;

use Jeroenvanderlaan\Regexp\Exception\CallableException;
use PHPUnit\Framework\TestCase;

class CallableExceptionTest extends TestCase
{
    public function testGetCallable(): void
    {
        $callable = function () {};
        $exception = new CallableException($callable, []);
        $this->assertEquals($callable, $exception->getCallable());
    }

    public function testGetArguments(): void
    {
        $callable = function () {};
        $expected = ["argument"];
        $exception = new CallableException($callable, $expected);
        $this->assertEquals($expected, $exception->getArguments());
    }
}