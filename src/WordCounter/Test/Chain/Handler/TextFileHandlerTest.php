<?php
namespace WordCounter\Test\Chain\Handler;

use WordCounter\Chain\Handler\TextFileHandler;
use WordCounter\Factory\SplFileObjectFactoryInterface;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 18.27
 */
class TextFileHandlerTest extends \PHPUnit_Framework_TestCase
{
    const TEST_SOURCE = 'test path';
    /**
     * @var SplFileObjectFactoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $splFileObjectFactory;
    /**
     * @var TextFileHandler
     */
    private $textFileHandler;

    public function setUp()
    {
        $this->splFileObjectFactory = $this->getMockBuilder('WordCounter\Factory\SplFileObjectFactoryInterface')
            ->getMock();

        $this->textFileHandler = new TextFileHandler($this->splFileObjectFactory);
    }

    /**
     * @testFile
     */
    public function getWordCount()
    {
        $testChuck = 'zen test, foo bar foo pon ten zen';
        $fileObjectMock = $this->getMock('SplFileObject', [], ['php://memory']);
        $this->splFileObjectFactory->expects($this->once())
            ->method('create')
            ->with(self::TEST_SOURCE)
            ->willReturn($fileObjectMock);

        $fileObjectMock->expects($this->at(0))
            ->method('eof')->willReturn(false);

        $fileObjectMock->expects($this->at(3))
            ->method('eof')->willReturn(true);

        $fileObjectMock->expects($this->once())
            ->method('current')->willReturn($testChuck);

        $fileObjectMock->expects($this->once())
            ->method('next');

        $expectedResult = [
            'foo' => 2,
            'zen' => 2,
            'bar' => 1,
            'pon' => 1,
            'ten' => 1,
            'test' => 1,
        ];

        $result = $this->textFileHandler->getWordCounts(self::TEST_SOURCE);

        $this->assertEquals($expectedResult, $result);
    }
}
