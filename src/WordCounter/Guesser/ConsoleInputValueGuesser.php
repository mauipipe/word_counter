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
    const STDIN = 'php://stdin';

    /**
     * {@inheritdoc}
     */
    public function guess(ConsoleRequest $consoleRequest, $attribute)
    {
        if ($this->isStdin($consoleRequest)) {
            return self::STDIN;
        }

        $value = $consoleRequest->getParameterValue($attribute);
        $filePath = __DIR__ . '/../../../' . $value;

        if ($this->isFile($filePath)) {
            return $filePath;
        } elseif ($this->isWikipediaRawApiUrl($value)) {
            return $value;
        }

        throw new UndefinedInputValueException(sprintf('invalid console value %s', implode(',', $consoleRequest->getParameterValues())));
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

    /**
     * @param ConsoleRequest $consoleRequest
     *
     * @return bool
     */
    private function isStdin(ConsoleRequest $consoleRequest)
    {
        return !$consoleRequest->hasArguments();
    }
}
