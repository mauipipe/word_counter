<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 15.32.
 */

namespace WordCounter\Factory;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Guesser\ConsoleInputValueGuesser;

class ConsoleRequestFactory implements FactoryInterface
{
    /**
     * @return ConsoleRequest
     */
    public static function create()
    {
        return new ConsoleRequest(new ConsoleInputValueGuesser());
    }
}
