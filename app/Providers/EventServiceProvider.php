<?php declare(strict_types=1);

namespace App\Providers;

use App\Resolvers\ResolveSubscribers;
use ClassFinder\ClassFinder;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    private string $subscribersNamespace = 'App\\Actions';

    private readonly ClassFinder $classFinder;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->classFinder = new ClassFinder();
    }

    #[\Override]
    public function register(): void
    {
        parent::register();
        /** @var Dispatcher $eventDispatcher */
        $eventDispatcher = $this->app->make(Dispatcher::class);

        /** @var class-string[] $subscribers */
        $subscribers = $this->classFinder->getClassesByNamespace($this->subscribersNamespace);

        foreach ($subscribers as $subscriber) {
            foreach ($this->resolveListeners($subscriber) as [$event, $listener]) {
                $eventDispatcher->listen($event, $listener);
            }
        }
    }

    /**
     * @param class-string $subscriberClass
     * @return array<int, array<int, array<int, string>|string>>
     */
    private function resolveListeners(string $subscriberClass): array
    {
        /** @var ResolveSubscribers $resolveSubscribers */
        $resolveSubscribers = $this->app->make(ResolveSubscribers::class);

        return $resolveSubscribers->resolve($subscriberClass);
    }
}
