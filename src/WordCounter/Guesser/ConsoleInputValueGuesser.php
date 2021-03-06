<?php

namespace WordCounter\Guesser;

use WordCounter\App\App;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Enum\ConsoleAttributes;
use WordCounter\Exception\UndefinedInputValueException;
use WordCounter\Repository\FileRepository;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.48.
 */
class ConsoleInputValueGuesser implements ConsoleInputGuesserInterface
{
    const STDIN = 'php://stdin';

    /**
     * @var
     */
    private $fileManager;

    /**
     * @param FileRepository $fileManager
     */
    public function __construct(FileRepository $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * {@inheritdoc}
     */
    public function guess(ConsoleRequest $consoleRequest)
    {
        if ($consoleRequest->isStdin()) {
            return self::STDIN;
        }

        $values = $consoleRequest->getAttributeValues();

        foreach ($values as $attribute => $value) {
            switch ($attribute) {
                case ConsoleAttributes::RANDOM:
                    $fileSize = $this->convertValueToByte($value);
                    $this->fileManager->createRandomFile($fileSize);

                    return $this->fileManager->getRandomFilePath();
                    break;
                case ConsoleAttributes::SOURCE:
                    $filePath = App::getRootDir() . $value;

                    if ($this->isFile($filePath)) {
                        return $filePath;
                    } elseif ($this->isWikipediaRawApiUrl($value)) {
                        return $value;
                    }
                    break;
            }
        }

        throw new UndefinedInputValueException(sprintf('invalid console value %s', implode(',', $consoleRequest->getAttributeValues())));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isFile($value)
    {
        return is_file($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isWikipediaRawApiUrl($value)
    {
        $parts = parse_url($value);
        if (!isset($parts['query'])) {
            return false;
        }
        parse_str($parts['query'], $query);

        return 'raw' === $query['action'] &&
        'en.wikipedia.org' === $parts['host'];
    }

    /**
     * @param $fileSize
     *
     * @return string
     */
    private function convertValueToByte($fileSize)
    {
        $fileSizeMapper = [
            'KB' => 1e3,
            'M'  => 1e6,
            'GB' => 1e9,
        ];

        $fileSizeSuffix = preg_replace('/[^A-Z]/', '', $fileSize);

        if (isset($fileSizeMapper[$fileSizeSuffix])) {
            $fileSize = preg_replace('/[^0-9]/', '', $fileSize) * $fileSizeMapper[$fileSizeSuffix];
        }

        return $fileSize;
    }
}
