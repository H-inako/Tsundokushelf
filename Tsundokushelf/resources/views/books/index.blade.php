@php use Illuminate\Support\Str; @endphp
<x-layout>
<div class="min-h-screen">
    @guest
        <section class="text-center py-16 bg-yellow-50">
            <h1 class="text-3xl font-bold mb-4">ようこそ TsundokuShelf へ</h1>
            <p class="mb-6">読みかけの本を記録して、あなたの本棚を作りましょう。</p>
            <a href="{{ route('register') }}"
                class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 transition">
                新規登録してはじめる
            </a>
        </section>
    @endguest

    @auth
        @if ($nextBook)
            <section class="text-center py-16 bg-yellow-50">
                <h2 class="text-2xl font-semibold mb-4">次はこれを読みませんか？</h2>
                <a href="{{ route('books.edit', $nextBook) }}">
                <div class="inline-block bg-white shadow-md rounded p-6 px-20">
                    <img src="{{ $nextBook->cover_path ? (Str::startsWith($nextBook->cover_path, 'http') ? $nextBook->cover_path : asset('storage/' . $nextBook->cover_path)) : url('/book-cover/' . $nextBook->id)}}"
                        alt="{{ $nextBook->title }}" class="w-40 h-60 mx-auto mb-4 object-cover">
                    <h3 class="text-xl font-bold">{{ $nextBook->title }}</h3>
                    <p class="text-gray-600">{{ $nextBook->author ?? '不明' }}</p>
                    <p class="text-sm text-gray-500 mt-2">ステータス: {{ $nextBook->status }}</p>
                </div>
                </a>
            </section>
        @endif
    @endauth
    <div class="container mx-auto p-10">
        <h1 class="text-center text-3xl">みんなの本棚</h1>
        <div id="book-carousel" class="splide pb-9 mt-8">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($books as $book)
                        <li class="splide__slide">
                            <div class="bg-white rounded p-4 text-center">
                                <img src="{{ $book->cover_path ? (Str::startsWith($book->cover_path, 'http') ? $book->cover_path: asset('storage/' . $book->cover_path)): url('/book-cover/' . $book->id) }}" alt="{{ $book->title }}" class="w-40 h-60 mx-auto object-cover mb-2">
                                <h3 class="font-semibold">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $book->author ?? '不明' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</x-layout>
