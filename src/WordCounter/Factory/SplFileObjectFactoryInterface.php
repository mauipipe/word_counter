<?php

namespace WordCounter\Factory;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 30/10/16
 * Time: 10.48.
 */
interface SplFileObjectFactoryInterface
{
    /**
     * @param string $filePath
     *
     * @return \SplFileObject
     */
    public function create($filePath);
}
