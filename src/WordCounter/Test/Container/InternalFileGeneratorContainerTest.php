<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 0.38
 */

namespace WordCounter\Test\Container;


use WordCounter\Container\InternalFileGeneratorContainer;
use WordCounter\Model\Config;
use WordCounter\Model\Dictionary;
use WordCounter\Model\InternalResourceSerializerInterface;

class InternalFileGeneratorContainerTest extends \PHPUnit_Framework_TestCase
{
    const CONFIG_KEY = "foo";
    const VALUE = "bar";
    const ENV = 'test';

    /**
     * @var InternalFileGeneratorContainer
     */
    private $fileManager;

    public function setUp()
    {
        $this->fileManager = new InternalFileGeneratorContainer(self::ENV);
    }

    /**
     * @test
     *
     * @dataProvider fileTypeProvider
     *
     * @param string $fileType
     * @param InternalResourceSerializerInterface $expectedResult
     */
    public function convertsConsumedFileTypeInArray($fileType, InternalResourceSerializerInterface $expectedResult)
    {
        $result = $this->fileManager->getFileType($fileType);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function fileTypeProvider()
    {
        return [
            [InternalFileGeneratorContainer::DICTIONARY, new Dictionary('foo,bar')],
            [InternalFileGeneratorContainer::CONFIG, new Config(['foo' => 'bar'])],
        ];
    }

    /**
     * @test
     *
     * @expectedException \OutOfBoundsException
     */
    public function throwsExceptionWhenWrongInternalFileTypeConsumed()
    {
        $this->fileManager->getFileType('invalid');
    }
}
