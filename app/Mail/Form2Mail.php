<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use  Illuminate\Support\Facades\Log;
class Form2Mail extends Mailable
{
    use Queueable, SerializesModels;
  
   // public $fileName;
    public $pdf;







    public function __construct($pdf)
    {
    $this->pdf=$pdf;
  //  $this->fileName=$fileName;
    }


    public function build()
    {

    //$test='1605187358.pdf';
    return $this->subject('Rapport analyse') // ceci sera le sujet de l'e-mail
       ->view('emails.form2')
       ->attachData($this->pdf->output(), 'devis.pdf');
      }
      
    

}


