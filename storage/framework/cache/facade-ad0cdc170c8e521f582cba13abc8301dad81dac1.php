<?php

namespace Facades\Statamic\Licensing;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Statamic\Licensing\LicenseManager
 */
class LicenseManager extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Statamic\Licensing\LicenseManager';
    }
}
