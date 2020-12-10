<?php


namespace App\Services;


use App\Repositories\Enums\CrawlEnum;
use Illuminate\Support\Str;
use QL\QueryList;
use Spatie\Valuestore\Valuestore;

class CrawlService
{
    /**
     * 爬取 Github Trending
     *
     * @param  array  $request
     * @return array
     */
    public function handleCrawlTrending(array $request): array
    {
        $crawlSetting = $this->handleSearchCrawlSetting(CrawlEnum::GITHUB_TRENDING);

        $url = $crawlSetting['url'];
        if ($request['language']) {
            $url .= "/{$request['language']}";
        }

        $query = [
            'since' => $request['since'],
        ];

        if ($request['spoken_language']) {
            $query['spoken_language_code'] = $request['spoken_language'];
        }

        $url .= '?'.http_build_query($query);

        $data = $this->crawl($url, $crawlSetting['rules'], $crawlSetting['range']);

        return $data->map(function ($row) use ($request) {
            $row['language'] = $request['language'] ?? 'any';
            $row['spoken_language'] = $request['spoken_language'];

            foreach ($row as $key => &$value) {
                $value = str_replace(["\"", "\n"], '', trim($value));
                if (!in_array($key, ['description', 'added_stars'])) {
                    $value = str_replace(" ", '', $value);
                }
            }

            return $row;
        })->all();
    }

    /**
     * 查询爬取规则
     *
     * @param  string  $crawlEnumVal
     * @return array|string|null
     */
    public function handleSearchCrawlSetting(string $crawlEnumVal)
    {
        return Valuestore::make(resource_path('crawl/github.json'))->get($crawlEnumVal);
    }

    /**
     * 执行爬取
     *
     * @param  string  $url
     * @param  array  $rules
     * @param  string  $range
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function crawl(string $url, array $rules, string $range)
    {
        return QueryList::getInstance()->get($url)->rules($rules)->range($range)->query()->getData();
    }

    /**
     * 爬取 github trending 语种
     *
     * @return array
     */
    public function handleCrawlTrendingSpokenLanguages(): array
    {
        $crawlSetting = $this->handleSearchCrawlSetting(CrawlEnum::GITHUB_TRENDING_SPOKEN_LANGUAGE);

        $data = $this->crawl($crawlSetting['url'], $crawlSetting['rules'], $crawlSetting['range']);

        return $data->map(function (&$item) {
            $item['code'] = Str::substr($item['code'], -2);
            return $item;
        })->all();
    }

    /**
     * 爬取 github trending 编程语言
     *
     * @return array
     */
    public function handleCrawlTrendingLanguages(): array
    {
        $crawlSetting = $this->handleSearchCrawlSetting(CrawlEnum::GITHUB_TRENDING_LANGUAGE);

        $data = $this->crawl($crawlSetting['url'], $crawlSetting['rules'], $crawlSetting['range']);

        return $data->map(function (&$item) {
            $item['code'] = last(explode('/', current(explode('?', $item['code']))));
            return $item;
        })->all();
    }
}
