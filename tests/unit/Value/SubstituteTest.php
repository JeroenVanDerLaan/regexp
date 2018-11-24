<?php

namespace Jeroenvanderlaan\Regexp\Tests\Unit\Value;

use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use Jeroenvanderlaan\Regexp\Value\Substitute;
use PHPUnit\Framework\TestCase;

class SubstituteTest extends TestCase
{
    public function testIdLength(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $substitute = new Substitute("", "", $regexp);

        $id = $substitute->getId();
        $expectedLength = strlen(uniqid());

        $this->assertEquals($expectedLength, strlen($id));
    }

    public function testIdCharacters(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $substitute = new Substitute("", "", $regexp);

        $id = $substitute->getId();

        $match = [];
        preg_match("/[a-z0-9]*/", $id, $match);
        $expected = array_shift($match);

        $this->assertEquals($expected, $id);
    }

    public function testIdUniqueness(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $substituteA = new Substitute("", "", $regexp);
        $substituteB = new Substitute("", "", $regexp);

        $this->assertNotEquals($substituteA->getId(), $substituteB->getId());
    }

    public function testGetDelimiter(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $substitute = new Substitute("", "", $regexp);
        $expected = chr(Substitute::DELIMITER);
        $this->assertEquals($expected, $substitute->getDelimiter());
    }

    public function testGetReplacement(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $substitute = new Substitute("", "", $regexp);

        $delimiter = chr(Substitute::DELIMITER);
        $expected = $delimiter . $substitute->getId() . $delimiter;

        $this->assertEquals($expected, $substitute->getReplacement());
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\MatchException
     */
    public function testThatExceptionIsThrownIfMatchContainsAlphanumericCharacters(): void
    {
        $regexp = $this->createMock(Regexp::class);
        new Substitute("", "alphanumeric", $regexp);
    }

    /**
     * @expectedException \Jeroenvanderlaan\Regexp\Exception\MatchException
     */
    public function testThatExceptionIsThrownIfMatchContainsDelimiterCharacter(): void
    {
        $regexp = $this->createMock(Regexp::class);
        $delimiter = chr(Substitute::DELIMITER);
        new Substitute("", $delimiter, $regexp);
    }
}