<?php

use App\Repositories\Enums\CrawlEnum;

return [
    'github' => [
        CrawlEnum::GITHUB_TRENDING => [
            "url" => "https://github.com/trending",
            "rules" => [
                "repo" => ["h1 a", "href"],
                "description" => ["p", "text"],
                "language" => ["span[itemprop='programmingLanguage']", "text"],
                "stars" => ["div:eq(1) a:eq(0)", "text"],
                "forks" => ["div:eq(1) a:eq(1)", "text"],
                "added_stars" => ["span:last", "text"]
            ],
            "range" => ".Box .Box-row"
        ],
        CrawlEnum::GITHUB_TRENDING_LANGUAGE => [
            "url" => "https://github.com/trending",
            "rules" => [
                "code" => ["", "href"],
                "name" => ["span", "text"]
            ],
            "range" => "#languages-menuitems a[role='menuitemradio']"
        ],
        CrawlEnum::GITHUB_TRENDING_SPOKEN_LANGUAGE => [
            "url" => "https://github.com/trending",
            "rules" => [
                "code" => ["", "href"],
                "name" => ["span", "text"]
            ],
            "range" => "div[data-filterable-for='text-filter-field-spoken-language'] a[role='menuitemradio']"
        ]
    ]
];
