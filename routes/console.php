<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Live: indholdsændringer fra CP committes og pushes samlet hvert 10. minut (STATAMIC_GIT_ENABLED=true, STATAMIC_GIT_AUTOMATIC=false)
\Illuminate\Support\Facades\Schedule::command('statamic:git:commit')->everyTenMinutes()->withoutOverlapping();
