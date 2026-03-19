<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class GroqService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->baseUrl = "https://api.groq.com/openai/v1/chat/completions";
    }

    /**
     * Single-turn chat (1 pertanyaan)
     */
    public function chat($message)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl, [
                    "model" => "openai/gpt-oss-120b",
                    "messages" => [
                        [
                            "role" => "user",
                            "content" => $message
                        ]
                    ],
                    "temperature" => 0.7,
                    "max_tokens" => 512
                ]);

            return [
                'status' => $response->status(),
                'data' => $response->json(),
                'success' => $response->successful()
            ];

        } catch (RequestException $e) {

            return [
                'status' => $e->response?->status() ?? 500,
                'data' => [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                'success' => false
            ];
        }
    }

    /**
     * Multi-turn chat (chat history)
     */
    public function chatWithHistory($messages)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl, [
                    "model" => "openai/gpt-oss-120b",
                    "messages" => $messages,
                    "temperature" => 0.7,
                    "max_tokens" => 512
                ]);

            return [
                'status' => $response->status(),
                'data' => $response->json(),
                'success' => $response->successful()
            ];

        } catch (RequestException $e) {

            return [
                'status' => $e->response?->status() ?? 500,
                'data' => [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                'success' => false
            ];
        }
    }
}
