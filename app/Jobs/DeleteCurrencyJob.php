<?php

namespace App\Jobs;

use App\Models\CurrencyLog;
use App\Models\Job;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteCurrencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jobs = Job::where('is_done',false)->first();
        if($jobs){
            CurrencyLog::truncate();
            Storage::deleteDirectory('/public/currency');
            $jobs->is_done = TRUE;
            $jobs->execute_at = now()->format('Y-m-d H:i:s');
            $jobs->save();
        }
    }
}
