<?php declare(strict_types=1);

namespace App\Events;

use Psr\EventDispatcher\EventDispatcherInterface;

class Dispatcher implements EventDispatcherInterface
{
    #[\Override]
    public function dispatch(object $event): object
    {
        event($event);
        return $event;
    }
}
