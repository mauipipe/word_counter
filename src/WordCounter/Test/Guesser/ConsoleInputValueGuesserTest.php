<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.54.
 */

namespace WordCounter\Test\Guesser;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Guesser\ConsoleInputValueGuesser;
use WordCounter\Test\Console\ConsoleRequestTest;

class ConsoleInputValueGuesserTest extends \PHPUnit_Framework_TestCase
{
    const TEST_ATTRIBUTE = '--foo';
    /**
     * @var ConsoleInputGuesserInterface
     */
    private $consoleInputValueGuesser;

    public function setUp()
    {
        $this->consoleInputValueGuesser = new ConsoleInputValueGuesser();
    }

    /**
     * @test
     *
     * @dataProvider consoleInputProvider
     *
     * @param string $consoleInputValues
     * @param string $expectedResult
     */
    public function guessValueForProvidedType($consoleInputValues, $expectedResult)
    {
        $consoleRequest = new ConsoleRequest($consoleInputValues);
        $result = $this->consoleInputValueGuesser->guess($consoleRequest, self::TEST_ATTRIBUTE);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function consoleInputProvider()
    {
        return [
            //file input
            [
                ['', self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR . ConsoleRequestTest::ATTRIBUTE_FILE],
                '/srv/apps/word_counter/src/WordCounter/Guesser/../../../src/WordCounter/Test/fixtures/test.txt',
            ],
            //Wikipedia Raw Api
            [
                ['', self::TEST_ATTRIBUTE . ConsoleRequest::ATTRIBUTE_SEPARATOR . ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API],
                ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API,
            ],
            //Wikipedia Raw Api
            [
                [''],
                ConsoleInputValueGuesser::STDIN,
            ],
        ];
    }
}
