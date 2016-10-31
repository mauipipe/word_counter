<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.38.
 */

namespace WordCounter\Test\Console;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\UndefinedInputValueException;
use WordCounter\Guesser\ConsoleInputGuesserInterface;

class ConsoleRequestTest extends \PHPUnit_Framework_TestCase
{
    const ATTRIBUTE_FILE = 'src/WordCounter/Test/fixtures/test.txt';
    const ATTRIBUTE_WIKIPEDIA_RAW_API = 'https://en.wikipedia.org/w/index.php?title=test&action=raw';
    const TEST_ATTRIBUTE = '--bar';

    /**
     * @test
     * @dataProvider provider
     */
    public function getsConsoleValueFromParameterAndAssertIsFile($mockArgv, $expectedResult)
    {
        $consoleInputValueGuesser = $this->getConsoleInputValueGuesser();
        $consoleInputValueGuesser->expects($this->once())
            ->method('guess')
            ->willReturn($expectedResult);

        $consoleRequest = new ConsoleRequest($consoleInputValueGuesser);
        $result = $consoleRequest->getParameterValue(self::TEST_ATTRIBUTE, $mockArgv);

        $this->assertEquals($expectedResult, $result);
    }

    public function provider()
    {
        $consoleInputPrefix = self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR;

        return [
            [
                [1 => $consoleInputPrefix . self::ATTRIBUTE_FILE],
                '/srv/apps/word_counter/src/WordCounter/Console/../../../' . self::ATTRIBUTE_FILE,
            ],
            [
                [1 => $consoleInputPrefix . self::ATTRIBUTE_WIKIPEDIA_RAW_API],
                self::ATTRIBUTE_WIKIPEDIA_RAW_API,
            ],
        ];
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedAttributeException
     */
    public function getsConsoleValueFromParameterThrowUndefinedAttributeExceptionWhenAnInvalidAttributeNameIsConsumed()
    {
        $consoleInputValueGuesser = $this->getConsoleInputValueGuesser();
        $mockArgv = [
            1 => self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR . self::ATTRIBUTE_WIKIPEDIA_RAW_API,
        ];
        $invalidConsumedAttribute = 'invalid';

        $consoleRequest = new ConsoleRequest($consoleInputValueGuesser);
        $consoleRequest->getParameterValue($invalidConsumedAttribute, $mockArgv);
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedInputValueException
     */
    public function getsConsoleValueFromParameterThrowUndefinedInputValueExceptionWhenAnInvalidValueIsConsumed()
    {
        $invalidValue = 'invalid';
        $mockArgv = [
            1 => self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR . $invalidValue,
        ];

        $consoleInputValueGuesser = $this->getConsoleInputValueGuesser();
        $consoleInputValueGuesser->expects($this->once())
            ->method('guess')
            ->willThrowException(new UndefinedInputValueException('error'));

        $consoleRequest = new ConsoleRequest($consoleInputValueGuesser);
        $consoleRequest->getParameterValue(self::TEST_ATTRIBUTE, $mockArgv);
    }

    /**
     * @return ConsoleInputGuesserInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getConsoleInputValueGuesser()
    {
        return $this->getMockBuilder('WordCounter\Guesser\ConsoleInputGuesserInterface')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
