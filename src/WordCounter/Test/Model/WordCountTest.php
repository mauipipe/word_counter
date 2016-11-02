<?php

namespace WordCounter\Test\Model;

use WordCounter\Model\WordOccurrences;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 21.18.
 */
class WordCountTest extends \PHPUnit_Framework_TestCase
{
    const TEST_WORD = 'test';
    /**
     * @var WordOccurrences
     */
    private $wordCount;

    public function setUp()
    {
        $this->wordCount = new WordOccurrences(self::TEST_WORD);
    }

    /**
     * @test
     */
    public function incrementWordFrequencyCount()
    {
        $expectedResult = 2;
        $this->wordCount->incrementCount();

        $result = $this->wordCount->getCount();

        $this->assertEquals($expectedResult, $result);
    }
}
