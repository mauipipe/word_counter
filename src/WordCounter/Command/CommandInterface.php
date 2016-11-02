<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.08.
 */

namespace WordCounter\Command;

use WordCounter\Console\ConsoleRequest;

interface CommandInterface
{
    /**
     * @param ConsoleRequest $consoleRequest
     *
     * @return string
     */
    public function createRandomFile(ConsoleRequest $consoleRequest);
}
