<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait RecaptchaEnterprise
{
    protected function verifyRecaptcha(Request $request, string $expectedAction): bool
    {
        $token = $request->input('g-recaptcha-response');
        $projectId = env('GOOGLE_RECAPTCHA_PROJECT_ID', config('services.recaptcha.project_id'));
        $apiKey = env('GOOGLE_RECAPTCHA_SECRET', config('services.recaptcha.secret'));
        if (! $token || ! $apiKey || ! $projectId) {
            return false;
        }

        try {
            $siteKey = env('GOOGLE_RECAPTCHA_KEY', config('services.recaptcha.site_key'));
            $url = "https://recaptchaenterprise.googleapis.com/v1/projects/{$projectId}/assessments?key={$apiKey}";

            $response = Http::timeout(5)->post($url, [
                'event' => [
                    'token' => $token,
                    'siteKey' => $siteKey,
                    'expectedAction' => $expectedAction,
                ],
            ]);

            $body = $response->json() ?: [];
            if ($response->failed()) {
                return false;
            }

            if (empty($body['tokenProperties']['valid'])) {
                return false;
            }

            if (($body['tokenProperties']['action'] ?? '') !== $expectedAction) {
                return false;
            }

            $scoreThreshold = env('GOOGLE_RECAPTCHA_SCORE_THRESHOLD', config('services.recaptcha.score_threshold', 0.3));
            if (isset($body['riskAnalysis']['score']) && $body['riskAnalysis']['score'] < $scoreThreshold) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function recaptchaFailed(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'reCAPTCHA verification failed.'], 422);
        }

        return redirect()->back()->withInput($request->except('g-recaptcha-response'))->withErrors([
            'g-recaptcha-response' => 'reCAPTCHA verification failed.',
        ]);
    }
}
