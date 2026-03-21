<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GroqService
{
    protected $apiKey;

    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
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
                        "role" => "system",
                        "content" => "Anda adalah asisten teknisi komputer dan laptop profesional.
                        Selalu gunakan Bahasa Indonesia.
                        Berikan solusi troubleshooting yang jelas dan step-by-step."
                    ],
                    [
                        "role" => "user",
                        "content" => $message
                    ]
                ],
                "temperature" => 0.7,
                "max_tokens" => 1000
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

            // ✅ SYSTEM PROMPT
            $systemPrompt = [
                'role' => 'system',
                'content' => 'Anda adalah asisten teknisi komputer dan laptop profesional.
            Selalu gunakan Bahasa Indonesia.
            Berikan jawaban yang jelas, praktis, dan step-by-step.
            Fokus pada troubleshooting hardware dan software.
            Jangan terlalu teoritis, utamakan solusi langsung.',
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer '.$this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl, [
                    'model' => 'openai/gpt-oss-120b',

                    // ✅ GABUNG SYSTEM + HISTORY
                    'messages' => array_merge([$systemPrompt], $messages),

                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                ]);

            return [
                'status' => $response->status(),
                'data' => $response->json(),
                'success' => $response->successful(),
            ];

        } catch (RequestException $e) {

            return [
                'status' => $e->response?->status() ?? 500,
                'data' => [
                    'error' => [
                        'message' => $e->getMessage(),
                    ],
                ],
                'success' => false,
            ];
        }
    }
}
