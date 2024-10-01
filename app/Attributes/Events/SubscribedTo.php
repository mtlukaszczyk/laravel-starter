<?php declare(strict_types=1);

namespace App\Attributes\Events;

use Attribute;

#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_METHOD)]
class SubscribedTo
{
    public function __construct(public string $event)
    {
    }
}
