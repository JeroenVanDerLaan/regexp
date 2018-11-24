<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit;

use Jeroenvanderlaan\Regexp\Matcher;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class MatcherTest extends TestCase
{
    public function testMatch(): void
    {
        $subject = "some string";
        $expected = "string";
        $expression = "/" . $expected . "/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $match = $matcher->match($regexp, $subject);

        $this->assertEquals($expected, $match->getMatch());
    }

    public function testMatchOffset(): void
    {
        $subject = "some string";
        $expected = strpos($subject, "string");
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $match = $matcher->match($regexp, $subject);

        $this->assertEquals($expected, $match->getOffset());
    }

    public function testMatchWithCaptureGroups(): void
    {
        $subject = "some string";
        $expression = "/(str)(ing)/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $match = $matcher->match($regexp, $subject);
        $groups = $match->getGroups();
        $groupA = array_shift($groups);
        $groupB = array_shift($groups);

        $this->assertEquals("string", $match->getMatch());
        $this->assertEquals("str", $groupA->getMatch());
        $this->assertEquals("ing", $groupB->getMatch());
    }

    public function testThatMatchIsNullIfNoMatchIsFound(): void
    {
        $subject = "some string";
        $expression = "/foo/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $match = $matcher->match($regexp, $subject);

        $this->assertNull($match);
    }

    public function testMatchAll(): void
    {
        $subject = "some string some string";
        $expected = "string";
        $expression = "/" . $expected . "/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matches = $matcher->matchAll($regexp, $subject);
        $matchA = array_shift($matches);
        $matchB = array_shift($matches);

        $this->assertEquals($expected, $matchA->getMatch());
        $this->assertEquals($expected, $matchB->getMatch());
    }

    public function testMatchAllOffsets(): void
    {
        $subject = "some string some string";
        $expectedA = strpos($subject, "string");
        $expectedB = strpos($subject, "string", $expectedA + strlen("string"));
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matches = $matcher->matchAll($regexp, $subject);
        $matchA = array_shift($matches);
        $matchB = array_shift($matches);

        $this->assertEquals($expectedA, $matchA->getOffset());
        $this->assertEquals($expectedB, $matchB->getOffset());
    }

    public function testMatchAllWithCapturingGroups(): void
    {
        $subject = "some string some string";
        $expression = "/(str)ing/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matches = $matcher->matchAll($regexp, $subject);
        $matchA = array_shift($matches);
        $groupsA = $matchA->getGroups();
        $groupA = array_shift($groupsA);
        $matchB = array_shift($matches);
        $groupsB = $matchB->getGroups();
        $groupB = array_shift($groupsB);

        $this->assertEquals("string", $matchA->getMatch());
        $this->assertEquals("str", $groupA->getMatch());
        $this->assertEquals("string", $matchB->getMatch());
        $this->assertEquals("str", $groupB->getMatch());
    }

    public function testThatMatchesAreEmptyIfNoMatchesAreFound(): void
    {
        $subject = "some string";
        $expression = "/foo/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matches = $matcher->matchAll($regexp, $subject);

        $this->assertEmpty($matches);
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\PregException
     */
    public function testThatExceptionIsThrownIfMatchingFailed(): void
    {
        $subject = "some string";
        $expression = "/((((/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matcher->match($regexp, $subject);
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\PregException
     */
    public function testThatExceptionIsThrownIfMatchingAllFailed(): void
    {
        $subject = "some string";
        $expression = "/((((/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $matcher = new Matcher();
        $matcher->matchAll($regexp, $subject);
    }
}