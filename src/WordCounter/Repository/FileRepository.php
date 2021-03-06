<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 10.58.
 */

namespace WordCounter\Repository;

use WordCounter\App\App;
use WordCounter\Factory\DictionaryFactory;
use WordCounter\Model\Config;
use WordCounter\Model\Dictionary;

class FileRepository
{
    const RANDOM_FILE_PATH = 'random_file_path';

    /**
     * @var Config
     */
    private $config;
    /**
     * @var Dictionary
     */
    private $dictionary;

    /**
     * @param ConfigRepository $configManager
     * @param DictionaryFactory $dictionaryFactory
     */
    public function __construct(ConfigRepository $configManager, DictionaryFactory $dictionaryFactory)
    {
        $this->config = $configManager;
        $this->dictionary = $dictionaryFactory->create();
    }

    /**
     * @param string $fileSize
     *
     * @return string
     */
    public function createRandomFile($fileSize)
    {
        $randomFileName = $this->getRandomFilePath();

        if (is_file($randomFileName)) {
            unlink($randomFileName);
        }

        $randomFile = new \SplFileObject($randomFileName, 'a+');
        $bytesAdded = 0;
        $dictionarySize = $this->dictionary->getSize();

        while ($bytesAdded < $fileSize) {
            $randDomIndex = rand(0, $dictionarySize);
            $randomWord = $this->dictionary->getValue($randDomIndex);
            $randomFile->fwrite($randomWord . ' ');

            $bytesAdded += strlen($randomWord);

            $randomFile->next();
        }
    }

    /**
     * @return string
     */
    public function getRandomFilePath()
    {
        return App::getRootDir() . $this->config->getValue(self::RANDOM_FILE_PATH);
    }
}
