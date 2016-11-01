<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 0.36
 */

namespace WordCounter\Container;

use WordCounter\App\App;
use WordCounter\Enum\Environment;
use WordCounter\Enum\FIleExtension;
use WordCounter\Model\Config;
use WordCounter\Model\Dictionary;
use WordCounter\Model\InternalResourceSerializerInterface;

class InternalFileGeneratorContainer
{
    const RESOURCE_FOLDER = 'resources/';
    const TEST_FILE_FOLDER = 'fixtures/';
    const FULL_PATH = '%s%s%s.%s';
    const CONFIG = 'config';
    const DICTIONARY = 'dictionary';

    private static $fileTypeReaderMapper = [
        self::CONFIG     => FIleExtension::JSON,
        self::DICTIONARY => FIleExtension::TXT,
    ];
    /**
     * @var string
     */
    private $env;

    /**
     * @param string $env
     */
    public function __construct($env)
    {
        $this->env = $env;
    }

    /**
     * @param $fileType
     *
     * @return InternalResourceSerializerInterface
     */
    public function getFileType($fileType)
    {
        if (!isset(self::$fileTypeReaderMapper[$fileType])) {
            throw new \OutOfBoundsException(sprintf("invalid file type consumed %s", $fileType));
        }

        switch (self::$fileTypeReaderMapper[$fileType]) {
            case FIleExtension::TXT:
                $fullFilePath = $this->getFullFilePath($this->getRootFolderByEnv(App::getRootDir()), $fileType);
                $dictionary = file_get_contents($fullFilePath);
                $result = new Dictionary(explode(",", $dictionary));
                break;
            case FIleExtension::JSON:
                $fullFilePath = $this->getFullFilePath($this->getRootFolderByEnv(App::getSrcDir()), $fileType);
                $fileContent = file_get_contents($fullFilePath);
                $result = new Config(json_decode($fileContent, true));
                break;
            default:
                throw new \OutOfBoundsException(sprintf("invalid file extension added %s", $fileType));
                break;
        }

        return $result;
    }

    /**
     * @param string $prodDir
     *
     * @return string
     */
    private function getRootFolderByEnv($prodDir)
    {
        if (Environment::TEST === $this->env) {
            return App::getTestDir();
        }

        return $prodDir;
    }

    /**
     * @param string $srcDir
     * @param string $fileType
     * @return string
     */
    private function getFullFilePath($srcDir, $fileType)
    {
        $resourceFolder = self::RESOURCE_FOLDER;

        if (Environment::TEST === $this->env) {
            $resourceFolder = self::TEST_FILE_FOLDER;
        }
        $fullFilePath = sprintf(
            self::FULL_PATH,
            $srcDir,
            $resourceFolder,
            $fileType,
            self::$fileTypeReaderMapper[$fileType]
        );
        return $fullFilePath;
    }

}