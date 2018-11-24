<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit;

use Jeroenvanderlaan\Regexp\Replacer;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class ReplacerTest extends TestCase
{
    public function testReplace(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $expected = "some integer";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replaced = $replacer->replace($regexp, $subject, function () {
            return "integer";
        });

        $this->assertEquals($expected, $replaced->getReplacedString());
    }

    public function testThatMatchIsPassedToCallback(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $expected = "string";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $result = null;
        $replacer = new Replacer();
        $replacer->replace($regexp, $subject, function (string $match) use (&$result) {
            $result = $match;
            return $match;
        });

        $this->assertEquals($expected, $result);
    }

    public function testThatReplacedStringContainsReferenceToOriginalString(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replaced = $replacer->replace($regexp, $subject, function () {
            return "";
        });

        $this->assertEquals($subject, $replaced->getOriginalString());
    }

    public function testThatReplacedStringContainsReferenceToReplacements(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $expected = "integer";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replaced = $replacer->replace($regexp, $subject, function () {
            return "integer";
        });

        $replacements = $replaced->getReplacements();
        $replacement = array_shift($replacements);

        $this->assertEquals($expected, $replacement->getReplacement());
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\PregException
     */
    public function testThatExceptionIsThrownIfReplacingFailed(): void
    {
        $subject = "some string";
        $expression = "/(()/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replacer->replace($regexp, $subject, function () {
            return "";
        });
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\CallableException
     */
    public function testThatExceptionIsThrownIfReplacementCallbackFailed(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replacer->replace($regexp, $subject, function (int $invalidType) {
            return "";
        });
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\CallableException
     */
    public function testThatExceptionIsThrownIfReplacementCallbackDoesNotReturnString(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $replacer = new Replacer();
        $replacer->replace($regexp, $subject, function () {
            return null;
        });
    }
}