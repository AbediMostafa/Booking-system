<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Morilog\Jalali\Jalalian;

class AppBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . Jalalian::now()->format('Y-m-d-h:i:s') . ".gz";

        $command = "zip -r /backup/app-backup/$filename /opt/Missescape-vue/";

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
