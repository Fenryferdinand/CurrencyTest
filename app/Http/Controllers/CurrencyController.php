<?php

namespace App\Http\Controllers;

use App\Models\CurrencyLog;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurrencyController extends Controller
{
    public function getCurrencyList(){
        $currencyList = CurrencyLog::query()->paginate(10);
        return view('currencyList', ['currency' => $currencyList]);
    }

    public function deleteCurrencyList(){
        $newJobs = new Job();
        $newJobs->is_done = false;
        $newJobs->save();

        return redirect()->route('viewcurrencylog')->with('success', 'Item deleted successfully');
    }
}
