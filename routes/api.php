  <?php
    // this commit should be seen in server
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use Goutte\Client;

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('home', function () {
        return ['home' => \Wink\WinkPost::with('author', 'tags')->latest()->get()->map(function ($post) {
            $post->featured_image = url($post->featured_image);
            $post->body = str_replace('"/storage/wink', '"' . url('/storage/wink//'), $post->body);
            $post->author->avatar = url($post->author->avatar);
            return $post;
        })];
    });

    Route::get('tags/{slug?}', function ($slug) {
        return ['news' => \Wink\WinkPost::with('author', 'tags')->whereHas('tags', function ($query) use ($slug) {
            return $query->where('tag_id', \Wink\WinkTag::where('slug', $slug)->firstOrFail()->id);
        })->latest()->get()->map(function ($post) {
            $post->featured_image = url($post->featured_image);
            $post->body = str_replace('"/storage/wink', '"' . url('/storage/wink//'), $post->body);
            $post->author->avatar = url($post->author->avatar);
            return $post;
        })];
    });


    Route::get('companies', function () {
        return \App\Company::all();
    });

    Route::get('fetch', function () {
        \App\Company::where('income', '0')->get()->each(function ($company) {
            print($company->symbol);
            $data = Http::timeout(2)->get('https://bizmandu.com/__stock/tearsheet/financial/keyStats/?tkr=' . $company->symbol)['message']['data'][0] ?? false;
            if ($data && ($data['GrowthOverPriorPeriod'] ?? false)) {
                $company->growth = $data['GrowthOverPriorPeriod'] * 100;
                $company->eps = $data['EpsAnnualized'];
                $company->bvps = $data['BookValuePerShare'];
                $company->npl = ($data['NonPerformingLoanNplToTotalLoan'] ?? 0) * 100;
                $company->income = $data['NetIncome'] * 100;
            }

            $data = json_decode(file_get_contents('https://bizmandu.com/__stock/tearsheet/header/?tkr=' . $company->symbol))->message->latestPrice ?? false;
            if ($data)
                $company->price = $data;

            $company->save();
        });
    });
