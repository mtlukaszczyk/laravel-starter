<?php declare(strict_types=1);

namespace App\Resolvers;

use App\Attributes\Events\SubscribedTo;
use ReflectionClass;

class ResolveSubscribers
{
    /**
     * @param class-string $subscriberClass
     * @return array<int, array<int, array<int, string>|string>>
     */
    public function resolve(string $subscriberClass): array
    {
        $subscriberReflectionClass = new ReflectionClass($subscriberClass);
        $subscribers = [];

        foreach ($subscriberReflectionClass->getMethods() as $subscriberMethod) {
            // Only get the attribute "SubscribedTo"
            $subscriberMethodAttributes = $subscriberMethod->getAttributes(SubscribedTo::class);

            foreach ($subscriberMethodAttributes as $subscriberMethodAttribute) {
                // Instantiate the "SubscribedTo" class, so we can get the event name

                /** @var SubscribedTo $subscriber */
                $subscriber = $subscriberMethodAttribute->newInstance();

                $subscribers[] = [
                    $subscriber->event,
                    [$subscriberClass, $subscriberMethod->getName()]
                ];
            }
        }

        return $subscribers;
    }
}
