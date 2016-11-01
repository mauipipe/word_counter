<?php

namespace WordCounter\Exception;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 17.34.
 */
class UndefinedAttributeException extends \Exception
{
    const MESSAGE_PREFIX = 'undefined attribute %s';

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct(sprintf(self::MESSAGE_PREFIX, $message));
    }
}
