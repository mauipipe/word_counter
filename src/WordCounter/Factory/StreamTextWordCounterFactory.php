<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.42.
 */

namespace WordCounter\Factory;

use WordCounter\Counter\CounterInterface;
use WordCounter\Counter\StreamTextWordCounter;

class StreamTextWordCounterFactory implements FactoryInterface
{
    /**
     * @return CounterInterface;
     */
    public static function create()
    {
        return new StreamTextWordCounter(new SplFileObjectFactory());
    }
}
