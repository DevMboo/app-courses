<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DownloadLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;

    /**
     * Crie uma nova instância de mensagem.
     *
     * @param string $filePath
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Montar a mensagem.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Download do Arquivo')
                    ->view('emails.download_link')
                    ->with([
                        'filePath' => $this->filePath,
                    ]);
    }
}
