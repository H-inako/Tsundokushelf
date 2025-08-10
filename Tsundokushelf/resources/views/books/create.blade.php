
<x-layout>
    <div class="container mx-auto p-10 w-max">
        <h1 class="text-2xl text-center mb-5">本の登録</h1>

        @if(session('success'))
            <div style="color: green;" class="text-center">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div style="color: red;" class="text-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">ISBN</label>
                <input class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" type="text" id="isbn" name="isbn" value="{{ old('isbn') }}">
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">タイトル</label>
                <input class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">著者</label>
                <input class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" type="text" id="author" name="author" value="{{ old('author') }}">
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">表紙画像</label>
                <input class="block w-full sm:w-2/3 py-2 px-3"  type="file" name="cover">
                <input type="hidden" name="cover_url" id="cover-url">
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row hidden" id="cover-preview-container">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">表紙プレビュー</label>
                <img id="cover-preview" src="" alt="表紙プレビュー" style="width:100px; display:none;">
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">形式</label>
                <select class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" name="format" required>
                    <option value="紙" {{ old('format') == '紙' ? 'selected' : '' }}>紙</option>
                    <option value="電子" {{ old('format') == '電子' ? 'selected' : '' }}>電子</option>
                </select>
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">ステータス</label>
                <select class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" name="status" required>
                    <option value="未読" {{ old('status') == '未読' ? 'selected' : '' }}>未読</option>
                    <option value="読書中" {{ old('status') == '読書中' ? 'selected' : '' }}>読書中</option>
                    <option value="読了" {{ old('status') == '読了' ? 'selected' : '' }}>読了</option>
                </select>
            </div>

            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">メモ・感想</label>
                <textarea class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" name="notes">{{ old('notes') }}</textarea>
            </div>
            <div class="my-3 flex sm:items-center flex-col sm:flex-row">
                <label class="block sm:w-1/3 font-bold sm:text-right mb-1 pr-4">読了日</label>
                <input class="block w-full sm:w-2/3 bg-gray-200 py-2 px-3 text-gray-700 border border-gray-200 rounded focus:outline-none focus:bg-white" type="date" name="finished_at" value="{{ old('finished_at') }}">
            </div>
            <div class="mb-4 flex justify-center">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_public" value="1" class="form-checkbox text-blue-500">
                    <span class="ml-2">この本を公開する</span>
                </label>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">登録</button>
            </div>
        </form>
        @vite('resources/js/app.js')
    </div>
</x-layout>
