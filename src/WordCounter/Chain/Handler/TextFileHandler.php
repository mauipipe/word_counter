<?php
namespace WordCounter\Chain\Handler;

use WordCounter\Factory\SplFileObjectFactoryInterface;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 17.57
 */
class TextFileHandler implements WordCounterInterface
{
    /**
     * @var SplFileObjectFactoryInterface
     */
    private $fileObjectFactory;

    /**
     * @param SplFileObjectFactoryInterface $fileObjectFactory
     */
    public function __construct(SplFileObjectFactoryInterface $fileObjectFactory)
    {
        $this->fileObjectFactory = $fileObjectFactory;
    }

    /**
     * @inheritdoc
     */
    public function getWordCounts($source)
    {
        $fileObject = $this->fileObjectFactory->create($source);
        $counts = [];

        while (!$fileObject->eof()) {
            $buffer = $fileObject->current();
            $partialResult = $this->getSanitiziedWords($buffer);
            $this->add($partialResult, $counts);
            unset($partialResult);

            $fileObject->next();
        }

        return $counts;

    }

    private function add($a, &$result)
    {
        foreach ($a as $value) {
            $subValue = strtolower($value);
            if (!isset($result[$subValue])) {
                $result[$subValue] = 1;
            } else {
                $result[$subValue]++;
            }
        }

        return $result;
    }

    private function getSanitiziedWords($source)
    {
        $source = preg_replace('/\s+|\r|\n|[^a-zA-Z 0-9]+/', ' ', $source);
        return array_filter(explode(' ', $source), 'trim');
    }
}