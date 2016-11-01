<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 29/10/16
 * Time: 16.45
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
            throw new FileNotFoundException(sprintf("cannot find file %s", $sourcePath));
        }
    }

    /**
     * @When the command :command
     *
     * @param string $command
     */
    public function theCommand($command)
    {
        $this->commandResponse = exec(__DIR__ . $command);
    }

    /**
     * @Then the result would be equal to:
     *
     * @param PyStringNode $expectedResponse
     */
    public function theResultWouldBeEqualTo(PyStringNode $expectedResponse)
    {
        $decodedResponse = json_decode($expectedResponse->getRaw(), true);

        PHPUnit_Framework_Assert::assertSame($decodedResponse, $this->commandResponse);
    }

}