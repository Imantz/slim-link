<?php

namespace App\Services;

class ShortUrlGenerator
{
    public static function generateShortUrl(string $url = '', int $length = 11): string
    {
        $salt = bin2hex(random_bytes(4));
        $identifier = uniqid($salt, true);
        $hash = hash('sha256', $identifier);

        return substr($hash, 0, $length);
    }
}
