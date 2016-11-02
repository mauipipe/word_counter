<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 17.42
 */

namespace WordCounter\Validator;


use WordCounter\Console\ConsoleRequest;

interface ConsoleValidatorInterface
{
    public function validate(ConsoleRequest $consoleRequest);
}