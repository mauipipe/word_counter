<?php
namespace WordCounter\Container;

use Pimple\Container;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Counter\StreamTextWordCounter;
use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Guesser\ConsoleInputValueGuesser;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 31/10/16
 * Time: 18.12
 */
class DependencyHandler
{
    public static function getContainer()
    {
        $config = [
            'console_value.guesser'    => function () {
                return new ConsoleInputValueGuesser();
            },
            'console.request.factory'  => function ($c) {
                return new ConsoleRequest($c['console_value.guesser']);
            },
            'spl_file_object.factory'  => function () {
                return new SplFileObjectFactory();
            },
            'stream_text_word.counter' => function ($c) {
                return new StreamTextWordCounter($c['spl_file_object.factory']);
            },
        ];

        return new Container($config);
    }
}