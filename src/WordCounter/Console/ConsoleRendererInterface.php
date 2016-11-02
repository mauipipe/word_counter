<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 15.46.
 */

namespace WordCounter\Console;

interface ConsoleRendererInterface
{
    /**
     * @param array $responseData
     *
     * @return mixed
     */
    public function printResponseData(array $responseData);

    public function printUsage();

    public function initUsageRecorder();
    /**
     * @param string $message
     */
    public function printSingleLine($message);
}
