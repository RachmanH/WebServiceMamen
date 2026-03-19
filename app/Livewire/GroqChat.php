<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GroqService;

class GroqChat extends Component
{
    public $messages = [];   // ✅ WAJIB ADA
    public $prompt = '';
    public $statusCode = 0;
    public $latency = 0;

    public function sendRequest(GroqService $groq)
    {
        $this->validate([
            'prompt' => 'required|min:3'
        ]);

        // simpan pesan user
        $this->messages[] = [
            'role' => 'user',
            'content' => $this->prompt
        ];

        $start = microtime(true);

        $result = $groq->chatWithHistory($this->messages);

        $this->latency = round(microtime(true) - $start, 2);
        $this->statusCode = $result['status'];

        if ($result['success']) {

            $reply = $result['data']['choices'][0]['message']['content'] ?? 'Kosong';

            $this->messages[] = [
                'role' => 'assistant',
                'content' => $reply
            ];

        } else {

            $this->messages[] = [
                'role' => 'assistant',
                'content' => 'Error: ' . ($result['data']['error']['message'] ?? 'Gagal')
            ];
        }

        $this->prompt = '';
    }

    public function render()
    {
        return view('livewire.groq-chat');
    }

}
