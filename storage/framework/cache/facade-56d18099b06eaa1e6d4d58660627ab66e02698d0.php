<?php

namespace Facades\Statamic\Fields;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Statamic\Fields\FieldRepository
 */
class FieldRepository extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Statamic\Fields\FieldRepository';
    }
}
