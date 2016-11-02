<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 17.49
 */

namespace WordCounter\Exception;


class MissingMandatoryAttributeException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}