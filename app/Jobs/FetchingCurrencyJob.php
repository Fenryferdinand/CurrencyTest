<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Currency;

class FetchingCurrencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(Currency $currency): void
    {
        $fetchData = $currency->getCurrencyData();
        $formatedData = $currency->formateCurrencyData($fetchData);
        $saveFileData = $currency->saveCurrencyFile($formatedData);
        
    }
}
