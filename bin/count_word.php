<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 15.52.
 */
require __DIR__ . '/../vendor/autoload.php';

use WordCounter\App\App;
use WordCounter\Command\CommandInterface;
use WordCounter\Console\ConsoleRequest;

$rustart = getrusage();

$consoleRequest = new ConsoleRequest($argv);
$handle = fopen(ConsoleRequest::STDIN, 'r');

$configFile = 'config/config.json';
if ($consoleRequest->isTestEnv()) {
    $configFile = 'config/config_test.json';
}
$container = App::init(App::getRootDir() . $configFile);
/** @var CommandInterface $wordCountCommand */
$wordCountCommand = $container->offsetGet('word_count.command');
$wordCountCommand->execute(new ConsoleRequest($argv));