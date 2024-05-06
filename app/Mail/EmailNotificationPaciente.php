<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Doctor;
use App\Models\BookSale;
use App\Models\ClientBook;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotificationPaciente extends Mailable
{
    use Queueable, SerializesModels;

    public $book;
    public $doctor;
    public $email;
    public $dominio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($book, $doctor,$email,$dominio)
    {
        $this->book = $book;
        $this->doctor = $doctor;
        $this->email = $email;
        $this->dominio = $dominio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = '';
        $mensaje = '';

        $user = User::where('email', $this->email)->with('cliente')->first();
        $book = BookSale::where('id', $this->book)->first();
        $doc = Doctor::where('uuid', $this->doctor)->first();

        if (!empty($user)) {
            $client_book = new ClientBook();
            $client_book->cliente_id = $user->cliente->id;
            $client_book->book_sale_id = $book->id;
            $client_book->doctor_id = $doc->id;
            $client_book->save();
            $url = $this->dominio.'/login';
            $mensaje = "Ingresa a esta liga " . $this->dominio . "/login para que puedas descargar el libro " . $book->name .
                " ingresando tu número de celular. \n La contraseña para leer el contenido del libro es : " . $book->password;
        }
        $url = $this->dominio . "?book=" . $book->uuid ;
        $mensaje = "Ingresa a esta liga " . $this->dominio . "?book=" . $book->uuid . " 
            para que puedas descargar tu libro registrandote. \n La contraseña para leer el contenido del libro es : " . $book->password;

        return $this->view('email.NotificationLiga',compact('url','mensaje'));
    }

}
