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
     * @When the :binary command :command
     *
     * @param string $binary
     * @param string $command
     */
    public function theCommand($binary, $command)
    {
        $this->commandResponse = shell_exec($binary . ' ' . __DIR__ . $command);
    }

    /**
     * @Then the result would be equal to:
     *
     * @param PyStringNode $expectedResponse
     */
    public function theResultWouldBeEqualTo(PyStringNode $expectedResponse)
    {
        PHPUnit_Framework_Assert::assertSame(trim($expectedResponse->getRaw()), trim($this->commandResponse));
    }
}
