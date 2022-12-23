<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ys:check {ip : The IP address of the server} {port=7915 : The port of the server}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the status of a given server and cache the result.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ob_start();
        passthru('/usr/bin/python2.7 '.base_path().'/ys_proto.py '.$this->argument('ip').' '.$this->argument('port'));
        $output = ob_get_clean();
        $output = json_decode($output);
        print_r($output);
    }
}
