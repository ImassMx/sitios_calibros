<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LigaPaciente extends Mailable
{
    use Queueable, SerializesModels;
    public $folio;
    public $dominio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($folio,$dominio)
    {
       $this->folio = $folio;
       $this->dominio = $dominio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.emailPaciente',['folio'=> $this->folio,'dominio'=> $this->dominio])->subject("Liga Paciente");
    }
}
