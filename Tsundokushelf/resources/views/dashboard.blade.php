<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
<form method="GET" action="{{ route('dashboard') }}" id="filterForm" class="max-w-3xl mx-auto mb-7 pt-7 px-4">
    <div class="flex flex-wrap sm:flex-nowrap gap-2 items-center">
        <input type="text" name="keyword" placeholder="本のタイトルや著者で検索" value="{{ request('keyword') }}"
            class="border rounded p-2 flex-grow min-w-[200px]">

        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded whitespace-nowrap mr-5">検索</button>

        <div class="flex gap-2 items-center">
            @foreach (['未読', '読書中', '読了'] as $status)
                <label class="text-sm">
                    <input type="checkbox" name="status[]" value="{{ $status }}"
                        {{ in_array($status, (array) request('status')) ? 'checked' : '' }}>
                    {{ $status }}
                </label>
            @endforeach
        </div>

        <select name="sort" onchange="this.form.submit()" class="border rounded p-2 text-sm">
            <option value="">並び替え</option>
            <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>登録日（新しい順）</option>
            <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>登録日（古い順）</option>
            <option value="finished_at_desc" {{ request('sort') == 'finished_at_desc' ? 'selected' : '' }}>読了日（新しい順）</option>
            <option value="finished_at_asc" {{ request('sort') == 'finished_at_asc' ? 'selected' : '' }}>読了日（古い順）</option>
        </select>
    </div>
    @if (request('keyword') || request('status'))
    <p class="text-gray-600 mb-4">
        検索結果：{{ $books->total() }}件
    </p>
    @endif
</form>

@if ($books->isEmpty())
<p class="min-h-screen text-gray-500 text-lg mt-10 text-center">まだ本が登録されていません。</p>
@else


<div class="py-6">
    <div class="max-w-5xl mx-auto space-y-6 px-4">
        @foreach ($books as $book)
            <div class="flex items-start justify-between border-b pb-4 gap-4">
                <!-- 表紙 -->
                <div class="flex-shrink-0">
                    @if ($book->cover_path)
                        @if (Str::startsWith($book->cover_path, 'http'))
                            <img src="{{ $book->cover_path }}" alt="表紙" class="w-24">
                        @else
                            <img src="{{ asset('storage/' . $book->cover_path) }}" alt="表紙" class="w-24">
                        @endif
                    @else
                        <img src="{{ url('/book-cover/' . $book->id) }}" alt="自動生成表紙" class="w-24">
                    @endif
                </div>

                <!-- 情報 -->
                <div class="flex-grow">
                    <h3 class="font-bold text-lg">{{ $book->title }}</h3>
                    <p>著者：{{ $book->author ?? '不明' }}</p>
                    <p>ステータス：{{ $book->status }}</p>
                    <p>メモ：{{ $book->notes }}</p>
                    <p class="{{ $book->is_public ? 'text-green-600' : 'text-gray-500' }}">{{ $book->is_public ? '公開中' : '非公開' }}</p>
                    <a href="{{ route('books.edit', $book) }}" class="text-blue-500 hover:underline text-sm">編集する</a>
                </div>

                <!-- 削除ボタン -->
                <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">削除</button>
                </form>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
</div>
    </div>
@endif
    <footer>
        @include('layouts.footer')
    </footer>
</x-app-layout>
