<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.28.
 */

namespace WordCounter\Console;

use WordCounter\Exception\InvalidAttributeException;
use WordCounter\Exception\UndefinedAttributeException;
use WordCounter\Guesser\ConsoleInputGuesserInterface;

class ConsoleRequest
{
    const STDIN = 'php://stdin';
    const ATTRIBUTE_SEPARATOR = "=";

    /**
     * @var ConsoleInputGuesserInterface
     */
    private $argumentsValues;

    /**
     * @param array $argumentsValues
     */
    public function __construct(array $argumentsValues)
    {
        $this->argumentsValues = $this->getConsoleInputs($argumentsValues);
    }

    /**
     * @param $key
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    public function getParameterValue($key)
    {
        if (!isset($this->argumentsValues[$key])) {
            throw new UndefinedAttributeException('%s', $key);
        }
        return $this->argumentsValues[$key];
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return !empty($this->argumentsValues);
    }

    /**
     * @param array $argumentValues
     * @return mixed
     *
     * @throws InvalidAttributeException
     */
    private function getConsoleInputs(array $argumentValues)
    {
        $consoleInputs = [];
        foreach ($argumentValues as $argumentValue) {
            if (false === strpos($argumentValue, self::ATTRIBUTE_SEPARATOR)) {
                throw new InvalidAttributeException($argumentValue);
            }

            list($argument, $value) = explode(self::ATTRIBUTE_SEPARATOR, $argumentValue, 2);
            $consoleInputs[$argument] = $value;
        }

        return $consoleInputs;
    }
}
