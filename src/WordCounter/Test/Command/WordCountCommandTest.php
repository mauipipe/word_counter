<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.09.
 */

namespace WordCounter\Test\Command;

use WordCounter\Command\CommandInterface;
use WordCounter\Command\WordCountCommand;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Service\WordCountService;
use WordCounter\Test\Helper\FixtureProvider;

class WordCountCommandTest extends \PHPUnit_Framework_TestCase
{
    use FixtureProvider;

    const TEST_PARAMETER_VALUE = 'test_parameter_value';
    /**
     * @var ConsoleInputGuesserInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $consoleInputGuesser;
    /**
     * @var WordCountService|\PHPUnit_Framework_MockObject_MockObject
     */
    private $wordCountService;
    /**
     * @var CommandInterface
     */
    private $wordCountCommand;

    public function setUp()
    {
        $this->consoleInputGuesser = $this->getMockBuilder('WordCounter\Guesser\ConsoleInputGuesserInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->wordCountService = $this->getMockBuilder('WordCounter\Service\WordCountService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->wordCountCommand = new WordCountCommand($this->wordCountService, $this->consoleInputGuesser);
    }

    /**
     * @test
     */
    public function executesCommand()
    {
        $expectedResult = $this->getHydratedMockWordCounts([
            'foo' => 2,
        ]);

        $stubArgv = [
            '',
            WordCountCommand::SOURCE . ConsoleRequest::ATTRIBUTE_SEPARATOR . 'test',
        ];

        $consoleRequest = new ConsoleRequest($stubArgv);

        $this->consoleInputGuesser->expects($this->once())
            ->method('guess')
            ->with($consoleRequest)
            ->willReturn(self::TEST_PARAMETER_VALUE);

        $this->wordCountService->expects($this->once())
            ->method('orderByNameAndWord')
            ->with(self::TEST_PARAMETER_VALUE)
            ->willReturn($expectedResult);

        $this->wordCountCommand->execute($consoleRequest);
    }
}
