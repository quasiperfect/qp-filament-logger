<?php

namespace Z3d0X\FilamentLogger\Loggers;

class ModelLogger extends AbstractModelLogger
{
    protected function getLogName(): string
    {
        return __('filament-logger::filament-logger.resource.log.models.log_name');
    }
}
