<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 15.39.
 */

namespace WordCounter\Console;

class ConsoleRenderer implements ConsoleRendererInterface
{
    /**
     * @var bool
     */
    private $isUsageEnabled = false;
    /**
     * @var UsageRecorder
     */
    private $usageRecorder;

    /**
     * @param UsageRecorder $usageRecorder
     */
    public function __construct(UsageRecorder $usageRecorder)
    {
        $this->usageRecorder = $usageRecorder;
    }

    public function initUsageRecorder()
    {
        $this->usageRecorder->initRuUsage();
        $this->isUsageEnabled = true;
    }

    /**
     * {@inheritdoc}
     */
    public function printSingleLine($message)
    {
        echo $message;
    }

    /**
     * {@inheritdoc}
     */
    public function printResponseData(array $responseData)
    {
        $result = [];
        foreach ($responseData as $wordCount) {
            $result[] = sprintf("%s=%d\n", $wordCount->getWord(), $wordCount->getCount());
        }

        return implode('', $result);
    }

    /**
     * {@inheritdoc}
     */
    public function printUsage()
    {
        $result = [];
        if (!$this->isUsageEnabled) {
            return 'Usage not enabled';
        }

        $rustart = $this->usageRecorder->getRuUsage();
        $ru = $this->usageRecorder->getCurrentUsage();
        $seconds = $this->displayRutime($ru, $rustart, 'utime') / 1000;
        $ruTime = $this->displayRutime($ru, $rustart, 'stime');

        $result[] = "\nThis process used " . $seconds .
            'sec for its computations';
        $result[] = 'It spent ' . $ruTime .
            ' ms in system calls';

        $result[] = sprintf("real Usage %s\n", $this->usageRecorder->getMemoryPeak(true));
        $result[] = sprintf("peak usage %s\n", $this->usageRecorder->getMemoryPeak());

        return implode("\n", $result);
    }

    /**
     * @param $ru
     * @param $rus
     * @param $index
     *
     * @return mixed
     */
    private function displayRutime($ru, $rus, $index)
    {
        return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
        - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
    }
}
