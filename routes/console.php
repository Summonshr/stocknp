<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('fetch', function () {
    \App\Company::where('net_income', '=', '0')->get()->each(function ($company) {
        $data = json_decode(file_get_contents('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol))->message->data[0] ?? false;
        if ($data && ($data->GrowthOverPriorPeriod ?? false)) {
            $company->growth = $data->GrowthOverPriorPeriod * 100;
            $company->net_income = $data->NetIncome * 100;
            $company->save();
        }
    });
});
