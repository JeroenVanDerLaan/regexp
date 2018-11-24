<?php

namespace Jeroenvanderlaan\Regexp\Value;

use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;

class Match
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $match;

    /**
     * @var Regexp
     */
    private $regexp;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var Match[]
     */
    private $groups;

    /**
     * Match constructor.
     * @param string $subject
     * @param string $match
     * @param Regexp $regexp
     * @param int|null $offset
     * @param Match ...$groups
     */
    public function __construct(string $subject, string $match, Regexp $regexp, int $offset = null, Match ...$groups)
    {
        $this->subject = $subject;
        $this->match = $match;
        $this->regexp = $regexp;
        $this->offset = $offset;
        $this->groups = $groups;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMatch(): string
    {
        return $this->match;
    }

    /**
     * @return Regexp
     */
    public function getRegexp(): Regexp
    {
        return $this->regexp;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return Match[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

}