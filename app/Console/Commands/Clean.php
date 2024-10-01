<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Illuminate\Contracts\Console\Kernel;

#[AsCommand(name: 'wc')]
class Clean extends Command
{
    protected $description = 'wielki clean';

    public function __construct(
        private readonly Kernel $artisan
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $commands = ['cache:clear', 'route:clear', 'view:clear', 'config:clear', 'event:clear'];

        $this->info('<fg=black;bg=white;bold>CLEAN<fg=green;bg=white>:)</>');

        if (env('APP_ENV') === 'production') {
            $commands[] = 'route:cache';
            $commands[] = 'view:cache';
            $commands[] = 'config:cache';
            $commands[] = 'view:cache';
        }

        //$commands[] = 'ziggy:generate';

        $res = 0;
        $this->info('');

        foreach ($commands as $command) {
            $this->info('<bg=magenta>' . $command . '</>');
            $res += $this->artisan->call($command);
            $this->info($this->artisan->output());
        }

        return (int) ($res !== 0);
    }
}
