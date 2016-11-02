<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 16.37.
 */

namespace WordCounter\Test\Console;

use WordCounter\Console\ConsoleRenderer;
use WordCounter\Console\UsageRecorder;
use WordCounter\Test\Helper\FixtureProvider;

class ConsoleRendererTest extends \PHPUnit_Framework_TestCase
{
    use FixtureProvider;

    const TIME_ELAPSED = 2;
    const RU_D_TV_SEC = 'ru_utime.tv_sec';
    const RU_D_TV_USEC = 'ru_stime.tv_sec';

    /**
     * @var UsageRecorder|\PHPUnit_Framework_MockObject_MockObject
     */
    private $usageRecorder;
    /**
     * @var ConsoleRenderer
     */
    private $consoleRenderer;

    public function setUp()
    {
        $this->usageRecorder = $this->getMockBuilder('WordCounter\Console\UsageRecorder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->consoleRenderer = new ConsoleRenderer($this->usageRecorder);
    }

    /**
     * @test
     */
    public function printsConsumedConsoleResponseData()
    {
        $countWord = $this->getWordCountIncrementedBy('foo', 1);
        $data = [$countWord];

        $expectedResult = "foo=1\n";
        $result = $this->consoleRenderer->printResponseData($data);

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     */
    public function printsUsage()
    {
        $rustartUsage = [
            'ru_stime.tv_sec'  => 100000,
            'ru_stime.tv_usec' => 1000000,
            'ru_utime.tv_sec'  => 100000,
            'ru_utime.tv_usec' => 1000000,
        ];

        $ruEndUsage = [
            'ru_stime.tv_sec'  => 100000 * self::TIME_ELAPSED,
            'ru_stime.tv_usec' => 1000000 * self::TIME_ELAPSED,
            'ru_utime.tv_sec'  => 100000 * self::TIME_ELAPSED,
            'ru_utime.tv_usec' => 1000000 * self::TIME_ELAPSED,
        ];

        $this->usageRecorder->expects($this->once())
            ->method('getRuUsage')
            ->willReturn($rustartUsage);
        $this->usageRecorder->expects($this->once())
            ->method('getCurrentUsage')
            ->willReturn($ruEndUsage);

        $expectedResult = 'This process used 100001sec for its computations It spent 100001000 ms in system calls real Usage peak usage';

        $this->consoleRenderer->initUsageRecorder();
        $result = $this->consoleRenderer->printUsage();

        $this->assertEquals($expectedResult, preg_replace('/\s+|\n/', ' ', trim($result)));
    }
}
