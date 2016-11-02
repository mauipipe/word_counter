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
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Service\WordCountService;

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
     * @param WordCountService $wordCountService
     * @param ConsoleInputGuesserInterface $consoleInputValueGuesser
     * @param ConsoleRendererInterface $consoleRenderer
     */
    public function __construct(
        WordCountService $wordCountService,
        ConsoleInputGuesserInterface $consoleInputValueGuesser,
        ConsoleRendererInterface $consoleRenderer
    )
    {
        $this->wordCountService = $wordCountService;
        $this->consoleInputValueGuesser = $consoleInputValueGuesser;
        $this->consoleRenderer = $consoleRenderer;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(ConsoleRequest $consoleRequest)
    {
        $this->consoleRenderer->initUsageRecorder();
        $consoleValue = $this->consoleInputValueGuesser->guess($consoleRequest);

        echo $this->consoleRenderer->printSingleLine(sprintf("Running %s\n", $consoleValue));

        $result = $this->wordCountService->orderByNameAndWord($consoleValue);

        echo $this->consoleRenderer->printResponseData($result);
        echo $this->consoleRenderer->printUsage();
    }
}
