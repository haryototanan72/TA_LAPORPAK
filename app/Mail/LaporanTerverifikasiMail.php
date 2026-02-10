<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanTerverifikasiMail extends Mailable
{
    public $laporan;
    public $pdf;

    public function __construct($laporan, $pdf)
    {
        $this->laporan = $laporan;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Laporan Infrastruktur Terverifikasi')
            ->view('admin.laporan.detail', [
                'laporan' => $this->laporan,
                'pdf' => $this->pdf
            ])
            ->attachData(
                $this->pdf->output(),
                'laporan_'.$this->laporan->id.'.pdf'
            );
    }
}

