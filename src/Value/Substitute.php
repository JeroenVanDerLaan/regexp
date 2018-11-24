<?php

namespace Jeroenvanderlaan\Regexp\Value;

use Jeroenvanderlaan\Regexp\Exception\MatchException;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;

class Substitute extends Replacement
{
    /**
     * @var int
     */
    const DELIMITER = 0x1F;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * Substitute constructor.
     * @param string $subject
     * @param string $match
     * @param Regexp $regexp
     * @throws MatchException
     */
    public function __construct(string $subject, string $match, Regexp $regexp)
    {
        $hasAlphanumeric = (bool) preg_match("/[A-Za-z0-9]/", $match);
        if ($hasAlphanumeric) {
            throw new MatchException($regexp, $subject, $match, null, "Can not substitute match with alphanumeric characters");
        }

        $delimiter = chr(self::DELIMITER);
        $hasDelimiter = false !== strpos($match, $delimiter);
        if ($hasDelimiter) {
            throw new MatchException($regexp, $subject, $match, null, "Can not substitute match with " . $delimiter . " characters");
        }

        $this->id = uniqid();
        $this->delimiter = $delimiter;
        $replacement = $delimiter . $this->id . $delimiter;
        parent::__construct($subject, $match, $regexp, $replacement);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }
}