<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 16.43.
 */

namespace WordCounter\Factory;

class SplFileObjectFactory implements SplFileObjectFactoryInterface
{
    /**
     * @param string $filePath
     *
     * @return \SplFileObject
     */
    public function create($filePath)
    {
        return new \SplFileObject($filePath);
    }
}
