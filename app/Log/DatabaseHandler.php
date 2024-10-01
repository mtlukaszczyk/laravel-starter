<?php declare(strict_types=1);

namespace App\Log;

use App\Contracts\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class DatabaseHandler extends AbstractProcessingHandler
{
    public function __construct(private readonly string $modelName, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * @param array<string, mixed>|LogRecord $record
     */
    #[\Override]
    protected function write(array|LogRecord $record): void
    {
        if (!is_array($record)) {
            $record = $record->toArray();
        }

        $error = new $this->modelName();

        if ($error instanceof Log) {
            $error->logFromHandler($record);
        }
    }
}
