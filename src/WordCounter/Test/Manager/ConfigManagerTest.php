<?php
/**
 * Created by IntelliJ IDEA.
 * User: mauilap
 * Date: 01/11/16
 * Time: 20.44.
 */

namespace WordCounter\Test\Manager;

use WordCounter\Repository\ConfigRepository;

class ConfigManagerTest extends \PHPUnit_Framework_TestCase
{
    const CONFIG_KEY = 'foo';
    const VALUE = 'bar';

    /**
     * @var ConfigRepository
     */
    private $configManager;

    public function setUp()
    {
        $this->configManager = new ConfigRepository(__DIR__ . '/../fixtures/config.json');
    }

    /**
     * @test
     */
    public function getsConfigValue()
    {
        $result = $this->configManager->getValue(self::CONFIG_KEY);
        $this->assertEquals(self::VALUE, $result);
    }

    /**
     * @test
     *
     * @expectedException \WordCounter\Exception\UndefinedConfigValueException
     */
    public function throwsExceptionWhenWrongParameterConsumed()
    {
        $this->configManager->getValue('invalid');
    }
}
