<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.54.
 */

namespace WordCounter\Test\Guesser;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Enum\ConsoleAttributes;
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Guesser\ConsoleInputValueGuesser;
use WordCounter\Repository\FileRepository;
use WordCounter\Test\Console\ConsoleRequestTest;
use WordCounter\Test\Enum\ConfigTest;

class ConsoleInputValueGuesserTest extends \PHPUnit_Framework_TestCase
{
    const TEST_ATTRIBUTE = '--foo';

    /**
     * @var FileRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $fileRepository;
    /**
     * @var ConsoleInputGuesserInterface
     */
    private $consoleInputValueGuesser;

    public function setUp()
    {
        $this->fileRepository = $this->getMockBuilder('WordCounter\Repository\FileRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->consoleInputValueGuesser = new ConsoleInputValueGuesser($this->fileRepository);
    }

    /**
     * @test
     *
     * @dataProvider consoleInputProvider
     *
     * @param string $consoleInputValues
     * @param string $expectedResult
     */
    public function guessValueForAttributeSource($consoleInputValues, $expectedResult)
    {
        $consoleRequest = new ConsoleRequest($consoleInputValues);
        $result = $this->consoleInputValueGuesser->guess($consoleRequest);

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
                ['', ConsoleAttributes::SOURCE . ConsoleRequest::ATTRIBUTE_SEPARATOR . 'src/WordCounter/' . ConfigTest::ATTRIBUTE_FILE],
                '/srv/apps/word_counter/src/WordCounter/App/../../../src/WordCounter/Test/fixtures/test.txt',
            ],
            //Wikipedia Raw Api
            [
                ['', ConsoleAttributes::SOURCE . ConsoleRequest::ATTRIBUTE_SEPARATOR . ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API],
                ConsoleRequestTest::ATTRIBUTE_WIKIPEDIA_RAW_API,
            ],
            //Stdin
            [
                [''],
                ConsoleInputValueGuesser::STDIN,
            ],
        ];
    }

    /**
     * @test
     */
    public function guessValueForAttributeRandom()
    {
        $consoleArgv = [
            '',
            ConsoleAttributes::RANDOM . ConsoleRequest::ATTRIBUTE_SEPARATOR . '=12M',
        ];
        $consoleRequest = new ConsoleRequest($consoleArgv);

        $expectedResult = 'random.txt';

        $this->fileRepository->expects($this->once())
            ->method('createRandomFile')
            ->with(12e6);

        $this->fileRepository->expects($this->once())
            ->method('getRandomFilePath')
            ->willReturn($expectedResult);

        $result = $this->consoleInputValueGuesser->guess($consoleRequest);

        $this->assertEquals($expectedResult, $result);
    }
}
