<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('fetch', function () {
    \App\Company::all()->each(function ($company) {
        print($company->symbol);
        $data = json_decode(file_get_contents('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol))->message->data[0] ?? false;
        if ($data && ($data->GrowthOverPriorPeriod ?? false)) {
            $company->growth = $data->GrowthOverPriorPeriod * 100;
            $company->eps = $data->EpsAnnualized;
            $company->bvps = $data->BookValuePerShare;
            $company->npl = ($data->NonPerformingLoanNplToTotalLoan ?? 0) * 100;
            $company->income = $data->NetIncome * 100;
        }

        $data = json_decode(file_get_contents('https://bizmandu.com/__stock/tearsheet/header/?tkr=' . $company->symbol))->message->latestPrice;

        $company->latestPrice = $data;

        $company->save();
    });
});
