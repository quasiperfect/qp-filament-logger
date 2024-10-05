<?php

namespace Z3d0X\FilamentLogger\Loggers;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Activitylog\ActivityLogStatus;
use Spatie\Activitylog\ActivityLogger;

class NotificationLogger
{
    /**
     * Log the notification
     *
     * @param  NotificationSent|NotificationFailed  $event
     * @return void
     */
    public function handle(NotificationSent|NotificationFailed $event)
    {
        $notification = class_basename($event->notification);

        $recipient = $this->getRecipient($event->notifiable, $event->channel);
        if (!$recipient) {
            $recipient = __('filament-logger::filament-logger.resource.log.notifications.not_available');
        }

        if ($event instanceof NotificationSent) {
            $description = __('filament-logger::filament-logger.resource.log.notifications.sent', ['notification' => $notification, 'recipient' => $recipient]);
        } else {
            $description = __('filament-logger::filament-logger.resource.log.notifications.failed', ['notification' => $notification, 'recipient' => $recipient]);
        }


        app(ActivityLogger::class)
            ->useLog(__('filament-logger::filament-logger.resource.log.notifications.log_name'))
            ->setLogStatus(app(ActivityLogStatus::class))
            ->causedByAnonymous()
            ->event(Str::of(class_basename($event))->headline())
            ->log($description);
    }

    public function getRecipient(mixed $notifiable, string $channel): ?string
    {
        $notificationRoute = $notifiable->routeNotificationFor($channel);
        return is_string($notificationRoute) ? $notificationRoute : null;
    }
}
