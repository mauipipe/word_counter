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
    const ATTRIBUTE_FILE = 'src/WordCounter/Test/fixtures/test.txt';
    const ATTRIBUTE_WIKIPEDIA_RAW_API = 'https://en.wikipedia.org/w/index.php?title=test&action=raw';

    /**
     * @test
     */
    public function getsConsoleValueFromParameterAndAssertIsFile()
    {
        $expectedResult = '/srv/apps/word_counter/src/WordCounter/Console/../../../' . self::ATTRIBUTE_FILE;
        $attribute = '--bar';
        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR . self::ATTRIBUTE_FILE,
        ];

        $consoleRequest = new ConsoleRequest($mockArgv);
        $result = $consoleRequest->getParameterValue($attribute);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedAttributeException
     */
    public function getsConsoleValueFromParameterThrowUndefinedAttributeExceptionWhenAnInvalidAttributeNameIsConsumed()
    {
        $attribute = 'bar';
        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR . self::ATTRIBUTE_WIKIPEDIA_RAW_API,
        ];
        $invalidConsumedAttribute = 'invalid';

        $consoleRequest = new ConsoleRequest($mockArgv);
        $this->assertEquals(self::ATTRIBUTE_WIKIPEDIA_RAW_API, $consoleRequest->getParameterValue($invalidConsumedAttribute));
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedInputValueException
     */
    public function getsConsoleValueFromParameterThrowUndefinedInputValueExceptionWhenAnInvalidValueIsConsumed()
    {
        $attribute = 'bar';
        $invalidValue = 'invalid';

        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR . $invalidValue,
        ];

        $consoleRequest = new ConsoleRequest($mockArgv);
        $this->assertEquals(self::ATTRIBUTE_WIKIPEDIA_RAW_API, $consoleRequest->getParameterValue($attribute));
    }

    /**
     * @test
     */
    public function getsConsoleValueFromParameterAndAssertIsWikipediaRawAPIUrl()
    {
        $attribute = 'bar';
        $mockArgv = [
            1 => $attribute . ConsoleRequest::ATTRIBUTE_SEPARATOR . self::ATTRIBUTE_WIKIPEDIA_RAW_API,
        ];

        $consoleRequest = new ConsoleRequest($mockArgv);
        $this->assertEquals(self::ATTRIBUTE_WIKIPEDIA_RAW_API, $consoleRequest->getParameterValue($attribute));
    }
}
