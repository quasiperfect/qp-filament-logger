<?php

namespace Z3d0X\FilamentLogger\Loggers;

use Filament\Facades\Filament;
use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\ActivityLogger;
use Spatie\Activitylog\ActivityLogStatus;

class AccessLogger
{
    /**
     * Log user login
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        app(ActivityLogger::class)
            ->useLog(__('filament-logger::filament-logger.resource.log.access.log_name'))
            ->setLogStatus(app(ActivityLogStatus::class))
            ->withProperties(['ip' => request()->ip(), 'user_agent' => request()->userAgent()])
            ->event(__('filament-logger::filament-logger.resource.log.access.event'))
            ->log(__('filament-logger::filament-logger.resource.log.access.description'), ['user' => Filament::getUserName($event->user)]);
    }
}
