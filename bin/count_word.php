<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 15.52.
 */
require __DIR__ . '/../vendor/autoload.php';

use WordCounter\Container\DependencyHandler;
use WordCounter\Factory\StreamTextWordCounterFactory;

const SOURCE = 'source';

$rustart = getrusage();
$container = DependencyHandler::getContainer();
/** @var \WordCounter\Guesser\ConsoleInputGuesserInterface $guesser */

$consoleRequest = $container->offsetGet('console.request.factory');
$wordCounter = $container->offsetGet('stream_text_word.counter');

$source = $consoleRequest->getParameterValue(SOURCE, $argv);
echo sprintf("running %s\n", $source);

$result = $wordCounter->getCounts($source, function ($counter) {
    if ($counter % 8192 === 0) {
        echo ".";
    }
});

foreach ($result as $key => $value) {
    echo sprintf("%s=%d\n", $key, $value);
}

// Script end
function rutime($ru, $rus, $index)
{
    return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
    - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
}

$ru = getrusage();
$d = new DateTime();
$seconds = rutime($ru, $rustart, 'utime') / 1000;
echo "\nThis process used " . $seconds .
    "sec for its computations\n";
echo 'It spent ' . rutime($ru, $rustart, 'stime') .
    " ms in system calls\n";

echo sprintf("real Usage %s\n", memory_get_peak_usage(true));
echo sprintf("peak usage %s\n", memory_get_peak_usage());
