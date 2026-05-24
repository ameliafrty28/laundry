<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\RekapController;

class GenerateRekapHarian extends Command
{
    protected $signature = 'rekap:generate';

    protected $description =
        'Generate rekap harian otomatis';

    public function handle()
    {
        $controller = new RekapController();

        $controller->generateRekapHarian();

        $this->info(
            'Rekap harian berhasil diperbarui'
        );
    }
}