
<div class="flex flex-col h-[600px] bg-white border rounded">

    <!-- HEADER -->
    <div class="p-4 border-b font-bold">
        🤖 AI Chat (Groq)
    </div>

    <!-- CHAT AREA -->
    <div class="flex-1 overflow-y-auto p-4 space-y-3">

        @forelse($messages as $msg)

            @if($msg['role'] === 'user')
                <!-- USER MESSAGE -->
                <div class="flex justify-end">
                    <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg max-w-xs">
                        {{ $msg['content'] }}
                    </div>
                </div>
            @else
                <!-- AI MESSAGE -->
                <div class="flex justify-start">
                    <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg max-w-xs">
                        {{ $msg['content'] }}
                    </div>
                </div>
            @endif

        @empty
            <p class="text-gray-400 text-center">Belum ada percakapan</p>
        @endforelse

        <!-- LOADING -->
        <div wire:loading class="text-blue-500 text-sm">
            AI sedang berpikir...
        </div>

    </div>

    <!-- FOOTER INPUT -->
    <div class="p-4 border-t">

        <div class="flex gap-2">
            <input
                type="text"
                wire:model="prompt"
                wire:keydown.enter="sendRequest"
                class="flex-1 border rounded px-3 py-2"
                placeholder="Ketik pertanyaan..."
            >

            <button
                wire:click="sendRequest"
                class="bg-indigo-600 text-white px-4 py-2 rounded">
                Kirim
            </button>
        </div>

        <!-- MONITORING -->
        <div class="mt-2 text-xs text-gray-500 flex gap-4">
            <span>Status: {{ $statusCode }}</span>
            <span>Latency: {{ $latency }}s</span>
        </div>

    </div>

</div>
