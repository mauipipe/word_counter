<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 0.03
 */

namespace WordCounter\Model;


interface InternalResourceSerializerInterface
{
    /**
     * @return array;
     */
    public function serialize();
}