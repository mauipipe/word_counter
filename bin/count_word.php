<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 15.52.
 */
const SOURCE = 'source';
require __DIR__ . '/../vendor/autoload.php';

use WordCounter\Console\ConsoleRequest;
use WordCounter\Factory\TextFileHandlerFactory;

$rustart = getrusage();

$consoleInput = new ConsoleRequest($argv);
$wordCounter = TextFileHandlerFactory::create();

$source = $consoleInput->getParameterValue(SOURCE);
echo sprintf("running %s\n", $source);

$result = $wordCounter->getWordCounts($source);
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
