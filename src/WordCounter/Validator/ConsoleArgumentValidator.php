<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 17.41.
 */

namespace WordCounter\Validator;

use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\MissingMandatoryAttributeException;
use WordCounter\Repository\ConfigRepository;

class ConsoleArgumentValidator implements ConsoleValidatorInterface
{
    const MANDATORY_CONSOLE_ARGS = 'mandatory_console_args';
    /**
     * @var ConfigRepository
     */
    private $configManager;

    /**
     * @param ConfigRepository $configManager
     */
    public function __construct(ConfigRepository $configManager)
    {
        $this->configManager = $configManager;
    }

    public function validate(ConsoleRequest $consoleRequest)
    {
        $mandatoryArguments = $this->configManager->getValue(self::MANDATORY_CONSOLE_ARGS);
        $arguments = $consoleRequest->getAttributeValues();

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
