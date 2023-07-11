<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
//use App\Models\ShortUrl;

class ShortUrlController extends Controller
{
    /**
     *  Return message when empty body on POST request.
     */
    public function index()
    {
        return response()->json([ 
            'message' => 'Send post request with body as example: {\'url\':\'https://www.google.com\'}' 
        ]);
    }

    /**
     * Store short url.
     */
    public function store(StoreShortUrlRequest $request)
    {
        return response()->json([ 'short_url' => $request->validated() ]);
    }

    /**
     * return long url.
     */
    public function show(string $shortUrl)
    {
        return response()->json([ 'short_url' => $shortUrl]);
    }
}
