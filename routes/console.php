<?php



Artisan::command('fetch', function () {


    \App\Company::where('eps', '=', 0)->each(function ($company) {
        $data = json_decode(file_get_contents('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol))->message->data[0] ?? false;
        if ($data) {
            $company->forceFill([
                'eps' => $data->EpsAnnualized,
                'bvps' => $data->BookValuePerShare,
                'npl' => ($data->NonPerformingLoanNplToTotalLoan ?? 0) * 100
            ]);
            $company->save();
        }
    });
});
