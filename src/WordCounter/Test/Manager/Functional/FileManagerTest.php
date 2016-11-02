<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 11.57
 */

namespace WordCounter\Test\Manager\Functional;


use WordCounter\App\App;
use WordCounter\Container\InternalFileGeneratorContainer;
use WordCounter\Manager\FileManager;
use WordCounter\Model\Config;
use WordCounter\Model\Dictionary;
use WordCounter\Test\Enum\ConfigTest;

class FileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InternalFileGeneratorContainer|\PHPUnit_Framework_MockObject_MockObject
     */
    private $internalFileGeneratorContainer;
    /**
     * @var
     */
    private $randomTestFilePath;
    /**
     * @var FileManager;
     */
    private $generateFileWithRandomContentCommand;

    public function setUp()
    {
        $this->internalFileGeneratorContainer = $this->getMockBuilder(
            'WordCounter\Container\InternalFileGeneratorContainer'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->internalFileGeneratorContainer->expects($this->at(0))
            ->method('getFileType')
            ->with('config')
            ->willReturn(new Config([FileManager::RANDOM_FILE_PATH => ConfigTest::RANDOM_FILE_PATH]));

        $this->internalFileGeneratorContainer->expects($this->at(1))
            ->method('getFileType')
            ->with('dictionary')
            ->willReturn(new Dictionary('foo,bar'));

        $this->randomTestFilePath = App::getRootDir() . ConfigTest::RANDOM_FILE_PATH;

        $this->generateFileWithRandomContentCommand = new FileManager($this->internalFileGeneratorContainer);
    }

    /**
     * @test
     */
    public function createsInternalRandomFile()
    {
        $fileSize = 1e2;
        $this->generateFileWithRandomContentCommand->createRandomFile($fileSize);

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
