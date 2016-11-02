<?php

namespace WordCounter\Test\Helper;

use WordCounter\Model\WordOccurrences;

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
     * @return WordOccurrences
     */
    protected function getWordCountIncrementedBy($word, $count)
    {
        $wordCount = new WordOccurrences($word);
        for ($i = 0; $i < $count - 1; ++$i) {
            $wordCount->incrementCount();
        }

        return $wordCount;
    }
}
