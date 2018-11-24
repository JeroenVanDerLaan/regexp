<?php

namespace Jeroenvanderlaan\Regexp;

use Jeroenvanderlaan\Regexp\Exception\CallableException;
use Jeroenvanderlaan\Regexp\Exception\PregException;
use Jeroenvanderlaan\Regexp\Value\Replacement;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use Jeroenvanderlaan\Regexp\Value\String\ReplacedString;

class Replacer
{
    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param callable $replacer
     * @return ReplacedString
     * @throws CallableException
     * @throws PregException
     */
    public function replace(Regexp $regexp, string $subject, callable $replacer): ReplacedString
    {
        $replacements = [];
        $offset = 0;
        $callback = function (array $match) use (&$replacements, &$offset, $regexp, $subject, $replacer) {
            $match = $match[0];
            $replacement = $this->getReplacement($replacer, $match);
            $replacements[] = new Replacement($subject, $match, $regexp, $replacement);
            $offset = $offset + strlen($match);
            return $replacement;
        };
        $replaced = $this->pregReplaceCallback($regexp, $subject, $callback);
        return new ReplacedString($subject, $replaced, ...$replacements);
    }

    /**
     * @param callable $replacer
     * @param string $match
     * @return string
     * @throws CallableException
     */
    private function getReplacement(callable $replacer, string $match): string
    {
        try {
            $replacement = $replacer($match);
        } catch (\Throwable $throwable) {
            throw new CallableException($replacer, [$match], "Caught error when invoking regexp replacer callable", 0, $throwable);
        }
        if (!is_string($replacement)) {
            throw new CallableException($replacer, [$match], "Regexp replacer callable did not return a string");
        }
        return $replacement;
    }

    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param callable $callback
     * @return string
     * @throws CallableException
     * @throws PregException
     */
    private function pregReplaceCallback(Regexp $regexp, string $subject, callable $callback): string
    {
        try {
            $replaced = preg_replace_callback($regexp->getExpression(), $callback, $subject);
        } catch (CallableException $exception) {
            throw $exception;
        } catch (\Throwable $throwable) {
            throw new PregException($regexp, $subject, null, "Failed to execute preg_replace_callback", $throwable);
        }
        return $replaced;
    }
}