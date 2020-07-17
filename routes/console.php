<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('company-date', function () {
    \App\Company::all()->each(function ($company) {
        try {
            print($company->symbol);
            // $data = Http::timeout(5)->get('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol)['message']['data'][0] ?? false;
            // if ($data) {
            //     $company->growth = ($data['GrowthOverPriorPeriod'] ?? 0) * 100;
            //     $company->eps = $data['EpsAnnualized'];
            //     $company->bvps = $data['BookValuePerShare'];
            //     $company->npl = ($data['NonPerformingLoanNplToTotalLoan'] ?? 0) * 100;
            //     $company->income = $data['NetIncome'] * 100;
            // }

            $data = Http::timeout(2)->get('https://bizmandu.com/__stock/tearsheet/header/?tkr=' . $company->symbol)['message'] ?? false;
            if ($data) {
                $company->price = $data['latestPrice'];
                $company->change_status = $data['pointChange'];
            }
            $company->save();
        } catch (\Throwable $th) {
        }
    });
});

Artisan::command('change-status', function () {
    \App\Company::all()->each(function ($company) {
        try {
            print($company->symbol);

            $data = Http::timeout(2)->get('https://bizmandu.com/__stock/tearsheet/header/?tkr=' . $company->symbol)['message'] ?? false;

            if ($data) {
                $company->price = $data['latestPrice'];
                $company->change_status = $data['pointChange'];
            }


            $company->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
    });
});


Artisan::command('dividends', function () {
    return;
    \App\Company::all()->each(function ($company) {

        try {
            print($company->symbol);
            $data = Http::timeout(5)->get('https://bizmandu.com/__stock/tearsheet/dividend/?tkr=' . $company->symbol)['message'] ?? false;

            collect($data['dividend'] ?? [])->reverse()->map(function ($e) use ($company) {
                $dividend = new \App\Dividend();
                $dividend->symbol = $company->symbol;
                $dividend->forceFill($e);
                $dividend->save();
            });

            collect($data['rights'] ?? [])->reverse()->map(function ($e) use ($company) {
                $right = new \App\Right();
                $right->symbol = $company->symbol;
                $right->forceFill(['percentage' => $e['rights'], 'year' => $e['date']]);
                $right->save();
            });
        } catch (\Throwable $th) {
            print($th);
        }
    });
});
