<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GeminiAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY'); // Ambil API Key dari .env
    }

    /**
     * Kirim request ke Gemini AI API.
     *
     * @param string $prompt
     * @return array
     * @throws GuzzleException
     */
    public function generateContent($prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key={$this->apiKey}";

        try {
            $response = $this->client->post($url, [
                'json' => [
                    'contents' => [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $errorDetails = json_decode($response->getBody(), true);
            return ['error' => $errorDetails['error']['message']];
        }
    }
} // Akhir dari class GeminiAIService
