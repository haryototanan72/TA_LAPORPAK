<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaporanTerkirim extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public $laporan,
        public $pdf
    ) {}

    public function build()
    {
        return $this->subject('Laporan Baru dari LAPORPAK')
            ->view('emails.laporan_terkirim')
            ->attachData(
                $this->pdf->output(),
                'laporan.pdf',
                ['mime' => 'application/pdf']
            );
    }
}
