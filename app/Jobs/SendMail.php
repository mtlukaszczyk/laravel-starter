<?php declare(strict_types=1);

namespace App\Jobs;

use App\Contracts\MailReceiver;
use App\Events\Mail\Created;
use App\Events\Mail\Sent;
use App\Exceptions\MailException;
use App\Mailables\Mailable;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public bool $deleteWhenMissingModels = true;

    private Mailer $mailer|false = false;

    public function __construct(
        protected Mailable $mailable,
        protected MailReceiver $recipient
    ) {
        if ($this->recipient instanceof HasLocalePreference) {
            $this->mailable = $this->mailable->locale(strtolower((string) $this->recipient->preferredLocale()));
        }

        $this->onQueue('default');
    }

    public function handle(): void
    {
        if (!$this->mailer) {
            $this->mailer = app(Mailer::class);
        }
        
        try {
            event(new Created($this->mailable, $this->recipient));
            $this->mailer->to($this->recipient->getEmail())->send($this->mailable);
            event(new Sent($this->mailable, $this->recipient));
        } catch (Exception $e) {
            throw new MailException($this->mailable, $this->recipient, $e->getMessage());
        }
    }
}
