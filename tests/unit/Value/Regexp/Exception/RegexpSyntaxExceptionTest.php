<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value\Regexp\Exception;

use Jeroenvanderlaan\Regexp\Value\Regexp\Exception\RegexpSyntaxException;
use PHPUnit\Framework\TestCase;

class RegexpSyntaxExceptionTest extends TestCase
{
    public function testGetRegexp(): void
    {
        $expected = "regexp";
        $exception = new RegexpSyntaxException($expected);
        $this->assertEquals($expected, $exception->getRegexp());
    }
}