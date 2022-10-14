<?php

namespace App\Mail;

use App\Models\Artigo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailUser extends Mailable
{
    use Queueable, SerializesModels;
   
    public $artigo;
    
    public function __construct(Artigo $artigo)
    {
        $this->artigo = $artigo;
    }
    
    public function build()
    {                   
        return $this->from('delcionelopes@gmail.com')  //o e-Mail da aplicação
                    ->view('page.email.email')
                    ->with(['artigo'=>$this->artigo,])
                    ->subject($this->artigo->titulo);
    }
}