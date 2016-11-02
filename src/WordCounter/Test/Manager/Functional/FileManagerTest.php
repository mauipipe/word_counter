<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 11.57.
 */

namespace WordCounter\Test\Manager\Functional;

use WordCounter\App\App;
use WordCounter\Factory\DictionaryFactory;
use WordCounter\Manager\ConfigManager;
use WordCounter\Manager\FileManager;
use WordCounter\Model\Dictionary;
use WordCounter\Test\Enum\ConfigTest;

class FileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configManager;
    /**
     * @var DictionaryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dictionaryFactory;
    /**
     * @var string
     */
    private $randomTestFilePath;
    /**
     * @var FileManager
     */
    private $fileManager;

    public function setUp()
    {
        $this->configManager = $this->getMockBuilder('WordCounter\Manager\ConfigManager')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dictionaryFactory = $this->getMockBuilder('WordCounter\Factory\DictionaryFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomTestFilePath = App::getRootDir() . ConfigTest::RANDOM_FILE_PATH;

        $dictionary = new Dictionary('foo,bar');
        $this->dictionaryFactory->expects($this->once())
            ->method('create')
            ->willReturn($dictionary);

        $this->fileManager = new FileManager($this->configManager, $this->dictionaryFactory);
    }

    /**
     * @test
     */
    public function createsInternalRandomFile()
    {
        $fileSize = 1e2;

        $this->configManager->expects($this->once())
            ->method('getValue')
            ->with(FileManager::RANDOM_FILE_PATH)
            ->willReturn(ConfigTest::RANDOM_FILE_PATH);

        $this->fileManager->createRandomFile($fileSize);

        $this->assertFileExists($this->randomTestFilePath);
        $this->assertTrue(filesize($this->randomTestFilePath) > 1e2);
    }

    public function tearDown()
    {
        if (is_file($this->randomTestFilePath)) {
            unlink($this->randomTestFilePath);
        }
    }
}
