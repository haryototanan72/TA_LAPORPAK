<?php

namespace App\Helpers;

class GamificationHelper
{
    public static function getTitle($points)
    {
        if ($points >= 250) return 'Legenda Kota';
        if ($points >= 200) return 'Guardian Kota';
        if ($points >= 150) return 'Pejuang Infrastruktur';
        if ($points >= 100) return 'Pengawas Jalan';
        if ($points >= 50)  return 'Pelapor Aktif';
        return 'Warga Baru';
    }
}
