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

class ConsoleRequest
{
    const STDIN = 'php://stdin';
    const ATTRIBUTE_SEPARATOR = '=';

    /**
     * @var array
     */
    private $consoleInputs;

    /**
     * @param array $argumentsValues
     */
    public function __construct(array $argumentsValues)
    {
        $this->consoleInputs = $this->getConsoleAttributeValues($argumentsValues);
    }

    /**
     * @param $key
     *
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    public function getAttributeValue($key)
    {
        if (!isset($this->consoleInputs[$key])) {
            throw new UndefinedAttributeException(sprintf('%s', $key));
        }

        return $this->consoleInputs[$key];
    }

    /**
     * @return array
     */
    public function getAttributeValues()
    {
        return $this->consoleInputs;
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return count($this->consoleInputs) > 0;
    }

    /**
     * @return bool
     */
    public function isStdin()
    {
        return !count($this->consoleInputs) > 0;
    }

    /**
     * @return bool
     */
    public function isTestEnv()
    {
        return in_array('--test', $this->consoleInputs);
    }

    /**
     * @param array $argumentValues
     *
     * @return array
     *
     * @throws InvalidAttributeException
     */
    private function getConsoleAttributeValues(array $argumentValues)
    {
        $consoleInputs = [];

        if (count($argumentValues) <= 1) {
            return $consoleInputs;
        }

        foreach (array_splice($argumentValues, 1) as $argumentValue) {
            if (strpos($argumentValue, self::ATTRIBUTE_SEPARATOR)) {
                list($argument, $value) = explode(self::ATTRIBUTE_SEPARATOR, $argumentValue, 2);
                $consoleInputs[$argument] = $value;
            } else {
                $consoleInputs['optional'] = $argumentValue;
            }
        }

        return $consoleInputs;
    }
}
