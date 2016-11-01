<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 15.52.
 */
require __DIR__ . '/../vendor/autoload.php';

use WordCounter\Command\CommandInterface;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Container\DependencyHandler;

const SOURCE = 'source';

$rustart = getrusage();

$container = DependencyHandler::getContainer();
/** @var CommandInterface $wordCountCommand */
$wordCountCommand = $container->offsetGet('word_count.command');
$wordCountCommand->execute(new ConsoleRequest($argv));