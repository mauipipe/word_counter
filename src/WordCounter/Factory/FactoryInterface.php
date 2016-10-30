<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.44.
 */

namespace WordCounter\Factory;

use WordCounter\Chain\Handler\WordCounterInterface;

interface FactoryInterface
{
    /**
     * @return WordCounterInterface;
     */
    public static function create();
}
