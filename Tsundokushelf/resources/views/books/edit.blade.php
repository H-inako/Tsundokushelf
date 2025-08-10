<x-layout>
    <div class="max-w-xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">本を編集</h2>

        <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <p>タイトル：{{ $book->title }}</p>
                <p>著者：{{ $book->author ?? '不明' }}</p>
            </div>
                    @if ($book->cover_path)
                        @if (Str::startsWith($book->cover_path, 'http'))
                            <img src="{{ $book->cover_path }}" alt="表紙" width="100">
                        @else
                            <img src="{{ asset('storage/' . $book->cover_path) }}" alt="表紙" width="100">
                        @endif
                    @else
                        <img src="{{ url('/book-cover/' . $book->id) }}" alt="自動生成表紙" width="100">
                    @endif
            <div>
                <label>表紙画像を変更</label>
                <input type="file" name="cover">
            </div>
            <div class="mb-4">
                <label class="block mb-1">感想・メモ</label>
                <textarea name="notes" class="w-full border p-2">{{ old('notes', $book->notes) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">ステータス</label>
                <select name="status" class="border p-2 w-full">
                    @foreach (['未読', '読書中', '読了'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $book->status) === $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>読了日</label>
                <input type="date" name="finished_at" value="{{ old('finished_at') }}">
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_public" value="1" class="form-checkbox" @checked(old('is_public', $book->is_public))>
                    <span class="ml-2">この本を公開する</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
        </form>
    </div>
</x-layout>
