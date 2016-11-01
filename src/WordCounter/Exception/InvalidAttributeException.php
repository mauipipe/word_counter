<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 13.11
 */

namespace WordCounter\Exception;


class InvalidAttributeException extends \Exception
{
    /**
     * InvalidAttributeException constructor.
     * @param mixed $argumentsValue
     */
    public function __construct($argumentsValue)
    {
        parent::__construct(sprintf('invalid attribute passed %s', $argumentsValue));
    }
}