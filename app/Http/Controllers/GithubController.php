<?php


namespace App\Http\Controllers;


use App\Services\CrawlService;
use Illuminate\Http\Request;
use Jiannei\Response\Laravel\Support\Facades\Response;

class GithubController extends Controller
{
    /**
     * @var CrawlService
     */
    private CrawlService $service;

    public function __construct(CrawlService $service)
    {
        $this->service = $service;
    }

    public function trending(Request $request, $language = null)
    {
        $this->validate($request, [
            'spoken_language' => 'nullable|string',
            'since' => 'nullable|string|in:daily,weekly,monthly'
        ]);

        $spoken_language = $request->get('spoken_language');
        $since = $request->get('since', 'daily');

        $data = $this->service->handleTrending(compact('spoken_language', 'since', 'language'));

        return Response::success($data);
    }

    public function spokenLanguages()
    {
        $data = $this->service->handleTrendingSpokenLanguages();

        return Response::success($data);
    }

    public function languages()
    {
        $data = $this->service->handleTrendingLanguages();

        return Response::success($data);
    }
}
