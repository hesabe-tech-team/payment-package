<?php

namespace Hesabe\Payment\Payment\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SampleFacadeAccessor
 *
 * @author  Fahad Khan  <fkhan@hesabe.com>
 */
class SampleFacadeAccessor extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nextpack.sample';
    }
}
