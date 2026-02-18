<?php

namespace App\Console\Commands;

use App\Models\Semester;
use Illuminate\Console\Command;

class PublishWeekModule extends Command
{
    protected $signature = 'modules:publish-week';

    protected $description = 'Publish the current week\'s module for the active semester (run on Mondays).';

    public function handle(): int
    {
        $semester = Semester::active()->first();
        if (! $semester) {
            $this->warn('No active semester.');
            return self::SUCCESS;
        }

        $week = $semester->currentWeekNumber();
        if ($week === null) {
            $this->warn('Current date is outside the active semester range.');
            return self::SUCCESS;
        }

        $module = $semester->modules()->where('week_number', $week)->first();
        if (! $module) {
            $this->warn("No module for week {$week} in {$semester->name}.");
            return self::SUCCESS;
        }

        if ($module->published_at !== null) {
            $this->info("Week {$week} module already published.");
            return self::SUCCESS;
        }

        $module->update(['published_at' => now()]);
        $this->info("Published week {$week} module: {$module->title}");

        return self::SUCCESS;
    }
}
