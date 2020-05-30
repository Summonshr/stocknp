<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('company-date', function () {
    \App\Company::where('income', '0')->get()->each(function ($company) {
        try {
            print($company->symbol);
            $data = Http::timeout(5)->get('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol)['message']['data'][0] ?? false;
            if ($data) {
                $company->growth = ($data['GrowthOverPriorPeriod'] ?? 0) * 100;
                $company->eps = $data['EpsAnnualized'];
                $company->bvps = $data['BookValuePerShare'];
                $company->npl = ($data['NonPerformingLoanNplToTotalLoan'] ?? 0) * 100;
                $company->income = $data['NetIncome'] * 100;
            }

            $data = Http::timeout(2)->get('https://bizmandu.com/__stock/tearsheet/header/?tkr=' . $company->symbol)['message']['latestPrice'] ?? false;
            if ($data)
                $company->price = $data;

            $company->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    });
});


Artisan::command('mutual-funds', function () {
    dd();
});
