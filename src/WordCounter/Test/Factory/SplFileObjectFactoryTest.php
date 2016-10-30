<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.46.
 */

namespace WordCounter\Test\Factory;

use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Factory\SplFileObjectFactoryInterface;

class SplFileObjectFactoryTest extends \PHPUnit_Framework_TestCase
{
    const TEST_PATH = __DIR__ . '/../Fixtures/test.txt';

    /**
     * @var SplFileObjectFactoryInterface
     */
    private $splFileObjectFactory;

    public function setUp()
    {
        $this->splFileObjectFactory = new SplFileObjectFactory();
    }

    /**
     * @test
     */
    public function createsAnSpFileObjectConsumingSourceString()
    {
        $expectedResult = new \SplFileObject(self::TEST_PATH);

        $result = $this->splFileObjectFactory->create(self::TEST_PATH);
        $this->assertEquals($expectedResult, $result);
    }
}
