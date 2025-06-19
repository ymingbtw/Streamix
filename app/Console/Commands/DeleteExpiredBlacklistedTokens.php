<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExpiredBlacklistedTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-blacklisted-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        DB::table('blacklisted_tokens')
            ->where('expires_at', '<', now()->timestamp) // use timestamp if exp is UNIX
            ->delete();

        $this->info('Expired blacklisted tokens deleted.');
    }
}
