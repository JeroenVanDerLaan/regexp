<?php

namespace Jeroenvanderlaan\Regexp;

use Jeroenvanderlaan\Regexp\Exception\PregException;
use Jeroenvanderlaan\Regexp\Value\Regexp\EscapedRegexp;
use Jeroenvanderlaan\Regexp\Value\Regexp\Exception\RegexpSyntaxException;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;
use Jeroenvanderlaan\Regexp\Value\Replacement;

class Unreplacer
{
    /**
     * @param string $subject
     * @param Replacement ...$replacements
     * @return string
     * @throws PregException
     * @throws RegexpSyntaxException
     */
    public function unreplace(string $subject, Replacement ...$replacements): string
    {
        if (empty($replacements)) {
            return $subject;
        }
        $callbacks = [];
        foreach ($replacements as $replacement) {
            $regexp = new EscapedRegexp($replacement->getReplacement());
            $callback = function () use ($replacement, $regexp, $subject) {
                return $replacement->getMatch();
            };
            $callbacks[$regexp->getExpression()] = $callback;
        }
        return $this->pregReplaceCallbackArray($regexp, $subject, $callbacks);
    }

    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param array $callbacks
     * @return string
     * @throws PregException
     */
    private function pregReplaceCallbackArray(Regexp $regexp, string $subject, array $callbacks): string
    {
        try {
            $replaced = preg_replace_callback_array($callbacks, $subject);
        } catch (\Throwable $throwable) {
            throw new PregException($regexp, $subject, null, "Failed to execute preg_replace_callback_array", $throwable);
        }
        if (!is_string($replaced)) {
            throw new PregException($regexp, $subject, null, "preg_replace_callback_array did not return a string");
        }
        return $replaced;
    }

}