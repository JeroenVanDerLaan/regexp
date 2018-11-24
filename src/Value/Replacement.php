<?php

namespace Jeroenvanderlaan\Regexp\Value;

use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;

class Replacement extends Match
{
    /**
     * @var string
     */
    private $replacement;

    /**
     * Replacement constructor.
     * @param string $subject
     * @param string $match
     * @param Regexp $regexp
     * @param string $replacement
     */
    public function __construct(string $subject, string $match, Regexp $regexp, string $replacement)
    {
        parent::__construct($subject, $match, $regexp);
        $this->replacement = $replacement;
    }

    /**
     * @return string
     */
    public function getReplacement(): string
    {
        return $this->replacement;
    }
}