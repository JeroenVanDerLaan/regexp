<?php

namespace Jeroenvanderlaan\Regexp\Value\String;

use Jeroenvanderlaan\Regexp\Value\Replacement;

class ReplacedString
{
    /**
     * @var string
     */
    private $originalString;

    /**
     * @var string
     */
    private $replacedString;

    /**
     * @var Replacement[]
     */
    private $replacements;

    /**
     * ReplacedString constructor.
     * @param string $original
     * @param string $replaced
     * @param Replacement ...$replacements
     */
    public function __construct(string $original, string $replaced, Replacement ...$replacements)
    {
        $this->originalString = $original;
        $this->replacedString = $replaced;
        $this->replacements = $replacements;
    }

    /**
     * @return string
     */
    public function getOriginalString(): string
    {
        return $this->originalString;
    }

    /**
     * @return string
     */
    public function getReplacedString(): string
    {
        return $this->replacedString;
    }

    /**
     * @return Replacement[]
     */
    public function getReplacements(): array
    {
        return $this->replacements;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->replacedString;
    }
}