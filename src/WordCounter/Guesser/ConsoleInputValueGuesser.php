<?php

namespace WordCounter\Guesser;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\UndefinedInputValueException;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.48.
 */
class ConsoleInputValueGuesser implements ConsoleInputGuesserInterface
{
    /**
     * @param string $consoleInput
     *
     * @return string
     *
     * @throws UndefinedInputValueException
     */
    public function guess($consoleInput)
    {
        $filePath = __DIR__ . '/../../../' . $consoleInput;

        if ($this->isFile($filePath)) {
            return $filePath;
        } elseif ($this->isWikipediaRawApiUrl($consoleInput)) {
            return $consoleInput;
        } elseif ('stdin' === $consoleInput) {
            return ConsoleRequest::STDIN;
        }

        throw new UndefinedInputValueException(sprintf('invalid console value %s', $consoleInput));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isFile($value)
    {
        return is_file($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isWikipediaRawApiUrl($value)
    {
        $parts = parse_url($value);
        if (!isset($parts['query'])) {
            return false;
        }
        parse_str($parts['query'], $query);

        return 'raw' === $query['action'] &&
        'en.wikipedia.org' === $parts['host'];
    }
}
