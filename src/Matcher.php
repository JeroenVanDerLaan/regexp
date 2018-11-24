<?php

namespace Jeroenvanderlaan\Regexp;

use Jeroenvanderlaan\Regexp\Exception\PregException;
use Jeroenvanderlaan\Regexp\Value\Match;
use Jeroenvanderlaan\Regexp\Value\Regexp\Regexp;

class Matcher
{
    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param int $offset
     * @return Match|null
     * @throws PregException
     */
    public function match(Regexp $regexp, string $subject, int $offset = 0): ?Match
    {
        try {
            $matches = [];
            preg_match($regexp->getExpression(), $subject, $matches, PREG_OFFSET_CAPTURE, $offset);
        } catch (\Throwable $throwable) {
            throw new PregException($subject, $regexp, $offset, "Failed to execute preg_match", $throwable);
        }

        if (empty($matches)) {
            return null;
        }

        $fullMatch = array_shift($matches);
        $groups = [];
        foreach ($matches as $groupMatch) {
            list($needle, $offset) = $groupMatch;
            $groups[] = new Match($subject, $needle, $regexp, $offset);
        }
        list($needle, $offset) = $fullMatch;
        return new Match($subject, $needle, $regexp, $offset, ...$groups);
    }

    /**
     * @param Regexp $regexp
     * @param string $subject
     * @param int $offset
     * @return Match[]
     * @throws PregException
     */
    public function matchAll(Regexp $regexp, string $subject, int $offset = 0): array
    {
        try {
            $all = [];
            preg_match_all($regexp->getExpression(), $subject, $all, PREG_OFFSET_CAPTURE, $offset);
        } catch (\Throwable $throwable) {
            throw new PregException($subject, $regexp, $offset, "Failed to execute preg_match_all", $throwable);
        }

        $fullMatches = array_shift($all);
        $matches = [];
        foreach ($fullMatches as $index => $fullMatch) {
            $groups = [];
            foreach ($all as $groupMatches) {
                $groupMatch = $groupMatches[$index];
                list($needle, $offset) = $groupMatch;
                $groups[] = new Match($subject, $needle, $regexp, $offset);
            }
            list($needle, $offset) = $fullMatch;
            $matches[] = new Match($subject, $needle, $regexp, $offset, ...$groups);
        }

        return $matches;
    }
}