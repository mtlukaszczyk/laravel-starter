<?php declare(strict_types=1);

namespace App\Mailables;

class CustomMailable extends Mailable
{
    public function __construct(
        public string $content,
        public string $title,
    ) {
    }

    public function build(): CustomMailable
    {
        return $this->html($this->content)
            ->subject($this->title);
    }
}
