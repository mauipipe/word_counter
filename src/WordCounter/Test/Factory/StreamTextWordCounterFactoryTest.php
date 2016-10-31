<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.53.
 */

namespace WordCounter\Test\Factory;

use WordCounter\Counter\StreamTextWordCounter;
use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Factory\StreamTextWordCounterFactory;

class StreamTextWordCounterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createsTextFileHandler()
    {
        $expectedResult = new StreamTextWordCounter(new SplFileObjectFactory());

        $result = StreamTextWordCounterFactory::create();
        $this->assertEquals($expectedResult, $result);
    }
}
