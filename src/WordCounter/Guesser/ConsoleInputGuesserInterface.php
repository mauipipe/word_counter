<?php

namespace WordCounter\Guesser;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 14.48.
 */
interface ConsoleInputGuesserInterface
{
    /**
     * @param $consoleInput
     *
     * @return mixed
     */
    public function guess($consoleInput);
}
