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
     * {@inheritdoc}
     */
    public function printResponseData(array $responseData)
    {
        foreach ($responseData as $wordCount) {
            echo sprintf("%s=%d\n", $wordCount->getWord(), $wordCount->getCount());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function printUsage(array $rustart)
    {
        function rutime($ru, $rus, $index)
        {
            return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
            - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
        }

        $ru = getrusage();
        $seconds = rutime($ru, $rustart, 'utime') / 1000;
        echo "\nThis process used " . $seconds .
            "sec for its computations\n";
        echo 'It spent ' . rutime($ru, $rustart, 'stime') .
            " ms in system calls\n";

        echo sprintf("real Usage %s\n", memory_get_peak_usage(true));
        echo sprintf("peak usage %s\n", memory_get_peak_usage());
    }
}
