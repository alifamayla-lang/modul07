@extends('layouts.app')

@section('title', 'Forum Chat Lalu Lintas')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 sm:py-8">

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden flex flex-col h-[75vh]">
        
        <!-- Chat Header -->
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between bg-white z-10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-orange-600 text-white flex items-center justify-center text-lg shadow-md shadow-orange-500/20">
                    <i class="fas fa-comments"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-lg font-extrabold text-gray-900 leading-tight">Forum Komunitas Lalu Lintas</h2>
                    <p class="text-xs text-gray-500 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Obrolan aktif sesama pengendara Kota Bandung
                    </p>
                </div>
            </div>
            <div class="text-xs text-gray-400 font-semibold hidden sm:block">
                Login sebagai: <span class="text-orange-600 font-bold">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Chat Messages Container -->
        <div id="chatMessages" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4 bg-gray-50/70">
            @forelse($messages as $msg)
                @php
                    $isMe = ($msg->sender === Auth::user()->name);
                @endphp
                <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                    <div class="flex items-baseline gap-2 mb-1">
                        <span class="text-xs font-bold {{ $isMe ? 'text-orange-700' : 'text-gray-700' }}">{{ $msg->sender }}</span>
                        <span class="text-[10px] text-gray-400">{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                    <div class="max-w-[85%] sm:max-w-[70%] p-3.5 rounded-2xl text-xs sm:text-sm shadow-sm leading-relaxed {{ $isMe ? 'bg-orange-600 text-white rounded-tr-none' : 'bg-white text-gray-800 border border-gray-200 rounded-tl-none' }}">
                        {{ $msg->message }}
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400 text-xs">
                    Belum ada obrolan. Jadilah yang pertama menyapa komunitas!
                </div>
            @endforelse
        </div>

        <!-- Chat Input Form -->
        <div class="p-4 bg-white border-t border-gray-100">
            <form action="{{ route('chat.store') }}" method="POST" class="flex items-center gap-2">
                @csrf
                <div class="relative flex-1">
                    <input type="text" name="message" required autofocus
                        placeholder="Tulis informasi atau pertanyaan seputar kondisi jalanan..."
                        class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs sm:text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                </div>
                <button type="submit"
                    class="px-5 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-2xl shadow-md shadow-orange-500/20 transition flex items-center gap-1.5 flex-shrink-0">
                    <span class="hidden sm:inline">Kirim</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-scroll ke pesan terbawah
    window.onload = function() {
        var container = document.getElementById('chatMessages');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    };
</script>
@endpush
