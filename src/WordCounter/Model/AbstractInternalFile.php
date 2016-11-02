<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 1.01
 */

namespace WordCounter\Model;


use WordCounter\Exception\UndefinedConfigValueException;

abstract class AbstractInternalFile implements InternalResourceSerializerInterface
{
    /**
     * @var array
     */
    protected $internalFileData;

    /**
     * @param array $dictionaryData
     */
    public function __construct(array $dictionaryData)
    {
        $this->internalFileData = $dictionaryData;
    }

    /**
     * @return array;
     */
    public function serialize()
    {
        return $this->internalFileData;
    }

    /**
     * @param $key
     * @return string
     *
     * @throws UndefinedConfigValueException
     */
    public function getValue($key)
    {
        if (!isset($this->internalFileData[$key])) {
            throw new UndefinedConfigValueException($key);
        }

        return $this->internalFileData[$key];
    }
}