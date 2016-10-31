<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 19.24.
 */

namespace WordCounter\Factory;

use GuzzleHttp\Client;
use WordCounter\Chain\Handler\WikipediaTextHandler;
use WordCounter\Chain\Handler\WordCounterInterface;

class WikipediaTextHandlerFactory implements FactoryInterface
{
    /**
     * @return WordCounterInterface;
     */
    public static function create()
    {
        return new WikipediaTextHandler(new Client());
    }
}
