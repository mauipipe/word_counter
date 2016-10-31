<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 12.01.
 */

namespace WordCounter\Counter;

interface CounterInterface
{
    /**
     * @param string $source
     *
     * @return array
     */
    public function getCounts($source, \Closure $func);
}
