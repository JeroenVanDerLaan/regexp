<?php

namespace Jeroenvanderlaan\Regexp;

use Jeroenvanderlaan\Regexp\Exception\MatchException;
use Jeroenvanderlaan\Regexp\Exception\PregException;
use Jeroenvanderlaan\Regexp\Value\Substitute;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use Jeroenvanderlaan\Regexp\Value\String\ReplacedString;

class Substitutor
{
    /**
     * @param Regexp $regexp
     * @param string $subject
     * @return ReplacedString
     * @throws MatchException
     * @throws PregException
     */
    public function substitute(Regexp $regexp, string $subject): ReplacedString
    {
        $substitutes = [];
        $offset = 0;
        $callback = function (array $match) use (&$substitutes, &$offset, $regexp, $subject) {
            $match = $match[0];
            $substitute = new Substitute($subject, $match, $regexp);
            $substitutes[] = $substitute;
            $offset = $offset + strlen($match);
            return $substitute->getReplacement();
        };
        $replaced = $this->pregReplaceCallback($regexp, $subject, $callback);
        return new ReplacedString($subject, $replaced, ...$substitutes);
    }

    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param callable $callback
     * @return string
     * @throws MatchException
     * @throws PregException
     */
    private function pregReplaceCallback(Regexp $regexp, string $subject, callable $callback): string
    {
        try {
            $replaced = preg_replace_callback($regexp->getExpression(), $callback, $subject);
        } catch (MatchException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            throw new PregException($regexp, $subject, null, "Failed to execute preg_replace_callback", $throwable);
        }
        return $replaced;
    }
}