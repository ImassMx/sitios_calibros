<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\BookSale;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use PDF; // Asegúrate de importar la clase PDF


class SendBooksMail extends Mailable
{
    use Queueable, SerializesModels;
    public $books;
    public $doctor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($books,$doctor)
    {
        $this->books = $books;
        $this->doctor = $doctor;
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

        Carbon::setLocale('es');
        $fecha = Carbon::now();
        $fechaFormateada = $fecha->translatedFormat('j \d\e F \d\e\l Y');

    $pdf = PDF::loadView('email.certificadoDoctor', ['doctor' => $this->doctor,'fecha' =>$fechaFormateada ]);

    $mail->attachData($pdf->output(), 'certificado.pdf', [
        'mime' => 'application/pdf',
    ]);


        return $mail;
    }
}
