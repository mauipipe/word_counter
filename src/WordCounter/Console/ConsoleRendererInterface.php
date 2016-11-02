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

    /**
     * @param array $rustart
     *
     * @return mixed
     */
    public function printUsage(array $rustart);
}
