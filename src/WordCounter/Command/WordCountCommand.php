<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.08.
 */

namespace WordCounter\Command;

use WordCounter\Console\ConsoleRendererInterface;
use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\MissingMandatoryAttributeException;
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Service\WordCountService;
use WordCounter\Validator\ConsoleValidatorInterface;

class WordCountCommand implements CommandInterface
{
    const SOURCE = '--source';
    const RANDOM = '--random';
    const STDIN = 'stdin';

    /**;
     * @var WordCountService
     */
    private $wordCountService;
    /**
     * @var ConsoleInputGuesserInterface
     */
    private $consoleInputValueGuesser;

    /**
     * @var array
     */
    private static $allowedArguments = [
        self::SOURCE,
        self::RANDOM,
    ];
    /**
     * @var ConsoleRendererInterface
     */
    private $consoleRenderer;
    /**
     * @var ConsoleValidatorInterface
     */
    private $consoleValidator;

    /**
     * @param WordCountService $wordCountService
     * @param ConsoleInputGuesserInterface $consoleInputValueGuesser
     * @param ConsoleRendererInterface $consoleRenderer
     * @param ConsoleValidatorInterface $consoleValidator
     */
    public function __construct(
        WordCountService $wordCountService,
        ConsoleInputGuesserInterface $consoleInputValueGuesser,
        ConsoleRendererInterface $consoleRenderer,
        ConsoleValidatorInterface $consoleValidator
    )
    {
        $this->wordCountService = $wordCountService;
        $this->consoleInputValueGuesser = $consoleInputValueGuesser;
        $this->consoleRenderer = $consoleRenderer;
        $this->consoleValidator = $consoleValidator;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(ConsoleRequest $consoleRequest)
    {
        try {
            $this->consoleValidator->validate($consoleRequest);

            $this->consoleRenderer->initUsageRecorder();
            $consoleValue = $this->consoleInputValueGuesser->guess($consoleRequest);

            echo $this->consoleRenderer->printSingleLine(sprintf("Running %s\n", $consoleValue));

            $result = $this->wordCountService->orderByNameAndWord($consoleValue);

            echo $this->consoleRenderer->printResponseData($result);
            echo $this->consoleRenderer->printUsage();
        } catch (MissingMandatoryAttributeException $e) {
            echo sprintf('missing mandatory parameter: %s', $e->getMessage());
        } catch (\Exception $e) {
            echo sprintf("an error occurred:\n%ss\n%s", $e->getMessage(), $e->getTraceAsString());
        }
    }
}
