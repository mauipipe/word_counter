<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.28.
 */

namespace WordCounter\Console;

use WordCounter\Exception\UndefinedAttributeException;
use WordCounter\Exception\UndefinedInputValueException;

class ConsoleRequest
{
    const ATTRIBUTE_SEPARATOR = '=';
    const STDIN = 'php://stdin';

    /**
     * @var array
     */
    private $consoleArguments;

    /**
     * @param array $consoleArguments
     */
    public function __construct(array $consoleArguments)
    {
        $this->consoleArguments = $consoleArguments;
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws UndefinedInputValueException
     */
    public function getParameterValue($key)
    {
        if (!isset($this->consoleArguments[1]) && $this->hasPipedValue()) {
            return self::STDIN;
        }
        $consoleInput = $this->getConsoleInput($key);

        return $this->getConsoleValue($consoleInput);
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

    private function hasPipedValue()
    {
        $handle = fopen(self::STDIN, 'r');
        fclose($handle);

        return $handle;
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
     * @param $key
     *
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    public function getConsoleInput($key)
    {
        $consoleInput = $this->consoleArguments[1];
        if (false === strpos($consoleInput, $key)) {
            throw new UndefinedAttributeException(sprintf('cannot find attribute %s', $key));
        }

        $consoleInput = str_replace($key . self::ATTRIBUTE_SEPARATOR, '', $consoleInput);
        $consoleInput = str_replace('--', '', $consoleInput);

        return $consoleInput;
    }

    /**
     * @param string $consoleInput
     *
     * @return string
     *
     * @throws UndefinedInputValueException
     */
    private function getConsoleValue($consoleInput)
    {
        $filePath = __DIR__ . '/../../../' . $consoleInput;

        if ($this->isFile($filePath)) {
            return $filePath;
        } elseif ($this->isWikipediaRawApiUrl($consoleInput)) {
            return $consoleInput;
        }

        throw new UndefinedInputValueException(sprintf('invalid console value %s', $consoleInput));
    }
}
