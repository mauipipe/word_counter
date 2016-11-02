<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 13.06.
 */

namespace WordCounter\Factory;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use WordCounter\App\App;
use WordCounter\Manager\ConfigManager;
use WordCounter\Model\Dictionary;

class DictionaryFactory
{
    const DICTIONARY_PATH = 'dictionary_path';
    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @param ConfigManager $config
     */
    public function __construct(ConfigManager $config)
    {
        $this->configManager = $config;
    }

    public function create()
    {
        $dictionaryFile = App::getRootDir() . $this->configManager->getValue(self::DICTIONARY_PATH);
        if (!is_file($dictionaryFile)) {
            throw new FileNotFoundException(sprintf('dictionary file not found %s', $dictionaryFile));
        }

        $content = @file_get_contents($dictionaryFile);

        return new Dictionary($content);
    }
}
