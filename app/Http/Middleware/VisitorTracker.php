<?php

namespace App\Http\Middleware;

use App\Services\VisitorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorTracker
{
    protected VisitorService $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // ข้ามการบันทึกข้อมูลสำหรับ bots และ assets ต่างๆ
        $userAgent = $request->userAgent();
        $path = $request->path();

        $skipBots = ['bot', 'crawl', 'spider', 'slurp']; // คำที่มักพบใน user-agent ของ bots
        $skipAssets = ['.js', '.css', '.jpg', '.jpeg', '.png', '.gif', '.ico', '.svg'];

        $isBot = false;
        foreach ($skipBots as $bot) {
            if (stripos($userAgent, $bot) !== false) {
                $isBot = true;
                break;
            }
        }

        $isAsset = false;
        foreach ($skipAssets as $ext) {
            if (str_ends_with(strtolower($path), $ext)) {
                $isAsset = true;
                break;
            }
        }

        if (!$isBot && !$isAsset && $request->isMethod('GET')) {
            $this->visitorService->recordVisit($request);
        }

        return $next($request);
    }
}
