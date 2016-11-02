<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 02/11/16
 * Time: 17.51
 */

namespace WordCounter\Test\Validator;


use WordCounter\Console\ConsoleRequest;
use WordCounter\Manager\ConfigManager;
use WordCounter\Validator\ConsoleArgumentValidator;
use WordCounter\Validator\ConsoleValidatorInterface;

class ConsoleArgumentValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConfigManager|\PHPUnit_Framework_MockObject_MockObject
     */
    private $configManager;
    /**
     * @var ConsoleValidatorInterface
     */
    private $consoleArgumentValidator;

    public function setUp()
    {
        $this->configManager = $this->getMockBuilder('WordCounter\Manager\ConfigManager')
            ->disableOriginalConstructor()
            ->getMock();

        $this->consoleArgumentValidator = new ConsoleArgumentValidator($this->configManager);
    }

    /**
     * @test
     */
    public function validatesConsoleRequest()
    {
        $mandatoryParams = ['--source', '--foo'];
        $this->configManager->expects($this->once())
            ->method('getValue')
            ->with(ConsoleArgumentValidator::MANDATORY_CONSOLE_ARGS)
            ->willReturn($mandatoryParams);

        $consoleArgv = [
            '',
            '--source=test',
        ];
        $consoleRequest = new ConsoleRequest($consoleArgv);

        $this->consoleArgumentValidator->validate($consoleRequest);
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\MissingMandatoryAttributeException
     */
    public function throwsExceptionWhenInvalidOrMissingConsoleAttributesAreConsumed()
    {
        $mandatoryParams = ['--foo'];
        $this->configManager->expects($this->once())
            ->method('getValue')
            ->with(ConsoleArgumentValidator::MANDATORY_CONSOLE_ARGS)
            ->willReturn($mandatoryParams);

        $consoleArgv = [
            '',
            '--source=test',
        ];
        $consoleRequest = new ConsoleRequest($consoleArgv);

        $this->consoleArgumentValidator->validate($consoleRequest);
    }
}
