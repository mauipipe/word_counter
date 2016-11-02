<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.38.
 */

namespace WordCounter\Test\Console;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Test\Enum\ConfigTest;

class ConsoleRequestTest extends \PHPUnit_Framework_TestCase
{
    const ATTRIBUTE_WIKIPEDIA_RAW_API = 'https://en.wikipedia.org/w/index.php?title=test&action=raw';
    const TEST_ATTRIBUTE = '--bar';

    /**
     * @test
     *
     * @dataProvider provider
     */
    public function getsConsoleValueFromParameter($mockArgv, $expectedResult)
    {
        $consoleRequest = new ConsoleRequest($mockArgv);
        $result = $consoleRequest->getParameterValue(self::TEST_ATTRIBUTE);

        $this->assertEquals($expectedResult, $result);
    }

    public function provider()
    {
        $consoleInputPrefix = self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR;

        return [
            [
                ['', $consoleInputPrefix . ConfigTest::ATTRIBUTE_FILE],
                ConfigTest::ATTRIBUTE_FILE,
            ],
            [
                ['', $consoleInputPrefix . self::ATTRIBUTE_WIKIPEDIA_RAW_API],
                self::ATTRIBUTE_WIKIPEDIA_RAW_API,
            ],
        ];
    }

    /**
     * @test
     */
    public function checksIfConsoleArgumentsHasArguments()
    {
        $consoleRequest = new ConsoleRequest([]);

        $this->assertFalse($consoleRequest->hasArguments());
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedAttributeException
     */
    public function getsConsoleValueFromParameterThrowExceptionWhenAnInvalidAttributeNameIsConsumed()
    {
        $mockArgv = [
            1 => self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR . self::ATTRIBUTE_WIKIPEDIA_RAW_API,
        ];
        $invalidConsumedAttribute = 'invalid';

        $consoleRequest = new ConsoleRequest($mockArgv);
        $consoleRequest->getParameterValue($invalidConsumedAttribute);
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\InvalidAttributeException
     */
    public function getsConsoleValueFromParameterExceptionWhenAndAttributeWithNoValueNameIsConsumed()
    {
        $mockArgv = [
            '', 1 => self::TEST_ATTRIBUTE,
        ];
        $invalidConsumedAttribute = 'invalid';

        $consoleRequest = new ConsoleRequest($mockArgv);
        $consoleRequest->getParameterValue($invalidConsumedAttribute);
    }
}
