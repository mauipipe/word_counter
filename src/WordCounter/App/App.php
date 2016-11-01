<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 20.55
 */

namespace WordCounter\App;


use Pimple\Container;
use WordCounter\Command\WordCountCommand;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Counter\StreamTextWordCounter;
use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Guesser\ConsoleInputValueGuesser;
use WordCounter\Service\WordCountService;

class App
{

    /**
     * @return string
     */
    public static function getRootDir()
    {
        return __DIR__ . '/../../../';
    }

    /**
     * @return string
     */
    public static function getSrcDir()
    {
        return __DIR__ . '/../';
    }

    /**
     * @return string
     */
    public static function getTestDir()
    {
        return __DIR__ . '/../Test/';
    }


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
            'word_count.service'       => function ($c) {
                return new WordCountService($c['stream_text_word.counter']);
            },
            'word_count.command'       => function ($c) {
                return new WordCountCommand($c['word_count.service'], $c['console_value.guesser']);
            },
        ];

        return new Container($config);
    }
}