<?php

namespace WordCounter\Service;

use WordCounter\Counter\CounterInterface;
use WordCounter\Model\WordOccurrences;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 22.10.
 */
class WordCountService
{
    /**
     * @var CounterInterface
     */
    private $streamWordTextCounter;

    /**
     * @param CounterInterface $streamWordTextCounter
     *
     * @internal param CounterInterface $counter
     */
    public function __construct(CounterInterface $streamWordTextCounter)
    {
        $this->streamWordTextCounter = $streamWordTextCounter;
    }

    /**
     * @param string $consoleValue
     *
     * @return WordOccurrences[]
     */
    public function orderByNameAndWord($consoleValue)
    {
        $progress = function ($counter) {
            if ($counter % 8192 === 0) {
                echo '.';
            }
        };

        $wordCounts = $this->streamWordTextCounter->getCounts($consoleValue, $progress);

        $sortByCountAndName = function ($item1, $item2) {
            if ($item1->getCount() < $item2->getCount()) {
                return true;
            } elseif ($item1->getCount() === $item2->getCount()) {
                return $item1->getWord() > $item2->getWord();
            }

            return false;
        };

        uasort($wordCounts, $sortByCountAndName);

        return $wordCounts;
    }
}
