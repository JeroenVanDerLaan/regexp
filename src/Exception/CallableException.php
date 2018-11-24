<?php

namespace Jeroenvanderlaan\Regexp\Exception;

use Throwable;

class CallableException extends \Exception
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * @var array
     */
    private $arguments;

    /**
     * CallableException constructor.
     * @param callable $callable
     * @param array $arguments
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(callable $callable, array $arguments, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->callable = $callable;
        $this->arguments = $arguments;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
        return $this->callable;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

}