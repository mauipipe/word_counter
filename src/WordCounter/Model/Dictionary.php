<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 23.53.
 */

namespace WordCounter\Model;

class Dictionary extends AbstractInternalFile
{
    const DICTIONARY_SEPARATOR = ',';

    /**
     * @param string $dictionary
     */
    public function __construct($dictionary)
    {
        parent::__construct(explode(self::DICTIONARY_SEPARATOR, $dictionary));
    }

    public function getSize()
    {
        return count($this->internalFileData) - 1;
    }
}
