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
use Swift_TransportException;

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

        $bookUrls = [];
        foreach ($libros as $bookUrl) {
            $parsedUrl = parse_url($bookUrl->pdf);

            $temporalUrl = Storage::disk('s3')->temporaryUrl(
                ltrim($parsedUrl['path'], '/'),
                Carbon::now()->addMinutes(180)
            );

            $bookUrls[] = [
                'name' => $bookUrl->name,
                'url' => $temporalUrl,
                'password' => $bookUrl->password
            ];
        }

        Log::info(["Ligas Libros" => $bookUrls]);

        $mail = $this->view('email.agradecimiento', [
            'libros' => $bookUrls
        ])->subject('Compra Libros');


        Carbon::setLocale('es');
        $fecha = Carbon::now();
        $fechaFormateada = $fecha->translatedFormat('j \d\e F \d\e\l Y');

        $pdf = PDF::loadView('email.certificadoDoctor', ['doctor' => $this->doctor, 'fecha' => $fechaFormateada, 'book' => $libros[0]['name']]);

        $mail->attachData($pdf->output(), 'certificado.pdf', [
            'mime' => 'application/pdf',
        ]);

        return $mail;
    }
}
