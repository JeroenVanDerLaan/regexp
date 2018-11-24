<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit;

use Jeroenvanderlaan\Regexp\Unreplacer;
use Jeroenvanderlaan\Regexp\Value\Replacement;
use PHPUnit\Framework\TestCase;

class UnreplacerTest extends TestCase
{
    public function testUnreplace(): void
    {
        $subject = "some integer";
        $expected = "some string";
        $match = "string";
        $replaced = "integer";
        $replacement = $this->createMock(Replacement::class);
        $replacement->method("getMatch")->willReturn($match);
        $replacement->method("getReplacement")->willReturn($replaced);

        $unreplacer = new Unreplacer();
        $unreplaced = $unreplacer->unreplace($subject, $replacement);

        $this->assertEquals($expected, $unreplaced);
    }

    public function testThatSubjectIsReturnedIfNoReplacementsAreProvided(): void
    {
        $subject = "some string";
        $unreplacer = new Unreplacer();
        $unreplaced = $unreplacer->unreplace($subject);
        $this->assertEquals($subject, $unreplaced);
    }
}