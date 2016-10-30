<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 12.01
 */

namespace WordCounter\Chain\Handler;


interface WordCounterInterface
{
    /**
     * @param string $source
     * @return array
     */
    public function getWordCounts($source);

}