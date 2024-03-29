<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Server;

class CheckServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ys:checkservers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all servers and cache their statuses.';

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
        foreach (Server::all() as $server) {
            $server->checkServer();
        }
    }
}
