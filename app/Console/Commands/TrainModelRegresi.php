<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ModelRegresiController;

class TrainModelRegresi extends Command
{
    protected $signature = 'model:train';

    protected $description =
        'Training ulang model regresi';

    public function handle()
    {
        $controller =
            new ModelRegresiController();

        $controller->train();

        $this->info(
            'Training model berhasil'
        );
    }
}