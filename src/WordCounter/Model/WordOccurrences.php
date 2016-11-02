<?php

namespace WordCounter\Model;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 21.14.
 */
class WordOccurrences implements IncrementerInterface
{
    const INITIAL_COUNT = 1;
    /**
     * @var string;
     */
    private $word;
    /**
     * @var int
     */
    private $count;

    /**
     * @param string $word
     */
    public function __construct($word)
    {
        $this->word = $word;
        $this->count = self::INITIAL_COUNT;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    public function incrementCount()
    {
        ++$this->count;
    }
}
