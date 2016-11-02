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
use WordCounter\Model\Dictionary;
use WordCounter\Repository\ConfigRepository;
use WordCounter\Repository\FileRepository;
use WordCounter\Test\Enum\ConfigTest;

class FileManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configRepository;
    /**
     * @var DictionaryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dictionaryFactory;
    /**
     * @var string
     */
    private $randomTestFilePath;
    /**
     * @var FileRepository
     */
    private $fileManager;

    public function setUp()
    {
        $this->configRepository = $this->getMockBuilder('WordCounter\Repository\ConfigRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dictionaryFactory = $this->getMockBuilder('WordCounter\Factory\DictionaryFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $this->randomTestFilePath = App::getRootDir() . ConfigTest::RANDOM_FILE_PATH;
        file_put_contents($this->randomTestFilePath, '');

        $dictionary = new Dictionary('foo,bar');
        $this->dictionaryFactory->expects($this->once())
            ->method('create')
            ->willReturn($dictionary);

        $this->fileManager = new FileRepository($this->configRepository, $this->dictionaryFactory);
    }

    /**
     * @test
     */
    public function createsInternalRandomFile()
    {
        $fileSize = 1e2;

        $this->configRepository->expects($this->once())
            ->method('getValue')
            ->with(FileRepository::RANDOM_FILE_PATH)
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
