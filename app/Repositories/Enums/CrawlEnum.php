<?php


namespace App\Repositories\Enums;


use Jiannei\Enum\Laravel\Enum;

class CrawlEnum extends Enum
{
    public const GITHUB_TRENDING = 'github:trending';
    public const GITHUB_TRENDING_SPOKEN_LANGUAGE = 'github:trending:spoken-language';
    public const GITHUB_TRENDING_LANGUAGE = 'github:trending:language';
}
