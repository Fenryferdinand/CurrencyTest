<?php

namespace App\Services;

use App\Models\CurrencyLog;
use DateTime;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Currency
{

    public function getCurrencyData()
    {
        $trTemp = [];
        $client = new Client();
        $url = 'https://kursdollar.org';
        
        $crawler = $client->request('GET', $url);
        $tableCrawler = $crawler->filter('.in_table');

        $tableCrawler->filter('tr')->each(function ($tr, $index) use (&$trTemp) {
            $limit = 23;
            if($index +1 <= $limit){
                $trTemp[] = $tr->text();
            }
        });
        
        return $trTemp;
    }

    public function formateCurrencyData($data){
        $formatedData = [];
        $count = 0;
        for($i=0;$i<count($data);$i++){
            if($i == 0){
                $word = explode(' - ', $data[$i]);
                $word = preg_split('/\s+|\x{A0}/u', $word[1], -1, PREG_SPLIT_NO_EMPTY);
                $date = $word[1].' '.$word[2].' '.$word[3];
                $date = DateTime::createFromFormat('d F Y', $date);
                $reformateDate = $date->format('d-m-Y');
                $day = $date->format('l');
                $formatedData['meta']['date'] = $reformateDate;
                $formatedData['meta']['day'] = $day;                
            }
            if($i == 1){
                $word = explode(' ', $data[$i]);
                $formatedData['meta']['indonesia'] = $word[2].' '.$word[3].' '.$word[4].' '.$word[5].' '.$word[6].' '.$word[7];
                $formatedData['meta']['world'] = $word[8].' '.substr($word[9],0,5).' '.substr($word[9],5,2).' '.$word[10].' '.$word[11];
            }
            if($i > 2){
                $word = explode(' ', $data[$i]);
                $formatedData['rates'][$count]['currency'] = substr($word[0],0,3);
                $formatedData['rates'][$count]['buy'] = $word[1];
                $formatedData['rates'][$count]['sell'] = $word[3];
                $formatedData['rates'][$count]['average'] = $word[5] ?? null;
                $formatedData['rates'][$count]['word_rate'] =$word[7] ?? null;
                $count++;
            }
        }
        return $formatedData;
    }

    public function saveCurrencyFile($data){
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        $currentDateTime = now()->format('d-m-Y--H-i-s');

        $fileName = 'rate-' . $currentDateTime . '.json';
        $disk = 'public';

        
        $fileUrl = Storage::url('currency/'.$fileName);
        Storage::disk($disk)->put('currency/'.$fileName, $jsonString);
        $fileUrl = (string) $fileUrl;
        $newCurrencyLog = new CurrencyLog();
        $newCurrencyLog->file_path = 'public/currency/'.$fileName;
        $newCurrencyLog->save();
        return $fileUrl;
    }
}