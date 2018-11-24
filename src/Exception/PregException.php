<?php

namespace Jeroenvanderlaan\Regexp\Exception;

use Throwable;

class PregException extends \Exception
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
     * @var int|null
     */
    private $offset;

    /**
     * PregException constructor.
     * @param string $regexp
     * @param string $subject
     * @param int|null $offset
     * @param string $message
     * @param null|Throwable $previous
     */
    public function __construct(string $regexp, string $subject, ?int $offset = null, string $message = "", ?Throwable $previous = null)
    {
        $code = preg_last_error();
        parent::__construct($message, $code, $previous);
        $this->regexp = $regexp;
        $this->subject = $subject;
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
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }
}