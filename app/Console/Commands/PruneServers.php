<?php

namespace YSFHQ\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

use YSFHQ\Domains\Server;

class PruneServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ys:pruneservers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove servers that have been offline for a while.';

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
            if ($server->ip === gethostbyname($server->ip) && !filter_var($server->ip, FILTER_VALIDATE_IP)) {
                $this->info("Deleting server {$server->name} at {$server->ip} - failed to resolve hostname");
                $server->delete();
                break;
            }
            if (!$server->last_online || $server->last_online->diffInDays(Carbon::now()) > 30) {
                $this->info("Deleting server {$server->name} ({$server->ip}) as it was last online {$server->last_online} which is more than 90 days ago");
                $server->delete();
                break;
            }
        }
    }
}
