<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait RecaptchaEnterprise
{
    protected function verifyRecaptcha(Request $request, string $expectedAction): bool
    {
        $token = $request->input('g-recaptcha-response');
        if (! $token) {
            return false;
        }

        $scoreThreshold = config('services.recaptcha.score_threshold', 0.3);
        $useEnterprise = filter_var(config('services.recaptcha.use_enterprise', false), FILTER_VALIDATE_BOOLEAN);
        $projectId = config('services.recaptcha.project_id');
        $enterpriseApiKey = config('services.recaptcha.enterprise_api_key') ?: config('services.recaptcha.secret');

        if ($useEnterprise && $projectId && $enterpriseApiKey) {
            $enterpriseVerified = $this->verifyRecaptchaEnterprise($token, $expectedAction, $scoreThreshold, $projectId, $enterpriseApiKey);
            if ($enterpriseVerified) {
                return true;
            }
        }

        return $this->verifyRecaptchaLegacy($token, $expectedAction, $scoreThreshold);
    }

    private function verifyRecaptchaEnterprise(string $token, string $expectedAction, float $scoreThreshold, string $projectId, string $apiKey): bool
    {
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

            if ($response->failed()) {
                return false;
            }

            $body = $response->json() ?: [];
            if (empty($body['tokenProperties']['valid'])) {
                return false;
            }

            if (($body['tokenProperties']['action'] ?? '') !== $expectedAction) {
                return false;
            }

            if (isset($body['riskAnalysis']['score']) && $body['riskAnalysis']['score'] < $scoreThreshold) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function verifyRecaptchaLegacy(string $token, string $expectedAction, float $scoreThreshold): bool
    {
        $secret = env('GOOGLE_RECAPTCHA_SECRET', config('services.recaptcha.secret'));
        if (! $secret) {
            return false;
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
            ]);

            if ($response->failed()) {
                return false;
            }

            $body = $response->json() ?: [];
            if (empty($body['success'])) {
                return false;
            }

            if (($body['action'] ?? '') !== $expectedAction) {
                return false;
            }

            if (isset($body['score']) && $body['score'] < $scoreThreshold) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
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
