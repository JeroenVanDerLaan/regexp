<?php

namespace Jeroenvanderlaan\Regexp\Exception;

use Throwable;

class MatchException extends \Exception
{
    /**
     * @var string
     */
    private $regexp;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $match;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * MatchException constructor.
     * @param string $regexp
     * @param string $subject
     * @param string $match
     * @param int|null $offset
     * @param string $message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(string $regexp, string $subject, string $match, ?int $offset = null, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->regexp = $regexp;
        $this->subject = $subject;
        $this->match = $match;
        $this->offset = $offset;
    }

    /**
     * @return string
     */
    public function getRegexp(): string
    {
        return $this->regexp;
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
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
}