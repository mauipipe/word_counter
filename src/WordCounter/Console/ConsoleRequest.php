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
    const ATTRIBUTE_SEPARATOR = '=';

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
     *
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    public function getParameterValue($key)
    {
        if (!isset($this->argumentsValues[$key])) {
            throw new UndefinedAttributeException(sprintf('%s', $key));
        }

        return $this->argumentsValues[$key];
    }

    /**
     * @return array
     */
    public function getParameterValues()
    {
        return $this->argumentsValues;
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return count($this->argumentsValues) > 0;
    }

    /**
     * @return bool
     */
    public function isStdin()
    {
        return !count($this->argumentsValues) > 0;

    }

    /**
     * @param array $argumentValues
     *
     * @return array
     *
     * @throws InvalidAttributeException
     */
    private function getConsoleInputs(array $argumentValues)
    {
        $consoleInputs = [];

        if (count($argumentValues) <= 1) {
            return $consoleInputs;
        }

        foreach (array_splice($argumentValues, 1) as $argumentValue) {
            if (false === strpos($argumentValue, self::ATTRIBUTE_SEPARATOR)) {
                throw new InvalidAttributeException($argumentValue);
            }

            list($argument, $value) = explode(self::ATTRIBUTE_SEPARATOR, $argumentValue, 2);
            $consoleInputs[$argument] = $value;
        }

        return $consoleInputs;
    }
}
