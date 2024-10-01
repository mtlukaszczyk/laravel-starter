<?php declare(strict_types=1);

namespace App\Log;

use Monolog\Logger;

class DatabaseLogger
{
    /**
     * @param array<string, string> $config
     */
    public function __invoke(array $config): Logger
    {
        return new Logger('Database', [
            new DatabaseHandler($config['model'])
        ]);
    }
}
