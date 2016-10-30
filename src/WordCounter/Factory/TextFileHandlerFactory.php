<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.42.
 */

namespace WordCounter\Factory;

use WordCounter\Chain\Handler\TextFileHandler;
use WordCounter\Chain\Handler\WordCounterInterface;

class TextFileHandlerFactory implements FactoryInterface
{
    /**
     * @return WordCounterInterface;
     */
    public static function create()
    {
        return new TextFileHandler(new SplFileObjectFactory());
    }
}
