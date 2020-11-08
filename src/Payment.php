<?php

namespace Hesabe\Payment;

use Hesabe\Payment\Payment\Config;

/**
 * Class Payment
 *
 * @author  Fahad Khan  <fkhan@hesabe.com>
 */
class Payment
{

    /**
     * @var  Config
     */
    private $config;

    /**
     * Payment constructor.
     *
     * @param  Config  $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     *
     * @return  string
     */
    public function sayHello($name)
    {
        $greeting = $this->config->get('greeting');

        return $greeting . ' ' . $name;
    }

}
