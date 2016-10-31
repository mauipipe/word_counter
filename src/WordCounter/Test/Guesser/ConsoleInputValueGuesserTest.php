<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.54.
 */

namespace WordCounter\Test\Guesser;

use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Guesser\ConsoleInputValueGuesser;
use WordCounter\Test\Console\ConsoleRequestTest;

class ConsoleInputValueGuesserTest extends \PHPUnit_Framework_TestCase
{
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
     * @param string $consoleInputValue
     * @param string $expectedResult
     */
    public function guessValueForProvidedType($consoleInputValue, $expectedResult)
    {
        $result = $this->consoleInputValueGuesser->guess($consoleInputValue);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function consoleInputProvider()
    {
        return [
            [
                ConsoleRequestTest::ATTRIBUTE_FILE,
                '/srv/apps/word_counter/src/WordCounter/Guesser/../../../src/WordCounter/Test/fixtures/test.txt',
            ],
            [
                ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API,
                ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API,
            ],
        ];
    }
}
