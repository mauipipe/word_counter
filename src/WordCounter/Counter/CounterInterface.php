<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 12.01.
 */

namespace WordCounter\Counter;

use WordCounter\Model\WordOccurrences;

interface CounterInterface
{
    /**
     * @param string $source
     *
     * @return WordOccurrences[]
     */
    public function getCounts($source, \Closure $func);
}
