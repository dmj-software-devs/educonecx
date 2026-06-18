<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\PracticeCreditService;
use Illuminate\Console\Command;

class SyncPracticeMonthlyAllocations extends Command
{
    protected $signature = 'practice:sync-monthly-allocations {--user= : Sync a single user ID}';

    protected $description = 'Renew the included monthly Practice Room time for paid members.';

    public function handle(PracticeCreditService $practiceCreditService): int
    {
        $query = User::query();

        if ($this->option('user')) {
            $query->whereKey((int) $this->option('user'));
        }

        $synced = 0;

        $query->chunkById(100, function ($users) use ($practiceCreditService, &$synced) {
            foreach ($users as $user) {
                if (! $user->has_active_subscription) {
                    continue;
                }

                $practiceCreditService->syncMonthlyAllocation($user);
                $synced++;
            }
        });

        $this->info("Synced monthly Practice Room allocations for {$synced} paid member(s).");

        return self::SUCCESS;
    }
}
