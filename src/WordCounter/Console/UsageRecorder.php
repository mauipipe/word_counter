<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 16.06.
 */

namespace WordCounter\Console;

class UsageRecorder
{
    private $ruUsage;

    public function initRuUsage()
    {
        $this->ruUsage = getrusage();
    }

    public function getRuUsage()
    {
        return $this->ruUsage;
    }

    public function getCurrentUsage()
    {
        return getrusage();
    }

    public function getMemoryPeak($real = false)
    {
        return memory_get_peak_usage($real);
    }
}
