<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.53.
 */

namespace WordCounter\Test\Factory;

use WordCounter\Chain\Handler\TextFileHandler;
use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Factory\TextFileHandlerFactory;

class TextFileHandlerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function createsTextFileHandler()
    {
        $expectedResult = new TextFileHandler(new SplFileObjectFactory());

        $result = TextFileHandlerFactory::create();
        $this->assertEquals($expectedResult, $result);
    }
}
