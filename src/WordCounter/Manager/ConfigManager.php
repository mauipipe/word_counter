<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 20.43
 */

namespace WordCounter\Manager;


use WordCounter\App\App;
use WordCounter\Exception\UndefinedConfigValueException;

class ConfigManager
{
    /**
     * @var array
     */
    private $configData;

    public function __construct($configFilePath)
    {
        $fileContent = file_get_contents(App::getSrcDir() . $configFilePath);
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