# Github Trending

Github api 没有提供 trending 查询接口，而且没有找到合适的 php 爬取实现，所以简单撸了一个。

已部署到 Heroku，可以直接访问地址体验：https://crawl-github-trending.herokuapp.com/

Github Trending 原始页面：https://github.com/trending

## 接口清单

### Trending Api

接口地址：https://crawl-github-trending.herokuapp.com/github/trending/{language}

请求参数：

- language：支持的编程语言；可以先调用下面的 Language 接口来查看支持哪些编程语言编码。
- spoken_language：支持的语种编码，比如，zh 表示中文；可以先调用下面的 Spoken language 接口来查看支持哪些语种编码。
- since：时间周期，支持 daily,weekly,monthly

接口响应：

```json
{
    "status": "success",
    "code": 200,
    "message": "Success.",
    "data": [
        {
            "repo": "/Jiannei/lumen-api-starter",
            "description": "",
            "language": "php",
            "stars": "66,666",
            "forks": "666",
            "added_stars": "66 stars today",
            "spoken_language": "zh"
        }
    ],
    "error": []
}
```

举例：

- 查询当天中文区的 php 项目趋势：https://crawl-github-trending.herokuapp.com/github/trending/php?spoken_language=zh
- 查询本周中文区的 php 项目趋势：https://crawl-github-trending.herokuapp.com/github/trending/php?spoken_language=zh&since=weekly

### Spoken language

接口地址：https://crawl-github-trending.herokuapp.com/github/spoken-languages

接口响应：

```json
{
    "status": "success",
    "code": 200,
    "message": "Success.",
    "data": [
        {
            "code": "zh",
            "name": "Chinese"
        },
        {
            "code": "en",
            "name": "English"
        }
    ],
    "error": []
}
```

### Language

接口地址：https://crawl-github-trending.herokuapp.com/github/languages

接口响应：

```json
{
    "status": "success",
    "code": 200,
    "message": "Success.",
    "data": [
        {
            "code": "c++",
            "name": "C++"
        },
        {
            "code": "html",
            "name": "HTML"
        },
        {
            "code": "java",
            "name": "Java"
        },
        {
            "code": "javascript",
            "name": "JavaScript"
        },
        {
            "code": "php",
            "name": "PHP"
        }
    ],
    "error": []
}
```

## 其他

### Packages

* [lumen-api-starter](https://github.com/Jiannei/lumen-api-starter) ：基于最新版 Lumen，遵循 Repository & Service 架构的实践项目。
* [jae-jae/querylist](https://github.com/jae-jae/querylist) ：优雅的渐进式PHP采集框架，让采集更简单一点。
* [spatie/valuestore](https://github.com/spatie/valuestore) ：维护配置到 json文件。

### 维护

爬取规则维护在 `resources/crawl/github.json` 文件中，如果接口失效，欢迎提交 pull request，或者联系我 `longjian.huang@foxmail.com` 进行更新，方便后续其他同学调用。
