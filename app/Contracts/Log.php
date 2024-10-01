<?php declare(strict_types=1);

namespace App\Contracts;

use Monolog\LogRecord;

interface Log
{
    /**
     * @param array<string, mixed>|LogRecord $record
     */
    public function logFromHandler(array|LogRecord $record): void;
}
