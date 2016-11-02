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
        $sourcePath = \WordCounter\App\App::getRootDir() . 'features/fixtures/' . $sourceText;
        if (!file_exists($sourcePath)) {
            throw new FileNotFoundException(sprintf('scenario: cannot find file %s', $sourcePath));
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

        $result = $this->getResult();

        PHPUnit_Framework_Assert::assertSame(
            $result,
            $expectedResult,
            implode(',', array_diff($expectedResult, $result))
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

        return count($result);
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

    /**
     * @When print console response
     */
    public function printConsoleResponse2()
    {
        var_export(implode("\n", $this->getResult()));
    }

    /**
     * @Given my system have no random generated file :fileName
     */
    public function mySystemHaveNoRandomGeneratedFile($fileName)
    {
        $sourcePath = __DIR__ . '' . self::FIXTURES_FOLDER . '' . $fileName;

        PHPUnit_Framework_Assert::assertTrue(!is_file($sourcePath));
    }

    /**
     * @Then a valid result is return
     */
    public function aValidResultIsReturn()
    {
        PHPUnit_Framework_Assert::assertTrue(count($this->getResult()) > 0);
    }

    /**
     * @return array
     */
    private function getResult()
    {
        $commandResponse = trim(str_replace("\n", ' ', $this->commandResponse));
        $result = explode(' ', $commandResponse);
        $slicedResult = array_slice($result, 2, $this->getResultMaxLimit($result) - 1);

        return $slicedResult;
    }
}
