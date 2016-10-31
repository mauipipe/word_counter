<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.28.
 */

namespace WordCounter\Console;

use WordCounter\Exception\UndefinedAttributeException;
use WordCounter\Guesser\ConsoleInputGuesserInterface;

class ConsoleRequest
{
    const ATTRIBUTE_SEPARATOR = '=';
    const STDIN = 'php://stdin';

    /**
     * @var array
     */
    private $consoleArguments;
    /**
     * @var \ConsoleInputGuesserInterface
     */
    private $consoleInputGuesser;

    /**
     * @param ConsoleInputGuesserInterface $consoleInputGuesser
     */
    public function __construct(ConsoleInputGuesserInterface $consoleInputGuesser)
    {
        $this->consoleInputGuesser = $consoleInputGuesser;
    }

    /**
     * @param string $key
     * @param array $argv
     *
     * @return string
     */
    public function getParameterValue($key, array $argv)
    {
        if (!isset($argv[1]) && $this->hasPipedValue()) {
            return self::STDIN;
        }
        $consoleInput = $this->getConsoleInput($key, $argv[1]);

        return $this->consoleInputGuesser->guess($consoleInput);
    }

    private function hasPipedValue()
    {
        $handle = fopen(self::STDIN, 'r');
        fclose($handle);

        return $handle;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    private function getConsoleInput($key, $value)
    {
        if (false === strpos($value, $key)) {
            throw new UndefinedAttributeException(sprintf('cannot find attribute %s', $key));
        }

        $consoleInput = str_replace($key . self::ATTRIBUTE_SEPARATOR, '', $value);
        $consoleInput = str_replace('--', '', $consoleInput);

        return $consoleInput;
    }
}
