<?php

namespace WordCounter\Guesser;

use WordCounter\Console\ConsoleRequest;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.48.
 */
interface ConsoleInputGuesserInterface
{
    /**
     * @param ConsoleRequest $consoleRequest
     *
     * @return string
     */
    public function guess(ConsoleRequest $consoleRequest);
}
