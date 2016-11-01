<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 23.53
 */

namespace WordCounter\Model;


class Dictionary implements InternalResourceSerializerInterface
{
    private $dictionaryData;

    /**
     * @param array $dictionaryData
     */
    public function __construct($dictionaryData)
    {
        $this->dictionaryData = $dictionaryData;
    }

    /**
     * @return array;
     */
    public function serialize()
    {
        return $this->dictionaryData;
    }
}