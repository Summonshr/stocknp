<?php

use Goutte\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('prices', function () {
    $client = new Client();
    $date = \Carbon\Carbon::parse('05/10/2010');
    $d = $date->format('m/d/Y');
    $crawler = $client->request('POST', 'https://www.merolagani.com/StockQuote.aspx', ['ctl00$ContentPlaceHolder1$txtMarketDateFilter' => $d]);
    $crawler->filter('table.table-bordered.table-striped tbody tr')->each(function ($node) use (&$date) {
        $prices = [];
        $node->filter('td')->each(function ($node) use (&$prices) {
            $prices[] = $node->text();
        });
        \App\Company::where('symbol', $prices[1])->where('price', 0)->update(['price' => str_replace(',', '', $prices[2])]);
    });
    $date = $date->addDay();
});
