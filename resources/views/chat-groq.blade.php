<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Chat Groq (Web Service)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                @livewire('groq-chat') {{-- ✅ SUDAH SESUAI --}}
            </div>

        </div>
    </div>
</x-app-layout>
