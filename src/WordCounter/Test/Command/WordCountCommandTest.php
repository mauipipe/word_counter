<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.09
 */

namespace WordCounter\Test\Command;


use WordCounter\Command\CommandInterface;
use WordCounter\Command\WordCountCommand;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Service\WordCountService;
use WordCounter\Test\Helper\FixtureProvider;

class WordCountCommandTest extends \PHPUnit_Framework_TestCase
{
    use FixtureProvider;

    const TEST_PARAMETER_VALUE = 'test_parameter_value';
    /**
     * @var ConsoleRequest|\PHPUnit_Framework_MockObject_MockObject
     */
    private $consoleRequest;
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
        $this->consoleRequest = $this->getMockBuilder('WordCounter\Console\ConsoleRequest')
            ->disableOriginalConstructor()
            ->getMock();
        $this->wordCountService = $this->getMockBuilder('WordCounter\Service\WordCountService')
            ->disableOriginalConstructor()
            ->getMock();

        $this->wordCountCommand = new WordCountCommand($this->wordCountService, $this->consoleRequest);
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
            1 => WordCountCommand::SOURCE,
        ];

        $this->consoleRequest->expects($this->once())
            ->method('getParameterValue')
            ->willReturn(self::TEST_PARAMETER_VALUE);
        $this->wordCountService->expects($this->once())
            ->method('orderByNameAndWord')
            ->with(self::TEST_PARAMETER_VALUE)
            ->willReturn($expectedResult);

        $this->wordCountCommand->execute($stubArgv);
    }
}
