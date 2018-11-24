<?php

namespace Jeroenvanderlaan\Regexp\Value\Regexp\Exception;

use Throwable;

class RegexpSyntaxException extends \Exception
{
    /**
     * @var string
     */
    private $regexp;

    /**
     * RegexpSyntaxException constructor.
     * @param string $regexp
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $regexp, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->regexp = $regexp;
    }

    /**
     * @return string
     */
    public function getRegexp(): string
    {
        return $this->regexp;
    }
}