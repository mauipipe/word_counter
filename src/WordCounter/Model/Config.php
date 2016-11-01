<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 23.53
 */

namespace WordCounter\Model;


class Config implements InternalResourceSerializerInterface
{
    /**
     * @var array
     */
    private $configData;

    /**
     * @param array $configData
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    /**
     * @return array;
     */
    public function serialize()
    {
        return $this->configData;
    }
}