<?php declare(strict_types=1);

namespace App\Models;

use App\Contracts\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Monolog\LogRecord;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property string $class
 * @property array<string, mixed> $payload
 * @property Carbon|null $created_at
 */
class LogError extends Model implements Log
{
    protected $table = 'log_error';

    public const string|null UPDATED_AT = null;

    public const array IGNORE = [
        NotFoundHttpException::class
    ];

    /**
     * @return array<string, string>
     */
    #[\Override]
    public function casts(): array
    {
        return [
            'payload' => 'json'
        ];
    }

    /**
     * @param array<string, mixed>|LogRecord $record
     */
    #[\Override]
    public function logFromHandler(array|LogRecord $record): void
    {
        if (isset($record['context']['class']) && in_array($record['context']['class'], self::IGNORE)) {
            return;
        }
        $log = new LogError();
        $log->class = $record['context']['class'] ?? '';
        $log->payload = is_array($record) ? $record : $record->toArray();
        $log->save();
    }
}
