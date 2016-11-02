<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 13.12.
 */

namespace WordCounter\Test\Factory;

use WordCounter\Factory\DictionaryFactory;
use WordCounter\Manager\ConfigManager;
use WordCounter\Model\Dictionary;

class DictionaryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configManager;
    /**
     * @var DictionaryFactory
     */
    private $dictionaryFactory;

    public function setUp()
    {
        $this->configManager = $this->getMockBuilder('WordCounter\Manager\ConfigManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->getMockBuilder('WordCounter\Manager\ConfigManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dictionaryFactory = new DictionaryFactory($this->configManager);
    }

    /**
     * @test
     */
    public function createsNewDictionaryFormConfigFile()
    {
        $dictionaryPath = 'src/WordCounter/Test/fixtures/dictionary_test.txt';

        $this->configManager->expects($this->once())
            ->method('getValue')
            ->with(DictionaryFactory::DICTIONARY_PATH)
            ->willReturn($dictionaryPath);

        $expectedResult = new Dictionary('foo,bar');
        $result = $this->dictionaryFactory->create();

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @test
     *
     * @expectedException \Symfony\Component\Filesystem\Exception\FileNotFoundException
     */
    public function throwsExceptionWhenInvalidDictionaryFilePassed()
    {
        $this->configManager->expects($this->once())
            ->method('getValue')
            ->with(DictionaryFactory::DICTIONARY_PATH)
            ->willReturn('');

        $this->dictionaryFactory->create();
    }
}
