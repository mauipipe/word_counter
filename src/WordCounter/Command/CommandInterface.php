<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.08
 */

namespace WordCounter\Command;


interface CommandInterface
{
    /**
     * @param array $argv
     *
     * @return string
     */
    public function execute(array $argv);
}