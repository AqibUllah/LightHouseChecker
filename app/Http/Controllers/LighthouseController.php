<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LighthouseController extends Controller
{
    public function getScore(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'strategy' => 'nullable|string',
        ]);

        $apiUrl = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
        $apiKey = "AIzaSyC4jDADvd_MbzrQauOiYUPvVF061372o-U";

        try {
            $response = Http::retry(3,100)
                ->withQueryParameters([
                    'url' => $request->url,
                    'strategy' => $request->strategy,
                    'key' => $apiKey,
                ])
                ->get($apiUrl);

            $data = json_decode($response->getBody(), true)['lighthouseResult'];

            // Helper function to extract title, description, and value
            $extractAuditData = function ($first_key,$second_key,$value_key='displayValue') use ($data) {
                $audit = $data[$first_key][$second_key];
                return [
                    'title' => $audit['title'] ?? null,
                    'description' => $audit['description'] ?? null,
                    'value' => ($audit[$value_key] ?? null),
                ];
            };

            return [

                'performance' => $extractAuditData('categories','performance','score'),
                'First_contentful_paint' => $extractAuditData('audits','first-contentful-paint'),
                'speed_index' => $extractAuditData('audits','speed-index'),
                'time_to_interactive' => $extractAuditData('audits','interactive'),
                'total_blocking_time' => $extractAuditData('audits','total-blocking-time'),
                'cumulative_layout_shift' => $extractAuditData('audits','cumulative-layout-shift'),
                'redirects' => $extractAuditData('audits','redirects','score'),
                'server_response_time' => $extractAuditData('audits','server-response-time','score'),
                'user_timings' => $extractAuditData('audits','user-timings','score'),

            ];
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
