<?php

namespace Jeroenvanderlaan\Regexp\Value\Regexp;

use Jeroenvanderlaan\Regexp\Value\Regexp\Exception\RegexpSyntaxException;

class EscapedRegexp extends Regexp
{
    /**
     * EscapedRegexp constructor.
     * @param string $regexp
     * @throws RegexpSyntaxException
     */
    public function __construct(string $regexp)
    {
        $regexp = preg_quote($regexp, Regexp::DELIMITER);
        parent::__construct($regexp);
    }
}