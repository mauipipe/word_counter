<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 10.35.
 */

namespace WordCounter\Counter;

use WordCounter\Factory\SplFileObjectFactoryInterface;
use WordCounter\Model\WordCount;

class StreamTextWordCounter implements CounterInterface
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
     * {@inheritdoc}
     */
    public function getCounts($source, \Closure $func)
    {
        $fileObject = $this->fileObjectFactory->create($source);
        $counts = [];

        $counter = 0;
        while (!$fileObject->eof()) {
            $buffer = $fileObject->current();
            $partialResult = $this->getSanitizedPartialResult($buffer);
            $this->sumCounts($partialResult, $counts);
            unset($partialResult);
            $func(++$counter);
            $fileObject->next();
        }

        return $counts;
    }

    /**
     * @param array $a
     * @param array $result
     */
    private function sumCounts($a, &$result)
    {
        foreach ($a as $value) {
            $subValue = strtolower($value);
            $hash = crc32($subValue);

            if (!isset($result[$hash])) {
                $result[$hash] = new WordCount($subValue);
            } else {
                $result[$hash]->incrementCount();
            }
        }
    }

    /**
     * @param string $source
     *
     * @return array
     */
    private function getSanitizedPartialResult($source)
    {
        $source = preg_replace('/\s+|\r|\n|[^a-zA-Z 0-9]+/', ' ', $source);

        return array_filter(explode(' ', $source), 'trim');
    }
}
