<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.38.
 */

namespace WordCounter\Test\Console;

use WordCounter\Console\ConsoleRequest;

class ConsoleRequestTest extends \PHPUnit_Framework_TestCase
{
    const ATTRIBUTE_VALUE = 'foo';

    /**
     * @test
     */
    public function getsValueFromConsoleParameter()
    {
        $expectedResult = self::ATTRIBUTE_VALUE;
        $attribute = 'bar';
        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR . $expectedResult,
        ];

        $consoleRequest = new ConsoleRequest($mockArgv);
        $result = $consoleRequest->getParameterValue($attribute);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     *
     * @expectedException  \WordCounter\Exception\UndefinedAttributeException
     */
    public function getsValueFromConsoleParameterThrowUndefinedAttributeExceptionWhenAnInvalidAttributeNameIsConsumed()
    {
        $attribute = 'invalid';
        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR,
        ];

        $consoleRequest = new ConsoleRequest($mockArgv);
        $consoleRequest->getParameterValue(self::ATTRIBUTE_VALUE);
    }
}
