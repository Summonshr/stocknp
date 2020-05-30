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
