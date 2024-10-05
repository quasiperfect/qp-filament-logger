<?php

namespace Z3d0X\FilamentLogger\Loggers;

class ResourceLogger extends AbstractModelLogger
{
    protected function getLogName(): string
    {
        return __('filament-logger::filament-logger.resource.log.resource.log_name');
    }
}
