<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 20.55.
 */

namespace WordCounter\App;

use Pimple\Container;
use WordCounter\Command\WordCountCommand;
use WordCounter\Console\ConsoleRenderer;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Console\UsageRecorder;
use WordCounter\Counter\TextStreamOccurrencesCounter;
use WordCounter\Factory\DictionaryFactory;
use WordCounter\Factory\SplFileObjectFactory;
use WordCounter\Guesser\ConsoleInputValueGuesser;
use WordCounter\Repository\ConfigRepository;
use WordCounter\Repository\FileRepository;
use WordCounter\Service\WordCountService;
use WordCounter\Validator\ConsoleArgumentValidator;

class App
{
    /**
     * @param string $configFilePath
     *
     * @return Container
     */
    public static function init($configFilePath)
    {
        $config = new ConfigRepository($configFilePath);

        return self::getContainer($config);
    }

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

    /**
     * @param ConfigRepository $config
     *
     * @return Container
     */
    private static function getContainer(ConfigRepository $config)
    {
        $dependencies = [
            'console_value.guesser'      => function($c) {
                return new ConsoleInputValueGuesser($c['file.manager']);
            },
            'console.request.factory'    => function($c) {
                return new ConsoleRequest($c['console_value.guesser']);
            },
            'spl_file_object.factory'    => function() {
                return new SplFileObjectFactory();
            },
            'stream_text_word.counter'   => function($c) {
                return new TextStreamOccurrencesCounter($c['spl_file_object.factory']);
            },
            'word_count.service'         => function($c) {
                return new WordCountService($c['stream_text_word.counter']);
            },
            'word_count.command'         => function($c) {
                return new WordCountCommand(
                    $c['word_count.service'],
                    $c['console_value.guesser'],
                    $c['console.renderer'],
                    $c['console_argument.validator']
                );
            },
            'file.manager'               => function($c) {
                return new FileRepository($c['configRepository.manager'], $c['dictionary.factory']);
            },
            'configRepository.manager'   => function($c) use ($config) {
                return $config;
            },
            'console.renderer'           => function($c) {
                return new ConsoleRenderer($c['usage_recorder.console']);
            },
            'usage_recorder.console'     => function($c) {
                return new UsageRecorder();
            },
            'dictionary.factory'         => function($c) {
                return new DictionaryFactory($c['configRepository.manager']);
            },
            'console_argument.validator' => function($c) {
                return new ConsoleArgumentValidator($c['configRepository.manager']);
            },
        ];

        return new Container($dependencies);
    }
}
