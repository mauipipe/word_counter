<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 22.12.
 */

namespace WordCounter\Test\Service;

use WordCounter\Counter\CounterInterface;
use WordCounter\Service\WordCountService;
use WordCounter\Test\Helper\FixtureProvider;

class WordCountServiceTest extends \PHPUnit_Framework_TestCase
{
    use FixtureProvider;

    const TEST_CONSOLE_VALUE = 'test_console_value';
    /**
     * @var CounterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $streamWordTextCounter;
    /**
     * @var WordCountService
     */
    private $wordCountService;

    public function setUp()
    {
        $this->streamWordTextCounter = $this->getMockBuilder('WordCounter\Counter\CounterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->wordCountService = new WordCountService($this->streamWordTextCounter);
    }

    /**
     * @test
     */
    public function ordersByNameAndWord()
    {
        $expectedResult = $this->getHydratedMockWordCounts([
            'foo'      => 4,
            'firmware' => 3,
            'frappè'   => 3,
            'bar'      => 2,
            'zap'      => 2,
        ]);

        $countResult = $this->getHydratedMockWordCounts([
            'firmware' => 3,
            'foo'      => 4,
            'zap'      => 2,
            'bar'      => 2,
            'frappè'   => 3,
        ]);

        $this->streamWordTextCounter->expects($this->once())
            ->method('getCounts')
            ->with(self::TEST_CONSOLE_VALUE)
            ->willReturn($countResult);

        $result = $this->wordCountService->orderByNameAndWord(self::TEST_CONSOLE_VALUE);

        $this->assertEquals($expectedResult, $result);
    }
}
