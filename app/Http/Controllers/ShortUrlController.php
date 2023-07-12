<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreShortUrlRequest;
use App\Models\ShortUrl;
use App\Services\ShortUrlGenerator;

class ShortUrlController extends Controller
{
    /**
     *  Return message when empty body on POST request.
     */
    public function index()
    {
        return response()->json(['message' => 'Empty body or wrong keys. Make sure to post body as example: {\'url\' : \'https://laravel.com/\'}'], 400);
    }

    /**
     * Store short url.
     */
    public function store(StoreShortUrlRequest $request)
    {
        if(!$request->validated()){
            return response()->json(['message' => 'Invalid data'], 400);
        }

        $url = $request->url;

        // check if long url exist in db
        $longUrlExist = ShortUrl::where('url', $url)->first();

        if ($longUrlExist) {
            return response()->json([ 'url' => $longUrlExist->short_url ], 201);
        }

        $shortUrl = $this->generateShortUrl($url);

        $newEntry = ShortUrl::create([
            'url' => $url,
            'short_url' => $shortUrl,
        ]);

        return response()->json([ 'short_url' => $newEntry->short_url ], 201);
    }

    /**
     * return long url.
     */
    public function show(string $shortUrl)
    {
        $cacheKey = 'short_url_' . $shortUrl;
        $cachedData = Cache::get($cacheKey);

        if ($cachedData) {
            return response()->json( ["url" => $cachedData['url'] ], 200);
        }
        
        $shortUrl = ShortUrl::where('short_url', $shortUrl)->first();

        if (!$shortUrl) {
            return response()->json(['message' => 'Not found'], 404);
        }

        Cache::put($cacheKey, $shortUrl, 60); // Cache the data for 60 minutes

        return response()->json(["url" => $shortUrl->url], 200);
    }

    /**
     * Generate short url.
     */
    public function generateShortUrl($url, $length = 11)
    {
        $shortUrl = ShortUrlGenerator::generateShortUrl($url, $length);

        if($this->getFirstByShortUrl($shortUrl)){
            $this->generateShortUrl($url);
        }

        return $shortUrl;
    }

    public function getFirstByShortUrl($shortUrl)
    {
        return ShortUrl::where('short_url', $shortUrl)->first();
    }

}
