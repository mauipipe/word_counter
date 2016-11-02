<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 17.41
 */

namespace WordCounter\Validator;


use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\MissingMandatoryAttributeException;
use WordCounter\Manager\ConfigManager;

class ConsoleArgumentValidator implements ConsoleValidatorInterface
{
    const MANDATORY_CONSOLE_ARGS = 'mandatory_console_args';
    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @param ConfigManager $configManager
     */
    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    public function validate(ConsoleRequest $consoleRequest)
    {
        $mandatoryArguments = $this->configManager->getValue(self::MANDATORY_CONSOLE_ARGS);
        $arguments = $consoleRequest->getParameterValues();

        if ($consoleRequest->isStdin()) {
            return;
        }

        foreach ($mandatoryArguments as $mandatoryArgument) {
            if (isset($arguments[$mandatoryArgument])) {
                return;
            }
        }

        throw new MissingMandatoryAttributeException(implode(',', $mandatoryArguments));
    }
}