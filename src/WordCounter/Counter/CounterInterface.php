<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 12.01.
 */

namespace WordCounter\Counter;

use WordCounter\Model\WordCount;

interface CounterInterface
{
    /**
     * @param string $source
     *
     * @return WordCount[]
     */
    public function getCounts($source, \Closure $func);
}
