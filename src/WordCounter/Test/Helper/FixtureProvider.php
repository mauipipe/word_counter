<?php

namespace WordCounter\Test\Helper;

use WordCounter\Model\WordCount;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 22.42.
 */
trait FixtureProvider
{
    /**
     * @param array $data
     *
     * @return array
     */
    protected function getHydratedMockWordCounts(array $data)
    {
        $result = [];
        foreach ($data as $word => $count) {
            $result[crc32($word)] = $this->getWordCountIncrementedBy($word, $count);
        }

        return $result;
    }

    /**
     * @param string $word
     * @param string $count
     *
     * @return WordCount
     */
    protected function getWordCountIncrementedBy($word, $count)
    {
        $wordCount = new WordCount($word);
        for ($i = 0; $i < $count - 1; ++$i) {
            $wordCount->incrementCount();
        }

        return $wordCount;
    }
}
