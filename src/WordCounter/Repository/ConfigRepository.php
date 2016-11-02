<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 20.43.
 */

namespace WordCounter\Repository;

use WordCounter\Exception\UndefinedConfigValueException;

class ConfigRepository
{
    /**
     * @var array
     */
    private $configData;

    /**
     * @param string $configFilePath
     */
    public function __construct($configFilePath)
    {
        $fileContent = file_get_contents($configFilePath);
        $this->configData = json_decode($fileContent, true);
    }

    /**
     * @param string $key
     *
     * @return string
     *
     * @throws UndefinedConfigValueException
     */
    public function getValue($key)
    {
        if (!isset($this->configData[$key])) {
            throw new UndefinedConfigValueException($key);
        }

        return $this->configData[$key];
    }
}
