<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.28.
 */

namespace WordCounter\Console;

use WordCounter\Exception\UndefinedAttributeException;

class ConsoleRequest
{
    const ATTRIBUTE_SEPARATOR = '=';
    /**
     * @var array
     */
    private $consoleArguments;

    /**
     * @param array $consoleArguments
     *
     * @internal param array $argv
     */
    public function __construct(array $consoleArguments)
    {
        $this->consoleArguments = $consoleArguments;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws UndefinedAttributeException
     */
    public function getParameterValue($key)
    {
        $consoleInput = $this->consoleArguments[1];
        if (false === strpos($consoleInput, $key)) {
            throw new UndefinedAttributeException(sprintf('cannot find attribute %s', $key));
        }

        list($parameter, $source) = explode(self::ATTRIBUTE_SEPARATOR, $consoleInput);

        return $source;
    }
}
