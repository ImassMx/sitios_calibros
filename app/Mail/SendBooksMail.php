<?php

namespace App\Mail;

use App\Models\BookSale;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBooksMail extends Mailable
{
    use Queueable, SerializesModels;
    public $books;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($books)
    {
        $this->books = $books;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $libros = BookSale::whereIn('id', $this->books)->get();

        $mail = $this->view('email.agradecimiento',[
                        'libros' => $libros
            ])->subject('Compra Libros');

        foreach ($libros as $bookUrl) {
            $parsedUrl = parse_url($bookUrl->pdf);
            $mail->attachFromStorageDisk('s3', '/'.$parsedUrl['path'],Str::slug($bookUrl->name).'.pdf');
        }

        return $mail;
    }
}
