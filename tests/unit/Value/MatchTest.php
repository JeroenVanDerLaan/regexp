<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value;

use Jeroenvanderlaan\Regexp\Value\Match;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testGetSubject(): void
    {
        $expected = "subject";
        $regexp = $this->createMock(Regexp::class);
        $match = new Match($expected, "", $regexp);
        $this->assertEquals($expected, $match->getSubject());
    }

    public function testGetMatch(): void
    {
        $expected = "match";
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", $expected, $regexp);
        $this->assertEquals($expected, $match->getMatch());
    }

    public function testGetRegexp(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", "", $regexp);
        $this->assertEquals($regexp, $match->getRegexp());
    }

    public function testGetOffset(): void
    {
        $expected = 10;
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", "", $regexp, $expected);
        $this->assertEquals($expected, $match->getOffset());
    }

    public function testThatOffsetIsNullByDefault(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", "", $regexp);
        $this->assertNull($match->getOffset());
    }

    public function testGetGroups(): void
    {
        $group = $this->createMock(Match::class);
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", "", $regexp, null, $group);
        $this->assertEquals([$group], $match->getGroups());
    }

    public function testThatGroupsAreEmptyByDefault(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $match = new Match("", "", $regexp);
        $this->assertEmpty($match->getGroups());
    }
}