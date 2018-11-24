<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit;

use Jeroenvanderlaan\Regexp\Substitutor;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use PHPUnit\Framework\TestCase;

class SubstitutorTest extends TestCase
{
    public function testSubstituteReplacesRegexp(): void
    {
        $subject = "some % string";
        $expression = "/\%/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $substitutor = new Substitutor();
        $replaced = $substitutor->substitute($regexp, $subject);

        $this->assertFalse(strpos($replaced->getReplacedString(), "%"));
    }

    public function testThatReplacedStringContainsReferenceToOriginalString(): void
    {
        $subject = "some % string";
        $expression = "/\%/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $substitutor = new Substitutor();
        $replaced = $substitutor->substitute($regexp, $subject);

        $this->assertEquals($subject, $replaced->getOriginalString());
    }

    public function testThatReplacedStringContainsReferenceToSubstitutes(): void
    {
        $subject = "some % string";
        $expression = "/\%/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $substitutor = new Substitutor();
        $replaced = $substitutor->substitute($regexp, $subject);
        $substitutes = $replaced->getReplacements();
        $substitute = array_shift($substitutes);
        $replacement = $substitute->getReplacement();
        $expected = "some " . $replacement . " string";

        $this->assertEquals($expected, $replaced->getReplacedString());
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\MatchException
     */
    public function testThatExceptionIsThrownIfTryingSubstituteNonAlphaNumericCharacters(): void
    {
        $subject = "some string";
        $expression = "/string/";
        $regexp = $this->createMock(Regexp::class);
        $regexp->method("getExpression")->willReturn($expression);

        $substitutor = new Substitutor();
        $substitutor->substitute($regexp, $subject);
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

        $substitutor = new Substitutor();
        $substitutor->substitute($regexp, $subject);
    }
}