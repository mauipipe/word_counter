<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 21.05.
 */

namespace WordCounter\Exception;

class UndefinedConfigValueException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct(sprintf('undefined config value %s', $message));
    }
}
