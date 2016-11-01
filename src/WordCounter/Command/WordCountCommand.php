<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 0.08
 */

namespace WordCounter\Command;


use WordCounter\Console\ConsoleRequest;
use WordCounter\Exception\NotAllowedConsoleParamException;
use WordCounter\Guesser\ConsoleInputGuesserInterface;
use WordCounter\Service\WordCountService;

class WordCountCommand implements CommandInterface
{
    const SOURCE = '--source';

    /**;
     * @var WordCountService
     */
    private $wordCountService;
    /**
     * @var ConsoleInputGuesserInterface
     */
    private $consoleRequest;

    /**
     * @param WordCountService $wordCountService
     * @param ConsoleRequest $consoleRequest
     */
    public function __construct(WordCountService $wordCountService, ConsoleRequest $consoleRequest)
    {
        $this->wordCountService = $wordCountService;
        $this->consoleRequest = $consoleRequest;
    }

    /**
     * @inheritdoc
     */
    public function execute(array $argv)
    {
        $rustart = getrusage();
        $consoleArguments = $this->getArguments($argv);
        $consoleValue = $this->consoleRequest->getParameterValue($consoleArguments, $argv);
        echo sprintf("running %s\n", $consoleValue);

        $result = $this->wordCountService->orderByNameAndWord($consoleValue);

        foreach ($result as $wordCount) {
            echo sprintf("%s=%d\n", $wordCount->getWord(), $wordCount->getCount());
        }

        function rutime($ru, $rus, $index)
        {
            return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000))
            - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
        }

        $ru = getrusage();
        $d = new \DateTime();
        $seconds = rutime($ru, $rustart, 'utime') / 1000;
        echo "\nThis process used " . $seconds .
            "sec for its computations\n";
        echo 'It spent ' . rutime($ru, $rustart, 'stime') .
            " ms in system calls\n";

        echo sprintf("real Usage %s\n", memory_get_peak_usage(true));
        echo sprintf("peak usage %s\n", memory_get_peak_usage());
    }

    /**
     * @param array $argv
     *
     * @return string|null
     * @throws NotAllowedConsoleParamException
     */
    private function getArguments(array $argv)
    {
        $mandatoryParameters = [self::SOURCE];

        foreach ($mandatoryParameters as $mandatoryParameter) {
            foreach ($argv as $value) {
                if (false !== strpos($value, $mandatoryParameter)) {
                    return $mandatoryParameter;
                }
            }
        }

        throw new NotAllowedConsoleParamException(
            sprintf("missing mandatory parameter from %s", implode(',', $mandatoryParameters)
            )
        );
    }


}