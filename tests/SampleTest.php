<?php

namespace Hesabe\Payment\Tests;

use Hesabe\Payment\Config;
use Hesabe\Payment\Sample;

/**
 * Class SampleTest
 *
 * @category Test
 * @package  Hesabe\Payment\Tests
 * @author   Fahad Khan <fkhan@hesabe.com>
 */
class SampleTest extends TestCase
{

    public function testSayHello()
    {
        $config = new Config();
        $sample = new Sample($config);

        $name = 'Fahad Khan';

        $result = $sample->sayHello($name);

        $expected = $config->get('greeting') . ' ' . $name;

        $this->assertEquals($result, $expected);

    }

}
