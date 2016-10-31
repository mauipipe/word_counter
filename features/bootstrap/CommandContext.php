<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 16.45.
 */
class CommandContext implements Context
{
    const FIXTURES_FOLDER = '/../fixtures/';

    /**
     * @var array
     */
    private $commandResponse = [];

    /**
     * @Given there is a :sourceText in my system
     *
     * @param string $sourceText
     */
    public function thereIsAInMySystem($sourceText)
    {
        $sourcePath = __DIR__ . '' . self::FIXTURES_FOLDER . '' . $sourceText;
        if (!file_exists($sourcePath)) {
            throw new FileNotFoundException(sprintf('cannot find file %s', $sourcePath));
        }
    }

    /**
     * @Then the result would be equal to:
     *
     * @param PyStringNode $expectedResponse
     */
    public function theResultWouldBeEqualTo(PyStringNode $expectedResponse)
    {
        $expectedResult = explode("\n", trim($expectedResponse->getRaw()));
        $result = explode("\n", trim($this->commandResponse));

        $result = array_slice($result, 1, $this->getResultMaxLimit($result));

        PHPUnit_Framework_Assert::assertSame(
            $expectedResult,
            $result
        );
    }

    /**
     * @param array $result
     *
     * @return int
     */
    private function getResultMaxLimit(array $result)
    {
        foreach ($result as $key => $value) {
            if (empty($value)) {
                return (int)$key - 1;
            }
        }

        throw new RuntimeException(sprintf("invalid result %s"), $result);
    }

    /**
     * @When the :arg1 command :arg2
     */
    public function theCommand($arg1, $arg2)
    {
        $this->commandResponse = shell_exec($arg1 . ' ' . __DIR__ . $arg2);
    }

    /**
     * @When value :arg1 is piped :arg2 command :arg3
     */
    public function valueIsPipedCommand($arg1, $arg2, $arg3)
    {
        $currentDir = __DIR__ . '/../' . $arg1;
        $this->commandResponse = shell_exec(sprintf('(cat %s | %s %s)', $currentDir, $arg2, __DIR__ . $arg3));
    }
}
