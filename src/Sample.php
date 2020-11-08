<?php

namespace Hesabe\Payment;

/**
 * Class Sample
 *
 * @author  Fahad Khan  <fkhan@hesabe.com>
 */
class Sample
{

    /**
     * @var  \Hesabe\Payment\Config
     */
    private $config;

    /**
     * Sample constructor.
     *
     * @param \Hesabe\Payment\Config $config
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
