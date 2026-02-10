<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Laporan;
use App\Helpers\GamificationHelper;

class RecalculateUserPoints extends Command
{
    protected $signature = 'gamification:recalculate-points';

    protected $description = 'Hitung ulang poin user berdasarkan laporan';

    public function handle()
    {
        $this->info(' Menghitung ulang poin user...');

        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            $totalReports = Laporan::where('user_id', $user->id)->count();

            $points = $totalReports * 10;

            $user->points = $points;
            $user->title  = GamificationHelper::getTitle($points);
            $user->save();

            $this->line(" {$user->name} → {$points} poin");
        }

        $this->info('Sinkronisasi selesai!');
    }
}
 