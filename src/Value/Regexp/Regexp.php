<?php

namespace Jeroenvanderlaan\Regexp\Value\Regexp;

use Jeroenvanderlaan\Regexp\Value\Regexp\Exception\RegexpSyntaxException;

class Regexp
{
    /**
     * @var string
     */
    public const DELIMITER = "/";

    /**
     * @var string
     */
    private $regexp;

    /**
     * Regexp constructor.
     * @param string $regexp
     * @throws RegexpSyntaxException
     */
    public function __construct(string $regexp)
    {
        $regexp = trim($regexp, self::DELIMITER);
        $regexp = self::DELIMITER . $regexp . self::DELIMITER;

        try {
            preg_match($regexp, null);
        } catch (\Throwable $throwable) {
            throw new RegexpSyntaxException($regexp, "preg_match on null returned false", 0, $throwable);
        }

        $this->regexp = $regexp;
    }

    /**
     * @return string
     */
    public function getExpression(): string
    {
        return $this->regexp;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->regexp;
    }
}